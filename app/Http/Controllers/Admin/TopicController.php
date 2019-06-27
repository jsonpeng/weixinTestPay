<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Repositories\TopicRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TopicController extends AppBaseController
{
    /** @var  TopicRepository */
    private $topicRepository;

    public function __construct(TopicRepository $topicRepo)
    {
        $this->topicRepository = $topicRepo;
    }

    //验证下请求参数
    private function varifyParameter($parameter){
        $route = false;
        if(!isset($parameter['subject_id']) || !isset($parameter['sec'])){
            Flash::error('参数不完整');
            $route = redirect(route('jobs.index'));
        }
        return $route;
    }

    /**
     * Display a listing of the Topic.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->topicRepository->pushCriteria(new RequestCriteria($request));
        $input = $request->all();

        $varify = $this->varifyParameter($input);

        if($varify){
            return $varify;
        }

        $subject = app('zcjy')->JobSubjectRepo()->findWithoutFail($input['subject_id']);

        if(empty($subject)){
            return redirect(route('jobs.index'));
        }

        $topics = app('zcjy')->TopicRepo()->getSubjectSecTopics($subject->id,$input['sec'])->where('is_delete',0)
        ->orderBy('num_sort','asc')
        //->orderBy('group','asc')
        // ->orderByRaw('group DESC')
        ->paginate(defaultPage());

        // app('zcjy')->TopicRepo()->dealTopicsSound($topics);
        
        session(['redirect_topic_url'=>$request->fullUrl()]);

        return view('admin.topics.index')
            ->with('topics', $topics)
            ->with('subject',$subject)
            ->with('sec',$input['sec'])
            ->with('input',$input);
    }


    //清空一个章节的所有题目
    public function clearOneSecTopics(Request $request,$job_id){
        $input = $request->all();
        $word = '重置该章节题目成功';
        app('zcjy')->TopicRepo()->getSubjectSecTopics($input['subject_id'],$input['sec'])->update(['is_delete'=>1]);

        if(array_key_exists('delete',$input)){
            app('zcjy')->SectionRepo()->model()::where('subject_id',$input['subject_id'])->where('sort',$input['sec'])->update(['is_delete'=>1]);
            $word = '删除章节成功';
        }

        Flash::success($word);
        return redirect(route('jobSubjects.index',$job_id));
    }

    #用于加入组
    public function group(Request $request){
        $input = $request->all();
        $subject = app('zcjy')->JobSubjectRepo()->findWithoutFail($input['subject_id']);

        if(empty($subject)){
            return redirect(route('jobs.index'));
        }
        $topics = $this->descAndPaginateToShow(
            app('zcjy')->TopicRepo()->getSubjectSecTopics($subject->id,$input['sec'])
            ->where('group',0)
            ->where('is_delete',0)
            ->where('id','<>',$input['topic_id']),'num_sort','asc');
          return view('admin.topics.group')
            ->with('topics', $topics)
            ->with('input',$input);
    }

    //更新为首个组题
    public function updateGroupType(Request $request,$id,$action=null){
        $group = app('zcjy')->TopicRepo()->getNextGroupNum();

        $topic = $this->topicRepository->findWithoutFail($id);

        if (empty($topic)) {
            Flash::error('没有找到该题目');
            return redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort);
        }

        if(empty($action)){
            $topic->update(['group'=>$group,'group_type'=>1]);
        }
        elseif($action == 'cancle'){
            #如果是首个组题 子组题也更新为普通题目
            if($topic->group_type == 1){
                app('zcjy')->TopicRepo()->model()::where('group',$topic->group)->update(['group'=>0,'group_type'=>0]);
            }
            $topic->update(['group'=>0,'group_type'=>0]);

        }

        Flash::success('设置题目类型成功.');

        return  empty(session('redirect_topic_url')) ? redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort) : redirect(session('redirect_topic_url'));
    }

    //加入为题组
    public function joinGroup(Request $request,$id){
        $topic = $this->topicRepository->findWithoutFail($id);

        if (empty($topic)) {
            Flash::error('没有找到该题目');
            return redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort);
        }

        $input = $request->all();
        if(!array_key_exists('group_id',$input) || empty($input['group_id'])){
            Flash::error('请选择要加入的题目');
            return redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort);
        }

        if(!is_array($input['group_id'])){
            $input['group_id'] = explode(',',$input['group_id']);
        }

        app('zcjy')->TopicRepo()->model()::whereIn('id',$input['group_id'])->update(['group'=>$topic->group,'group_type'=>2]);
        Flash::success('加入组题成功.');

        return  empty(session('redirect_topic_url')) ? redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort) : redirect(session('redirect_topic_url'));  
    }

    #用于回收站和批量删除
    public function action(Request $request){
        $input = $request->all();

        $varify = $this->varifyParameter($input);

        if($varify){
            return $varify;
        }

        $subject = app('zcjy')->JobSubjectRepo()->findWithoutFail($input['subject_id']);

        if(empty($subject)){
            return redirect(route('jobs.index'));
        }

        $is_delete = 0; 

        if(array_key_exists('is_delete',$input)){
            $is_delete = $input['is_delete'];
        }

        $topics = $this->descAndPaginateToShow(app('zcjy')->TopicRepo()->getSubjectSecTopics($subject->id,$input['sec'])->where('is_delete',$is_delete),'num_sort','asc');

        return view('admin.topics.action')
            ->with('input',$input)
            ->with('topics',$topics);
    }



     public function actionUpdate(Request $request){
        $input = $request->all();
        $varify = $this->varifyParameter($input);

        if($varify){
            return $varify;
        }

        $subject = app('zcjy')->JobSubjectRepo()->findWithoutFail($input['subject_id']);

        if(empty($subject)){
            return redirect(route('jobs.index'));
        }

        $delete = 0;
        //dd($input);
        if(isset($input['is_delete'])){
            $delete  = !$input['is_delete'] ? 1 : 0;
        }
        if(!isset($input['attr_arr'])){
            Flash::error('参数不完整!');
            return redirect(route('topics.index').'?subject_id='.$input['subject_id'].'&sec='.$input['sec']);
        }
        if(!is_array($input['attr_arr'])){
            $input['attr_arr'] = explode(',',$input['attr_arr']);
        }

        $this->topicRepository->model()::whereIn('id',$input['attr_arr'])->update(['is_delete'=>$delete]);
        $action = $delete ? '删除' : '恢复';

        Flash::success('批量'.$action.'成功');

        return redirect(route('topics.index').'?subject_id='.$input['subject_id'].'&sec='.$input['sec']);
     } 

    /**
     * Show the form for creating a new Topic.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $varify = $this->varifyParameter($input);

        if($varify){
            return $varify;
        }

        $subject = app('zcjy')->JobSubjectRepo()->findWithoutFail($input['subject_id']);

        if(empty($subject)){
            return redirect(route('jobs.index'));
        }

        return view('admin.topics.create')
          ->with('subject',$subject)
          ->with('sec',$input['sec'])
          ->with('topic',optional([]));
    }

    /**
     * Store a newly created Topic in storage.
     *
     * @param CreateTopicRequest $request
     *
     * @return Response
     */
    public function store(CreateTopicRequest $request)
    {
        $input = $request->all();

        $topic = $this->topicRepository->create($input);

        Flash::success('添加题目成功.');

        return empty(session('redirect_topic_url')) ? redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort) : redirect(session('redirect_topic_url'));
    }

    /**
     * Display the specified Topic.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $topic = $this->topicRepository->findWithoutFail($id);

        if (empty($topic)) {
            Flash::error('没有找到该题目');

            return redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort);
        }

        return view('admin.topics.show')->with('topic', $topic);
    }

    /**
     * Show the form for editing the specified Topic.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Request $request,$id)
    {
        $input = $request->all();
        $varify = $this->varifyParameter($input);

        if($varify){
            return $varify;
        }

        $subject = app('zcjy')->JobSubjectRepo()->findWithoutFail($input['subject_id']);

        if(empty($subject)){
            return redirect(route('jobs.index'));
        }

        $topic = $this->topicRepository->findWithoutFail($id);

        if (empty($topic)) {
            Flash::error('没有找到该题目');

            return redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort);
        }
        
        app('zcjy')->TopicRepo()->dealOneTopicSound($topic,['attach_url','attach_sound_url','selection_sound_url']);

        return view('admin.topics.edit')
        ->with('topic', $topic)
        ->with('subject',$subject)
        ->with('sec',$input['sec']);
    }

    /**
     * Update the specified Topic in storage.
     *
     * @param  int              $id
     * @param UpdateTopicRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTopicRequest $request)
    {
        $topic = $this->topicRepository->findWithoutFail($id);

        if (empty($topic)) {
            Flash::error('没有找到该题目');

            return redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort);
        }

        $topic->update($request->all());

        Flash::success('更新成功.');

        return empty(session('redirect_topic_url')) ? redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort) : redirect(session('redirect_topic_url'));
    }

    /**
     * Remove the specified Topic from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $topic = $this->topicRepository->findWithoutFail($id);

        if (empty($topic)) {
            Flash::error('没有找到该题目');

            return redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort);
        }
        $topic->update(['is_delete'=>1]);
        //$this->topicRepository->delete($id);
        
        Flash::success('删除成功.');

        return redirect(route('topics.index').'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort);
    }
}
