<?php 

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Config;
use Log;
//use EasyWeChat\Application;
use EasyWeChat\Factory;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
// use JWTAuth;

class AuthController extends Controller
{

/**
     * 微信授权登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function weixinAuth(Request $request){
        //存储客户端要跳转的链接
        $options = Config::get('wechat.official_account.default');
        $options['oauth'] = [
		      'scopes'   => ['snsapi_userinfo'],
		      'callback' => '/api/weixin_auth_callback',
		 ];
        //Log::info($options);
        $app = Factory::officialAccount($options);
        $response = $app->oauth->scopes(['snsapi_userinfo'])
                          ->redirect();
        return $response;
    }

    /**
     * 微信授权登录回调
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function weixinAuthCallback(Request $request){
        $options = Config::get('wechat.official_account.default');
        //Log::info($options);
        $app =Factory::officialAccount($options);
        $oauth = $app->oauth;
        // 获取 OAuth 授权结果用户信息
        $userinfo = $oauth->user();
        $user = User::where('openid', $userinfo->getId())->first();
        if (is_null($user)) {
            // 新建用户
            $user = User::create([
                'openid' => $userinfo->getId(),
                'nickname' => $userinfo->getNickname(),
                'head_image' => $userinfo->getAvatar(),
                ]);
            $token = zcjy_base64_en($user->id.'__'.strtotime($user->created_at).'__'.$user->openid.'__'.time());
            $rurl = sprintf("%s/#/home/%s", env('CLIENT', ''), $token);
            //Log::info($rurl);
            return redirect($rurl);
        }else{
            $user->update([
                'nickname' => $userinfo->getNickname(),
                'head_image' => $userinfo->getAvatar()
                ]);
            $token = zcjy_base64_en($user->id.'__'.strtotime($user->created_at).'__'.$user->openid.'__'.time());
            $rurl = sprintf("%s/#/home/%s", env('CLIENT', ''), $token);
            return redirect($rurl);
        }
    }

    /**
     * [微信分享]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function weixinShare(Request $request){
        $input = $request->all();
        $varify = app('zcjy')->varifyInputParam($input,['url']);
        if($varify){
                return zcjy_callback_data($varify,1);
        }
        $options = Config::get('wechat.official_account.default');
        $app =Factory::officialAccount($options);
        $app->jssdk->setUrl($input['url']);
        $param =  json_decode($app->jssdk->buildConfig(array('onMenuShareTimeline', 'onMenuShareAppMessage'), false),true);
        $param['url'] = $input['url'];
        return zcjy_callback_data($param);
    }   

}