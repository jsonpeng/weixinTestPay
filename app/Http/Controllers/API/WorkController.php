<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Config;
use Log;

use App\User;
use Carbon\Carbon;

class WorkController extends Controller
{

	//获取所有职位
	public function getJobs(Request $request){

		$jobs = app('zcjy')->JobRepo()->getCacheJobs();

		$input = $request->all();

		$user = zcjy_api_user($input);

		if(isset($input['checkmobile']) && $input['checkmobile'] == '1')
		{
		  if(empty($user->mobile) || empty($user->job))
		  {
             return zcjy_callback_data('您没有注册,无法使用哦',10003);
          }
		}

		$seelogs = $user->seelogs()->orderBy('created_at','desc')->get();
		#检查能否用
		foreach ($jobs as $key => $val) {
			$val['is_effective_member'] = 0;
			$val['is_more_view'] = count($seelogs) >=3 ? 1 : 0;
			$packages = $user->packages()->get();
			if(count($packages)){
				foreach ($packages as $key => $package) {
					$overdue = app('zcjy')->varifyOverdue($package->package_end) ? 1 : 0;
					if(stripos($package->package_name,$val->name) !== false){
						$val['is_effective_member'] = 1;
						if($overdue){
							$val['is_effective_member'] = 0;
						}
					}
					$val['overdue'] = $overdue;
				}
			}
			#并且带上套餐信息
			$val['packages'] = $val->packages()->orderBy('price','asc')->get();
		}
		return zcjy_callback_data($jobs);
	}

	//获取职位下的科目
	public function getSubjects(Request $request,$job_id){
		return app('zcjy')->JobSubjectRepo()->getCacheSubjects($job_id);
	}

	//获取科目下的章节
	public function getSections(Request $request,$subject_id){
		return app('zcjy')->SectionRepo()->getCacheSections($subject_id);
	}

	//搜索题库
	public function searchTopics(Request $request)
	{
		$input = $request->all();
		$varify = app('zcjy')->varifyInputParam($input,['query']);

		if($varify){
			return zcjy_callback_data($varify,1);
		}

		$topics = app('zcjy')->TopicRepo()->searchTopics($input['query']);
		return zcjy_callback_data($topics);
	}

	//根据科目id和章节获取题目
	public function getTopics(Request $request){
		$input = $request->all();
		$varify = app('zcjy')->varifyInputParam($input,['subject_id','sec']);

		if($varify){
			return zcjy_callback_data($varify,1);
		}

		$sec = app('zcjy')->SectionRepo()->model()::where('subject_id',$input['subject_id'])->where('sort',$input['sec'])->first();

		if(empty($sec)){
			return zcjy_callback_data('该章节不存在',1);
		}

		$user = zcjy_api_user($input);

		$skip = 0;
		$take = 50;

		if(isset($input['skip'])){
			$skip = $input['skip'];
		}

		if(isset($input['take'])){
			$take = $input['take'];
		}

		//添加浏览记录
		if($skip == 0){
			app('zcjy')->UserSeeLogsRepo()->create(['user_id'=>$user->id,'sec_id'=>$sec->id]);
		}
		// return zcjy_callback_data(app('zcjy')->TopicRepo()->getZuGroupTopics($input['subject_id']));
		return zcjy_callback_data(app('zcjy')->TopicRepo()->getCacheTopicsWithSkipTake($input['subject_id'],$input['sec'],$skip,$take));
	}

	//根据序号获取题目
	public function getSortTopic(Request $request)
	{
		$input = $request->all();
		$varify = app('zcjy')->varifyInputParam($input,['subject_id','sec','sort']);

		if($varify)
		{
			return zcjy_callback_data($varify,1);
		}

		$sec = app('zcjy')->SectionRepo()->model()::where('subject_id',$input['subject_id'])->where('sort',$input['sec'])->first();

		if(empty($sec)){
			return zcjy_callback_data('该章节不存在',1);
		}

		$user = zcjy_api_user($input);

		if($input['sort'] == 1)
		{
			app('zcjy')->UserSeeLogsRepo()->create(['user_id'=>$user->id,'sec_id'=>$sec->id]);
		}

		return zcjy_callback_data(app('zcjy')->TopicRepo()->getCacheTopicsWithSort($input['subject_id'],$input['sec'],$input['sort']));
	}

