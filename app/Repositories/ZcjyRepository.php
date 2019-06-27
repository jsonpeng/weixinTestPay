<?php

namespace App\Repositories;

use App\Models\Setting;
use InfyOm\Generator\Common\BaseRepository;
use App\Repositories\JobRepository;
use App\Repositories\SectionRepository;
use App\Repositories\JobSubjectRepository;
use App\Repositories\TopicRepository;
use App\Repositories\SelectionsRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserSeeLogsRepository;
use App\Repositories\UserBuyLogRepository;
use App\Repositories\UserPackagesRepository;
use App\Repositories\JobPackageRepository;
use App\Repositories\ExamLogRepository;
use App\Repositories\ExamTopicDetailRepository;
use App\Repositories\BannerRepository;
use App\Repositories\PostRepository;
use App\Repositories\MessagesRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use App\User;
use App\Models\FeedBack;
use App\Models\TopicMistake;
use Image;
use EasyWeChat\Factory;
use Carbon\Carbon;
use Excel;
use Hash;


class ZcjyRepository 
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    private $JobRepository;
    private $SectionRepository;
    private $JobSubjectRepository;
    private $TopicRepository;
    private $SelectionsRepository;
    private $UserRepository;
    private $UserSeeLogsRepository;
    private $UserBuyLogRepository;
    private $UserPackagesRepository;
    private $JobPackageRepository;
    private $ExamLogRepository;
    private $ExamTopicDetailRepository;
    private $BannerRepository;
    private $PostRepository;
    private $MessagesRepository;

    public function __construct(
      JobRepository $JobRepo,
      SectionRepository $SectionRepo,
      JobSubjectRepository $JobSubjectRepo,
      TopicRepository $TopicRepo,
      SelectionsRepository $SelectionsRepo,
      UserRepository $UserRepo,
      UserSeeLogsRepository $UserSeeLogsRepo,
      UserBuyLogRepository $UserBuyLogRepo,
      UserPackagesRepository $UserPackagesRepo,
      JobPackageRepository $JobPackageRepo,
      ExamLogRepository $ExamLogRepo,
      ExamTopicDetailRepository $ExamTopicDetailRepo,
      BannerRepository $BannerRepo,
      PostRepository $PostRepo,
      MessagesRepository $MessagesRepo
    )
    {
      $this->JobRepository = $JobRepo;
      $this->SectionRepository = $SectionRepo;
      $this->JobSubjectRepository = $JobSubjectRepo;
      $this->TopicRepository = $TopicRepo;
      $this->SelectionsRepository = $SelectionsRepo;
      $this->UserRepository = $UserRepo;
      $this->UserSeeLogsRepository = $UserSeeLogsRepo;
      $this->UserBuyLogRepository = $UserBuyLogRepo;
      $this->UserPackagesRepository = $UserPackagesRepo;
      $this->JobPackageRepository = $JobPackageRepo;
      $this->ExamLogRepository = $ExamLogRepo;
      $this->ExamTopicDetailRepository = $ExamTopicDetailRepo;
      $this->BannerRepository = $BannerRepo;
      $this->PostRepository = $PostRepo;
      $this->MessagesRepository = $MessagesRepo;
    }

    public function MessagesRepo(){
      return $this->MessagesRepository;
    }

    public function PostRepo(){
      return $this->PostRepository;
    }

    public function BannerRepo(){
      return $this->BannerRepository;
    }

    public function ExamTopicDetailRepo(){
      return $this->ExamTopicDetailRepository;
    }

    public function ExamLogRepo(){
      return $this->ExamLogRepository;
    }

    public function JobPackageRepo(){
      return $this->JobPackageRepository;
    }

    public function UserPackagesRepo(){
      return $this->UserPackagesRepository;
    }

    public function UserBuyLogRepo(){
        return $this->UserBuyLogRepository;
    }

    public function UserSeeLogsRepo(){
        return $this->UserSeeLogsRepository;
    }

    public function UserRepo(){
        return $this->UserRepository;
    }

    public function SelectionsRepo(){
      return $this->SelectionsRepository;
    }
    
    public function TopicRepo(){
      return $this->TopicRepository;
    }
    
    public function JobSubjectRepo(){
      return $this->JobSubjectRepository;
    }

    public function SectionRepo(){
      return $this->SectionRepository;
    }

    public function JobRepo(){
      return $this->JobRepository;
    }

    //清空缓存
    public function clearCache(){
        Artisan::call('cache:clear');
    }
    
    //批量直接更新 
    public function updateManyTopicsUt()
    {
     // \App\Models\Topic::where('topic_type','<>','普通题')->update(['union_type'=>1]);
      \App\Models\Topic::where('union_type','<>',0)
      ->where('type','文本')
      ->update(['type'=>'音频']);
    }

    /**
     * 提交反馈记录
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function saveFeedback($input)
    {
        $varify = $this->varifyInputParam($input,'content,grade');
        if($varify)
        {
          return zcjy_callback_data($varify,1);
        }
        $user = zcjy_api_user($input);
        $input['user_id'] = $user->id;
        FeedBack::create($input);
        return zcjy_callback_data('提交成功');
    }

    /**
     * 提交纠错
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function saveTopicMistake($input)
    {
        $varify = $this->varifyInputParam($input,'topic_id,question_type,content');
        if($varify)
        {
          return zcjy_callback_data($varify,1);
        }
        $user = zcjy_api_user($input);
        $input['user_id'] = $user->id;
        TopicMistake::create($input);
        return zcjy_callback_data('提交成功');
    }

    /**
     * 获取纠错信息列表
     * @return [type] [description]
     */
    public function getErrorList()
    {
      return zcjy_callback_data(getErrorList());
    }

    /**
     * [根据参数键值返回中文提示]
     * @param  [type] $key  [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    private function validation($key,$type=0)
    {
        $validation_arr = Config::get('validation');
        if(isset($validation_arr[$key]))
        {
            return  '请输入'.$validation_arr[$key];
        }
        else{
            return  '请输入'.$key;
        }
    }
    
    /**
     * [过滤空的输入]
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function filterNullInput($input)
    {
        foreach ($input as $key => $value) {
            if(is_null($value) || $value == '' || empty($value) && $value != 0){
               unset($input[$key]);
            }
        }
        return $input;
    }

    /**
     * [默认直接通过数组的值 否则通过数组的键]
     * @param  [type] $input      [description]
     * @param  array  $attr       [description]
     * @param  string $valueOrKey [description]
     * @return [type]             [description]
     */
    public function varifyInputParam($input,$attr=[],$valueOrKey='value')
    {
        $input = $this->filterNullInput($input);
        $status = false;
        if(!is_array($attr)){
            $attr = explode(',',$attr);
        }
        #一种是针对提交的指定键值
        if(count($attr)){
            foreach ($attr as $key => $val) {
                if($valueOrKey == 'value'){
                    if(!array_key_exists($val,$input)){
                        $status = $this->validation($val);
                    } 
                    if(array_key_exists($val,$input) && $input[$val] == null ){
                        $status = $this->validation($val,1);
                    }
                }
                else{
                     if(!array_key_exists($key,$input)){
                        $status = $this->validation($key);
                     } 
                     if(array_key_exists($key,$input) &&  $input[$key] == null){
                        $status =  $this->validation($key,1);
                    }
                }
            }
        }
        else{
           #另一种是带键值但值为空的情况
            foreach ($input as $key => $val) {
                if(array_key_exists($key,$input)){
                    if($input[$key] == null){
                        $status = $this->validation($key,1);
                    }
                }
            }
        }
        return $status;
    }

    /**
     * [通过用户信息生成密钥]
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function generateApiKey($user){
       return  Hash::make($user->id.','.getSettingValueByKey('token_key')).'_'.Hash::make(strtotime($user->created_at)).'_'.Hash::make($user->openid);
    }

    /**
     * [接口请求用户验证]
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function zcjyApiUserVarify($input){
         $status = false;
         if(isset($input['token']) && !empty($input['token'])){
        
            $token = optional(explode('__', zcjy_base64_de($input['token'])));
            //Log::info($token);
            $user = User::find($token[0]);
            if(empty($user)){
                $status = 'token信息验证失败,参数错误';
                return $status;
            }
            if(!isset($token[0]) || !isset($token[1]) || !isset($token[2]) || !isset($token[3])){
                $status = 'token信息验证失败,参数错误';
                return $status;
            }
            #开始验证token的详细细节
            if($user->id == $token[0]  && strtotime($user->created_at) == $token[1] && $user->openid == $token[2] ){
                $token_time =  empty(getSettingValueByKey('token_time')) ? 1 : getSettingValueByKey('token_time');
                #验证token时间
                if(time_diff($token[3],time())['hour'] >= $token_time){
                    $status = 'token信息验证失败,时间过期';
                }
                #验证密钥有效性
            }
            else{
                $status = 'token信息验证失败,参数错误';
            }

        }
        else{
            $status = 'token信息验证失败,参数错误';
        }
        return $status;
    }

    /**
     * [接口密钥校检]
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function zcjyApiKeyVarify($input){
          $user = zcjy_api_user($input);
          if(empty($user)){
               return zcjy_callback_data('token信息验证失败',401);
          }
          if(isset($input['key']) && !empty($input['key'])){
              $key_arr = explode('__',$input['key']);
              if(!isset($key_arr[0]) || !isset($key_arr[1]) || !isset($key_arr[2])){
                  return zcjy_callback_data('密钥key校检失败',10002);
              }
              if(!Hash::check($user->id.','.getSettingValueByKey('token_key'),$key_arr[0]) || !Hash::check(strtotime($user->created_at),$key_arr[1]) || !Hash::check($user->openid,$key_arr[2])){
                  return zcjy_callback_data('密钥key校检失败',10002);
              }
              return false;
          }
          else{
             return zcjy_callback_data('密钥key校检失败',10002);
          }
    }


    /**
     * [会员检查]
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function zcjyApiMemberVarify($input){
       $status =false;
        $user = zcjy_api_user($input);
        if(!empty($user)){
          if(empty($user->mobile) || empty($user->job)){
             $status = zcjy_callback_data('您没有注册,无法使用哦',10003);
             return $status;
          }
          $packages = $user->packages()->get();
          //return $user->packages()->get();
          if(count($packages)){
            if(array_key_exists('subject_id',$input) && !empty($input['subject_id'])){
                $status = zcjy_callback_data('您购买的职位不适用与该职位的试题,请购买对应职位的试题然后使用',10004);;
                $subject = $this->JobSubjectRepo()->findWithoutFail($input['subject_id']);
                if(!empty($subject)){
                    $job = $subject->job()->first();
                    if(!empty($job)){
                      foreach ($packages as $key => $val) {
                          if($val->job_id == $job->id){
                              $status = false;
                          }
                      }
                    }
                }
            }
            else{
              $status = false;
            }
          }
          else{
            if(count($user->seelogs()->get()) >= 3){
                $status = zcjy_callback_data('您的浏览次数已达到三次,如想继续浏览请购买会员',10001);
            }
        }
          // if($user->show_time < 0){
          //    $status = '您的免费查看次数已用完,请购买会员';
          // }
        }
      return $status;
    }

  /**
     * [处理图片的拍照方向]
     * @param  [type] $img        [description]
     * @param  [type] $image_path [description]
     * @return [type]             [description]
     */
    public function exifDealImg($image_path)
    {   
        $img = Image::make($image_path);

        try{
        @$exif=exif_read_data($image_path);
        //判断拍照方向
        if(isset($exif['Orientation'])) {
           switch($exif['Orientation']) {
            case 8:
             $img->rotate(90);
             break;
            case 3:
             $img->rotate(180);
             break;
            case 6:
             $img->rotate(-90);
             break;
           }
        }
      }catch(Exception $e){

      }

      return $img;
    }

    /**
     * [图片/文件 上传]
     * @param  [type] $file     [description]
     * @param  string $api_type [description]
     * @return [type]           [description]
     */
    public function uploadFiles($file , $api_type = 'web' , $user = null){
        if(empty($file)){
            return zcjy_callback_data('文件不能为空',1,$api_type);
        }
        #文件类型
        $file_type = 'file';
        #文件实际后缀
        $file_suffix = $file->getClientOriginalExtension();
        if(!empty($file)) {
              $img_extensions = ["png", "jpg", "gif","jpeg"];
              $sound_extensions = ["PCM","WAVE","MP3","OGG","MPC","mp3PRo","WMA","wma","RA","rm","APE","AAC","VQF","LPCM","M4A","cda","wav","mid","flac","au","aiff","ape","mod","mp3"];
              $excel_extensions = ["xls","xlsx","xlsm"];
              if ($file_suffix && !in_array($file_suffix , $img_extensions) && !in_array($file_suffix , $sound_extensions) && !in_array($file_suffix,$excel_extensions)) {
                  return zcjy_callback_data('上传文件格式不正确',1,$api_type);
              }
              if(in_array($file_suffix, $img_extensions)){
                  $file_type = 'image';
              }
              if(in_array($file_suffix, $sound_extensions)){
                $file_type = 'sound';
              }
              if(in_array($file_suffix,$excel_extensions)){
                $file_type = 'excel';
              }
          }

        #文件夹
        $destinationPath = empty($user) ? "uploads/admin/" : "uploads/user/".$user->id.'/';
        #加上类型
        $destinationPath = $destinationPath.$file_type.'/';

        if (!file_exists($destinationPath)){
            mkdir($destinationPath,0777,true);
        }
       
        $extension = $file_suffix;
        $fileName = str_random(10).'.'.$extension;
        $file->move($destinationPath, $fileName);

        #对于图片文件处理
        if($file_type == 'image'){
          $image_path=public_path().'/'.$destinationPath.$fileName;
       
          $img = Image::make($image_path);
          // $img->resize(640, 640);
          $img->save($image_path,70);
        }

        $host=\Request::root();
      
        #路径
        $path=$host.'/'.$destinationPath.$fileName;

        return zcjy_callback_data([
                'src'=>$path,
                'current_time' => Carbon::now(),
                'type' => $file_type,
                'current_src' => public_path().'/'.$destinationPath.$fileName
            ],0,$api_type);
    }

    //读取excel文件
    public function loadExcels($files){
       if (!file_exists($files)){
          //return zcjy_callback_data('没有找到该文件',1);
          return false;
       }
       $res = [];
       Excel::load($files, function($reader) use( &$res ) {
            $reader = $reader->getSheet(0);
            $res = $reader->toArray();
       }); 
       return $res;
    }

    //检查一下类型
    private function  varifyType($type){
        if (stripos($type,'文本') !== false){
            $type = '文本';
        }
        if (stripos($type,'图片') !== false){
            $type = '图片';
        }
        if (stripos($type,'音频') !== false){
            $type = '音频';
        }
        if($type != '文本' && $type != '图片' && $type != '音频'){
            $type = '文本';
        }
        return $type;
    }

    //检查一下文本内容
    private function varifyContent($content){
        return empty($content) ? '未知内容' : $content;
    }

    public function varifySort($sort){
      return preg_match("/^\d*$/",$sort) ? (int)$sort : select_sort_num($sort); 
    }

    //从读取的excel信息中自动生成题目和选项
    public function readExcelsToGenerate($files,$input){
      if(array_key_exists('subject_id',$input) && array_key_exists('sec',$input)){
        $res= $this->loadExcels($files);
        //dd($res);
        if(count($res) > 1){
            for ($i=1; $i < count($res); $i++) { 
                #先取出题目类型
                $type = $this->varifyType($res[$i][0]);
                #再取出题目name
                $name = $res[$i][1];
                if(!isset($res[$i][6])){
                  $res[$i][6] = 'A';
                  // return zcjy_callback_data('上传题目中第'.$i.'题未设置答案,请确认后上传',1,'web');
                }
                if(!isset($res[$i][7])){
                  $res[$i][7] = 0.625;
                }
                if(!isset($res[$i][8])){
                  $res[$i][8] = '普通题';
                }
                if(!isset($res[$i][9])){
                  $res[$i][9] = 0;
                }
                if(!isset($res[$i][10])){
                  $res[$i][10] = '';
                }
                if(!isset($res[$i][11])){
                  $res[$i][11] = '';
                }
                if(!isset($res[$i][12])){
                  $res[$i][12] = '';
                }
                if(!empty($name)){
                    if($type == '文本'){
                      #先生成题目
                      $topic = $this->TopicRepository->model()::create([
                        'type' => $type,
                        'name' => $name,
                        'sec_sort' => $input['sec'],
                        'num_sort' => $this->TopicRepository->getSubjectSecTopics($input['subject_id'],$input['sec'])->where('is_delete',0)->count() + 1,
                        'subject_id'=>$input['subject_id'],
                        'value' => $res[$i][7],
                        'topic_type' => $res[$i][8],
                        'union_type' => $res[$i][9],
                        'question' => dealStrSpace($res[$i][10]),
                        'attach_sound_url' => $res[$i][11],
                        'selection_sound_url' => $res[$i][12],
                      ]);
                      #再生成选项
                      $selection_a = $this->SelectionsRepository->model()::create([
                        'name' =>$res[$i][2],
                        'topic_id'=>$topic->id,
                        'type' => $type,
                        'sort' => 1,
                        'letter' => 'A'
                      ]);
                      $selection_b = $this->SelectionsRepository->model()::create([
                        'name' =>$res[$i][3],
                        'topic_id'=>$topic->id,
                        'type' => $type,
                        'sort' => 2,
                        'letter' => 'B'
                      ]);
                      $selection_c = $this->SelectionsRepository->model()::create([
                        'name' =>$res[$i][4],
                        'topic_id'=>$topic->id,
                        'type' => $type,
                        'sort' => 3,
                        'letter' => 'C'
                      ]);
                      $selection_d = $this->SelectionsRepository->model()::create([
                        'name' =>$res[$i][5],
                        'topic_id'=>$topic->id,
                        'type' => $type,
                        'sort' => 4,
                        'letter' => 'D'
                      ]);
                     #答案
                     $this->SelectionsRepository->model()::where('topic_id',$topic->id)
                     ->where('sort',$this->varifySort($res[$i][6]))
                     ->update([
                      'is_result' => 1
                     ]);
                   }
                   else{
                        #先生成题目
                        $topic = $this->TopicRepository->model()::create([
                          'type' => $type,
                          'attach_url' => $name,
                          'sec_sort' => $input['sec'],
                          'num_sort' => $this->TopicRepository->getSubjectSecTopics($input['subject_id'],$input['sec'])->where('is_delete',0)->count() + 1,
                          'subject_id'=>$input['subject_id'],
                           'value' => $res[$i][7],
                          'topic_type' => $res[$i][8],
                          'union_type' => $res[$i][9],
                          'question' => dealStrSpace($res[$i][10]),
                          'attach_sound_url' => $res[$i][11],
                          'selection_sound_url' => $res[$i][12],
                        ]);
                        #再生成选项
                        $selection_a = $this->SelectionsRepository->model()::create([
                          'attach_url' =>$res[$i][2],
                          'topic_id'=>$topic->id,
                          'type' => $type,
                          'sort' => 1,
                          'letter' => 'A'
                        ]);
                        $selection_b = $this->SelectionsRepository->model()::create([
                          'attach_url' =>$res[$i][3],
                          'topic_id'=>$topic->id,
                          'type' => $type,
                          'sort' => 2,
                          'letter' => 'B'
                        ]);
                        $selection_c = $this->SelectionsRepository->model()::create([
                          'attach_url' =>$res[$i][4],
                          'topic_id'=>$topic->id,
                          'type' => $type,
                          'sort' => 3,
                          'letter' => 'C'
                        ]);
                        $selection_d = $this->SelectionsRepository->model()::create([
                          'attach_url' =>$res[$i][5],
                          'topic_id'=>$topic->id,
                          'type' => $type,
                          'sort' => 4,
                          'letter' => 'D'
                        ]);
                       #答案
                       $this->SelectionsRepository->model()::where('topic_id',$topic->id)
                        ->where('sort',$this->varifySort($res[$i][6]))
                       ->update([
                        'is_result' => 1
                       ]);
                   }
                }
            }
            #新题目上传后自动清除缓存
            $this->clearCache();
            return zcjy_callback_data('自动生成题目成功',0,'web');
        }
        else{
          return zcjy_callback_data('excel中无内容',1,'web');
        }
      }
      else{
        return zcjy_callback_data('请求参数不完整',1,'web');
      }
    }

    /**
     * [当前用户的职位id组合]
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function userJobsArr($user){
        # 当前用户下的套餐
        $packages = $user->packages()->get();
        $job_arr = [];
        if(count($packages)){
          foreach ($packages as $key => $val) {
              array_push($job_arr,$val->job_id);
          }
        }
        return $job_arr;
    }

    public function varifyOverdue($end_time){
      return Carbon::parse($end_time)->lt(Carbon::now());
    }

    /**
     * 取消所有套餐记录
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function resetUserPackage($user_id)
    {
      $user = User::find($user_id);
      if(empty($user))
      {
        return zcjy_callback_data('没有找到该用户',0,'web');
      }
      $user->packages()->delete();
      return zcjy_callback_data('取消所有职位成功',0,'web');
    }

    /**
     * [创建用户套餐记录]
     * @param  [type] $user [description]
     * @param  [type] $log  [description]
     * @return [type]       [description]
     */
    public function generateUserPackage($user,$log){
       $log->update(['pay_status'=>'已支付']);
       $user_jobs_arr = $this->userJobsArr($user);
       $generate_attr = [
                'user_id'=>$user->id,
                'package_id'=>$log->package_id,
                'package_end'=>Carbon::now()->addMonths($log->package_month),
                'package_name'=>$log->package_name,
                'job_id' => $log->job_id
            ];
       if(count($user_jobs_arr)){
        # 如果用户当前有这个套餐
          if(in_array($log->job_id,$user_jobs_arr)){
              $user_package = $user->packages()->where('job_id',$log->job_id)->first();
              if(!empty($user_package)){
                ## 看下过期没
                ### 过期了直接从当前时间加
                if($this->varifyOverdue($user_package->package_end)){
                    $user_package->update($generate_attr);
                }### 没过期直接加月数
                else{
                    $generate_attr['package_end'] = Carbon::parse($user_package->package_end)->addMonths($log->package_month);
                    $user_package->update($generate_attr);
                }
              }
          }
          else{
             $this->UserPackagesRepository->create($generate_attr);
          }
        }
        else{
            $this->UserPackagesRepository->create($generate_attr);
        }
    }


    #把没有答案的题目删除掉
    public function setTopicResult(){
      $topics = app('zcjy')->TopicRepo()->all();
      foreach ($topics as $key => $topic) {
          $selections = $topic->selections()->get();
          $result_status = false;
          if(count($selections)){
            foreach ($selections as $key => $selection) {
                if($selection->is_result){
                    $result_status = true;
                }
            }
            if(!$result_status){
              $topic->delete();
            }
          }
      }
    }

    public function autoWropTopic()
    {
        $topics = app('zcjy')->TopicRepo()->model()::where('type','音频')
        ->where('topic_type','<>','普通题')
        ->whereNotNull('question')
        // ->where('question','like','%<br/>S1%')
        ->get();

     

        foreach ($topics as $key => $topic) 
        {
          
         $question = str_replace('S1','<br/>S1',$topic->question);
         $question = str_replace('S2','<br/>S2',$topic->question);
         $question = ltrim($question,'<br/>');
         
            // $question = substr($topic->question, 5);
            $topic->update(['question'=>$question]);
          
            
        }
    }


    private function str_prefix($str, $n=1, $char=" "){
      for ($x=0;$x<$n;$x++){$str = $char.$str;}
      return $str;
    }

   
}
