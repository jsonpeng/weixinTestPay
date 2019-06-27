<?php

namespace App\Repositories;

use App\User;
use App\Models\CouponRule;
use InfyOm\Generator\Common\BaseRepository;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Storage;
use Image;
use Config;
use Log;
use App\Models\Caompany;
use App\Models\Project;

use Illuminate\Support\Facades\Cache;


class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    //处理推荐关系
    public function processRecommendRelation($user_openid, $parent_id)
    {
        $user = User::where('openid', $user_openid)->first();
        //新用户注册才算
        if (empty($user)) {
            //推荐关系
            $parent = $this->findWithoutFail($parent_id);
            $grandParent = null;
            $grandGrandParent = null;
            if (!empty($parent) && $parent->leader1) {
                $grandParent = $this->findWithoutFail($parent->leader1);
                if (!empty($grandParent) && $grandParent->leader1) {
                    $grandGrandParent = $this->findWithoutFail($grandParent->leader1);
                }
            }
            $leader1 = 0;
            $leader2 = 0;
            $leader3 = 0;
            if (!empty($parent)) {
                $leader1 = $parent->id;
                $parent->update(['level1' => $parent->level1 + 1]);
            }
            if (!empty($grandParent)) {
                $leader2 = $grandParent->id;
                $grandParent->update(['level2' => $grandParent->level2 + 1]);
            }
            if (!empty($grandGrandParent)) {
                $leader3 = $grandGrandParent->id;
                $grandGrandParent->update(['level3' => $grandGrandParent->level3 + 1]);
            }
            $first_level = \App\Models\UserLevel::orderBy('amount', 'asc')->first();
            $user_level  = empty($first_level) ? 0 : $first_level->id;
            $user = User::create([
                'openid' => $user_openid,
                'leader1' => $leader1,
                'leader2' => $leader2,
                'leader3' => $leader3,
                'user_level' => $user_level,
            ]);

        }
    }

    /**
     * 新用户注册事件
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    function newUserCreated($user) {
        
        //积分赠送
        $this->creditsForNewUser($user);
        //优惠券赠送
        $this->conponForNewUser($user);
    }

    /**
     * 分享二维码
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function erweima($user)
    {
        if (empty($user->share_qcode)) {
            $app = app('wechat.official_account');
            $result = $app->qrcode->forever($user->id);
            $url = $app->qrcode->url($result['ticket']);
            $user->update(['share_qcode' => $url]);
        }

        $share_img = public_path().'/qrcodes/user_share'.$user->id.'.png';

        if(!Storage::exists($share_img)){
            $qcode = Image::make($user->share_qcode)->resize(260, 260);
            $qcode->save($share_img, 70);
        }
        
        $share_img ='/qrcodes/user_share'.$user->id.'.png';
        return $share_img;
    }

    /**
     * 分享二维码
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function shareErweima($user)
    {
        if (empty($user->share_qcode)) {
            // $app = app('wechat.official_account');
            // $result = $app->qrcode->forever($user->id);
            // $url = $app->qrcode->url($result['ticket']);
            // $user->update(['share_qcode' => $url]);
        }
        $erweima = public_path().$user->Erweima;
        $share_img=public_path().'/qrcodes/user_share_'.$user->id.'.png';

        $this->dealWithErweimaImg($user,$erweima,$share_img);

        $share_img_path='http://'.$_SERVER['HTTP_HOST'].'/qrcodes/user_share_'.$user->id.'.png';
        return $share_img_path;
    }


    public function dealWithErweimaImg($user,$erweima,$share_img){
            $base_image = getSettingValueByKeyCache('user_center_share_bg');
            if (empty($base_image)) {
                $base_image = public_path().'/images/about.jpg';
            }
            #用户头像
            $head_image=$user->head_image;
            #背景图
            $img = Image::make($base_image);
            #二维码
            $qcode = Image::make($erweima)->resize(260, 260);
            #用户头像
            $head_image=Image::make($head_image)->resize(150,150);
            #先插头像
            $img->insert($head_image, 'bottom-left', 163, 174);
            #再插二维码
            $img->insert($qcode, 'bottom-center', 163, 174);

            $img->save($share_img, 70);   
    }


    /**
     * 微信授权登录,根据微信用户的授权信息，创建或更新用户信息
     * @param [mixed] $socialUser [微信用户对象]
     */
    public function CreateUserFromWechatOauth($socialUser)
    {
        $user = null;
        $unionid = null;
        $socialUser=optional($socialUser);
        //用户是否公众平台用户
        if (array_key_exists('unionid', $socialUser)) {
            $unionid = $socialUser['unionid'];
            $user = User::where('unionid', $socialUser['unionid'])->first(); 
        }
        //不是，则是否是微信用户
        if (empty($user)) {
            $user = User::where('openid', $socialUser['openid'])->first();
            if(!empty($socialUser) && !empty($user)){
                $user->update([
                  'name' => $socialUser['nickname'],
                  'nickname' => $socialUser['nickname'],
                  'head_image' => $socialUser['headimgurl'],
                  'sex' => empty($socialUser['sex']) ? '男' : $socialUser['sex'],
                  'province' => $socialUser['province'],
                  'city' => $socialUser['city'],
                  'oauth' => '微信',
              ]);
            }

        }
        
        if (is_null($user)) {
          if(!empty($socialUser)){
            // 新建用户
            $user = User::create([
                'openid' => $socialUser['openid'],
                'unionid' => $unionid,
                'name' => $socialUser['nickname'],
                'nickname' => $socialUser['nickname'],
                'head_image' => $socialUser['headimgurl'],
                'sex' => empty($socialUser['sex']) ? '男' : $socialUser['sex'],
                'province' => $socialUser['province'],
                'city' => $socialUser['city'],
                'user_level' => 1,
                'oauth' => '微信',
            ]);
            
         }
            
        }else{
          if(!empty($socialUser) && !empty($user)){
            //$user=$this->varifyUserMemberGuoQi($socialUser);
            $user->update([
                'nickname' => $socialUser['nickname'],
                'head_image' => $socialUser['headimgurl'],
                'sex' => empty($socialUser['sex']) ? '男' : $socialUser['sex'],
                'province' => $socialUser['province'],
                'city' => $socialUser['city']
            ]);
          }
        }
        return $user;
    }


    
  /**
   * 通过昵称模糊查询用户列表 返回用户id数组
   * @param  [type] $nickname [description]
   * @return [type]           [description]
   */
    public function getUserArrByNickName($nickname){
           $user_id=\App\User::where('nickname','like','%'.$nickname.'%')->select('id')->get();
            $user_arr=[];
            if(count($user_id)){
              foreach ($user_id as $k => $v) {
                array_push($user_arr, $v->id);
              }
          }
            return $user_arr;
    }

    /**
     * 检查有没有过期
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function varifyUserMemberGuoQi($user, $weixin_user){
            //Log::info('进入了验证:');
            #更新下昵称和用户信息
            if(!empty($weixin_user)){
              if(!empty($user)){
                $user->update([
                    'nickname' => $weixin_user['nickname'],
                    'head_image' => $weixin_user['headimgurl'],
                    'sex' => empty($weixin_user['sex']) ? '男' : $weixin_user['sex'],
                    'province' => $weixin_user['province'],
                    'city' => $weixin_user['city']
                ]);
            }
           }
            #注册会员就不用管
            if(optional($user->userlevel()->first())->name=='注册会员'){

              return $user;
            }
            #过期时间
            $end_time=$user->member_end_time;

            #过期的天数 大于0等于0就过期不计算
            $guoqi=Carbon::parse($end_time)->diffInDays(Carbon::now(),false);
            Log::info('过期:');
            Log::info($guoqi);
            #过期就重置会员
            if($guoqi >=0){
              $user->update([
                'user_level'=>1,
                'member_buy_time'=>null,
                'member_end_time'=>null,
                'is_distribute' =>0,
                'share_time'=>0,
                'distribute_time'=>0,
                'leader1'=>0
              ]);
              Log::info('验证过期');
            }
            return $user;
    }

}