	//根据科目和章节序号获取题目总量
	public function getTopicsSum(Request $request)
	{
		$input = $request->all();
		$varify = app('zcjy')->varifyInputParam($input,['subject_id','sec']);

		if($varify){
			return zcjy_callback_data($varify,1);
		}

		$sec = app('zcjy')->SectionRepo()->model()::where('subject_id',$input['subject_id'])->where('sort',$input['sec'])->first();

		if(empty($sec)){
			return zcjy_callback_data('该章节不存在',1);
		}
		return zcjy_callback_data(app('zcjy')->TopicRepo()->getCacheTopicsSum($input['subject_id'],$input['sec']));

	}

	//根据科目id自动组题
	public function autoGroupTopics(Request $request,$subject_id){
		$subject = app('zcjy')->JobSubjectRepo()->findWithoutFail($subject_id);
		if(empty($subject)){
			return zcjy_callback_data('没有找到该题目',1);
		}
		$secs = $subject->sections()->where('is_delete',0)->get();
		$auto_topics = [];
		#英语听力校检
		$english_sound_varify = app('zcjy')->TopicRepo()->varifyEnglishSound($subject_id);
		if($english_sound_varify)
		{
				$auto_topics = app('zcjy')->TopicRepo()->getZuGroupTopics($subject_id);
		}
		else
		{
			foreach ($secs as $key => $val) 
			{
				$val['topics'] = app('zcjy')->TopicRepo()->getCacheTopics($subject->id,$val->sort,$val->get_num);
				if(count($val['topics'])) 
				{
					foreach ($val['topics'] as $key => $topic) 
					{
						array_push($auto_topics,$topic);
					}
				}
			}
		}
		return zcjy_callback_data($auto_topics);
	}


	//查看对应职位下的考试记录
	public function getJobRollbackTopics(Request $request,$job_id=0){
		$subjects_arr = [];
		if(!empty($job_id) && $job_id != 'null'){
			$job = app('zcjy')->JobRepo()->findWithoutFail($job_id);
			if(empty($job)){
				return zcjy_callback_data('没有找到该职位',1);
			}
			#职位下的科目
			$subjects = $job->subjects()->get();
			#全部转换为id
			if(count($subjects)){
				foreach ($subjects as $key => $val) {
					array_push($subjects_arr,$val->id);
				}
			}
		}
		else{
			$job_all = app('zcjy')->JobRepo()->all();
			if(count($job_all)){
				foreach ($job_all as $key => $job) {
					$subjects = $job->subjects()->get();
						if(count($subjects)){
							foreach ($subjects as $key => $val) {
								array_push($subjects_arr,$val->id);
							}
						}
				}
			}
		}
		$input = $request->all();
		$skip = 0;
		$take = 12;
		$user = zcjy_api_user($input);
		if(array_key_exists('skip',$input)){
			$skip = $input['skip'];
		}
		if(array_key_exists('take',$input)){
			$take = $input['take'];
		}
		$topics = app('zcjy')->ExamLogRepo()->model()::whereIn('subject_id',$subjects_arr)
		->where('user_id',$user->id)
		->orderBy('created_at','desc')
		->get();
		return zcjy_callback_data($topics);
	}

	//根据考试记录id查到习题详情状况
	public function getTopicsDetailByTestId(Request $request,$exam_id){
		$exam = app('zcjy')->ExamLogRepo()->findWithoutFail($exam_id);
		if(empty($exam)){
			return zcjy_callback_data('没有找到该考试记录',1);
		}
		$topics = $exam->detail()->get();
		#带上题目和选项
		foreach ($topics as $key => $val) {
			$val['doing'] = empty($val->result) ? null : select_sort($val->result);
			$val['topic'] = $val->topic()->first();
			if(!empty($val['topic'])){
				$val['selections'] = $val['topic']->selections()->orderBy('sort','asc')->get();
				if(count($val['selections'])){
					foreach ($val['selections'] as $key => $selection) {
								$selection['selected'] = 0;
								if($val['doing'] && $val->result == $selection->sort){
									$selection['selected'] = 1;
								}	
					}
				}
			}
		}
		return zcjy_callback_data($topics);
	}

}