<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use Illuminate\Support\Facades\Artisan;
use Log;
use Illuminate\Support\Facades\Input;


class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

     /**
     * 后台显示获取分页数目
     * @return [int] [分页数目]
     */
    public function defaultPage(){
        return empty(getSettingValueByKey('records_per_page')) ? 15 : getSettingValueByKey('records_per_page');
    }

    /**
     * 验证是否展开
     * @return [int] [是否展开tools 0不展开 1展开]
     */
    public function varifyTools($input,$order=false){
        $tools=0;
        if(count($input)){
            $tools=1;
            if(array_key_exists('page', $input) && count($input)==1) {
                $tools = 0;
            }
            if($order){
                if(array_key_exists('menu_type', $input) && count($input)==1) {
                    $tools = 0;
                }
            }
        }
        return $tools;
    }

    /**
     * 倒序显示带分页
     */
    public function descAndPaginateToShow($obj,$attr="created_at",$sort="desc"){
       if(!empty($obj)){
      		return $obj->orderBy($attr,$sort)->paginate($this->defaultPage());
	    }else{
	        return [];
	    }
    }

    /**
     * 查询索引初始化状态
     */
    public function defaultSearchState($obj){
         if(!empty($obj)){
            return $obj::where('id','>',0);
         }else{
            return [];
         }
    }

    /**
     * [上传图片/文件]
     * @return [type] [description]
     */
    public function uploadFile(){
        $file =  Input::file('file');
        return app('zcjy')->uploadFiles($file);
    }

    /**
     * [读取Excel信息并且生成题目]
     * @return [type] [description]
     */
    public function autoGenerateTopic(Request $request){
        $input = $request->all();
        $varify = app('zcjy')->varifyInputParam($input,['subject_id','sec','excel_path']);
        if($varify){
            return zcjy_callback_data($varify,1);
        }
        return app('zcjy')->readExcelsToGenerate($input['excel_path'],$input);
    }

    /**
     * [批量处理指定科目的题目]
     * @param  Request $request    [description]
     * @param  [type]  $subject_id [description]
     * @return [type]              [description]
     */
    public function doSubjectTopics(Request $request,$subject_id,$type = 1 )
    {
        return app('zcjy')->TopicRepo()->manyTopicAction($subject_id,$request,$type);
    }

    public function resetUserPackage(Request $request,$user_id)
    {
        return app('zcjy')->resetUserPackage($user_id);
    }

}
