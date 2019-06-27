<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateJobSubjectRequest;
use App\Http\Requests\UpdateJobSubjectRequest;
use App\Repositories\JobSubjectRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class JobSubjectController extends AppBaseController
{
    /** @var  JobSubjectRepository */
    private $jobSubjectRepository;

    public function __construct(JobSubjectRepository $jobSubjectRepo)
    {
        $this->jobSubjectRepository = $jobSubjectRepo;
    }

    /**
     * Display a listing of the JobSubject.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request,$job_id)
    {
        $this->jobSubjectRepository->pushCriteria(new RequestCriteria($request));

        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该职位');
            return redirect('/zcjy/jobs');
        }

        $jobSubjects = $this->descAndPaginateToShow($job->subjects()->where('is_delete',0));

        return view('admin.job_subjects.index')
            ->with('jobSubjects', $jobSubjects)
            ->with('job',$job);
    }

    /**
     * Show the form for creating a new JobSubject.
     *
     * @return Response
     */
    public function create($job_id)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该职位');
            return redirect('/zcjy/jobs');
        }
        return view('admin.job_subjects.create')
            ->with('job',$job);
    }

    /**
     * Store a newly created JobSubject in storage.
     *
     * @param CreateJobSubjectRequest $request
     *
     * @return Response
     */
    public function store(CreateJobSubjectRequest $request,$job_id)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该职位');
            return redirect('/zcjy/jobs');
        }
        $input = $request->all();
        $input['job_id'] = $job_id;
        $jobSubject = $this->jobSubjectRepository->create($input);
        #自动生成章节
        for ($i=1; $i<=$jobSubject->max_section; $i++) { 
           app('zcjy')->SectionRepo()->create([
            'sort'=>$i,
            'subject_id'=>$jobSubject->id
           ]);
        }
        Flash::success('保存成功.');

        return redirect(route('jobSubjects.index',$job->id));
    }

    /**
     * Display the specified JobSubject.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id,$job_id)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该职位');
            return redirect('/zcjy/jobs');
        }
        $jobSubject = $this->jobSubjectRepository->findWithoutFail($id);

        if (empty($jobSubject)) {
            Flash::error('没有找到该科目');

            return redirect(route('jobSubjects.index',$job->id));
        }

        return view('admin.job_subjects.show')->with('jobSubject', $jobSubject);
    }

    /**
     * Show the form for editing the specified JobSubject.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id,$job_id)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该职位');
            return redirect('/zcjy/jobs');
        }
        $jobSubject = $this->jobSubjectRepository->findWithoutFail($id);

        if (empty($jobSubject)) {
            Flash::error('没有找到该科目');

            return redirect(route('jobSubjects.index',$job->id));
        }

        return view('admin.job_subjects.edit')
        ->with('jobSubject', $jobSubject)
        ->with('job',$job);
    }

    /**
     * Update the specified JobSubject in storage.
     *
     * @param  int              $id
     * @param UpdateJobSubjectRequest $request
     *
     * @return Response
     */
    public function update($id,$job_id,UpdateJobSubjectRequest $request)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该职位');
            return redirect('/zcjy/jobs');
        }
        $jobSubject = $this->jobSubjectRepository->findWithoutFail($id);

        if (empty($jobSubject)) {
            Flash::error('没有找到该科目');

            return redirect(route('jobSubjects.index',$job->id));
        }
        $input = $request->all();
        $jobSubject = $this->jobSubjectRepository->update($input, $id);

        Flash::success('更新成功.');

        return redirect(route('jobSubjects.index',$job->id));
    }

    //更新章节名称
    public function updateSection($id,Request $request)
    {
        $input = $request->all();
        if(!isset($input['subject_id']) || !isset($input['job_id'])){
            Flash::error('未知错误');
            return redirect('/zcjy/jobs');
        }
        $section = app('zcjy')->SectionRepo()->findWithoutFail($id);
        if(empty($section)){
            Flash::error('没有找到该章节');
            return redirect(route('jobSubjects.index',$input['job_id']));
        }
        $section->update($input);
        Flash::success('更新章节成功.');
        return redirect(route('jobSubjects.index',$input['job_id']));
    }

    //添加章节
    public function createSection(Request $request){
        $input = $request->all();
        if(!isset($input['subject_id']) || !isset($input['job_id'])){
            Flash::error('未知错误');
            return redirect('/zcjy/jobs');
        }
        $subject = $this->jobSubjectRepository->findWithoutFail($input['subject_id']);
        if(empty($subject )){
            Flash::error('未知错误');
            return redirect('/zcjy/jobs');
        }
        app('zcjy')->SectionRepo()->create($input);
        $subject->update(['max_section'=>$subject->max_section+1]);
        Flash::success('添加章节成功.');
        return redirect(route('jobSubjects.index',$input['job_id']));
    }

    /**
     * Remove the specified JobSubject from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id,$job_id)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该职位');
            return redirect('/zcjy/jobs');
        }
        $jobSubject = $this->jobSubjectRepository->findWithoutFail($id);

        if (empty($jobSubject)) {
            Flash::error('没有找到该科目');
            return redirect(route('jobSubjects.index',$job->id));
        }

       // $this->jobSubjectRepository->delete($id);
        #删除对应科目下的所有章节 及对应章节下的题目
        //$this->jobSubjectRepository->deleteAllSecAndTopic($id);
        $jobSubject->update(['is_delete'=>1]);
     
        Flash::success('删除成功.');

        return redirect(route('jobSubjects.index',$job->id));
    }
}
