<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateJobPackageRequest;
use App\Http\Requests\UpdateJobPackageRequest;
use App\Repositories\JobPackageRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class JobPackageController extends AppBaseController
{
    /** @var  JobPackageRepository */
    private $jobPackageRepository;

    public function __construct(JobPackageRepository $jobPackageRepo)
    {
        $this->jobPackageRepository = $jobPackageRepo;
    }

    /**
     * Display a listing of the JobPackage.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request,$job_id)
    {
        $this->jobPackageRepository->pushCriteria(new RequestCriteria($request));

        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该职位');
            return redirect('/zcjy/jobs');
        }

        $jobPackages = $this->jobPackageRepository->getJobPackages($job_id)->get();

        return view('admin.job_packages.index')
            ->with('job',$job)
            ->with('jobPackages', $jobPackages);
    }



    /**
     * Show the form for creating a new JobPackage.
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
        return view('admin.job_packages.create')
        ->with('job',$job);
    }

    /**
     * Store a newly created JobPackage in storage.
     *
     * @param CreateJobPackageRequest $request
     *
     * @return Response
     */
    public function store(CreateJobPackageRequest $request,$job_id)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该职位');
            return redirect('/zcjy/jobs');
        }
        $input = $request->all();
        $input['job_name'] = $job->name;
        $input['job_id'] = $job_id;
        $jobPackage = $this->jobPackageRepository->create($input);

        Flash::success('创建职位套餐成功.');

        return redirect(route('jobPackages.index',$job_id));
    }

    /**
     * Display the specified JobPackage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jobPackage = $this->jobPackageRepository->findWithoutFail($id);

        if (empty($jobPackage)) {
            Flash::error('没有找到该套餐');

            return redirect(route('jobPackages.index',$job_id));
        }

        return view('job_packages.show')->with('jobPackage', $jobPackage);
    }

    /**
     * Show the form for editing the specified JobPackage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id,$job_id)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该兼职');
            return redirect('/zcjy/jobs');
        }

        $jobPackage = $this->jobPackageRepository->findWithoutFail($id);

        if (empty($jobPackage)) {
            Flash::error('没有找到该套餐');

            return redirect(route('jobPackages.index',$job_id));
        }

        return view('admin.job_packages.edit')
        ->with('jobPackage', $jobPackage)
        ->with('job',$job);
    }

    /**
     * Update the specified JobPackage in storage.
     *
     * @param  int              $id
     * @param UpdateJobPackageRequest $request
     *
     * @return Response
     */
    public function update($id,$job_id, UpdateJobPackageRequest $request)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该兼职');
            return redirect('/zcjy/jobs');
        }

        $jobPackage = $this->jobPackageRepository->findWithoutFail($id);

        if (empty($jobPackage)) {
            Flash::error('没有找到该套餐');

            return redirect(route('jobPackages.index',$job_id));
        }

        $jobPackage = $this->jobPackageRepository->update($request->all(), $id);

        Flash::success('职位套餐更新成功.');

        return redirect(route('jobPackages.index',$job_id));
    }

    /**
     * Remove the specified JobPackage from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id,$job_id)
    {
        $job = $this->varifyJob($job_id);
        if(!$job){
            Flash::error('没有找到该兼职');
            return redirect('/zcjy/jobs');
        }
        $jobPackage = $this->jobPackageRepository->findWithoutFail($id);

        if (empty($jobPackage)) {
            Flash::error('没有找到该套餐');

            return redirect(route('jobPackages.index',$job_id));
        }

        $this->jobPackageRepository->delete($id);

        Flash::success('Job Package deleted successfully.');

        return redirect(route('jobPackages.index',$job_id));
    }
}
