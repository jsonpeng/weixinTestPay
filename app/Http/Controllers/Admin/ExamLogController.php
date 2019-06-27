<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateExamLogRequest;
use App\Http\Requests\UpdateExamLogRequest;
use App\Repositories\ExamLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ExamLogController extends AppBaseController
{
    /** @var  ExamLogRepository */
    private $examLogRepository;

    public function __construct(ExamLogRepository $examLogRepo)
    {
        $this->examLogRepository = $examLogRepo;
    }

    /**
     * Display a listing of the ExamLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->examLogRepository->pushCriteria(new RequestCriteria($request));

        $examLogs = $this->examLogRepository->model()::orderBy('created_at','desc');

        $input = $request->all();

        if(array_key_exists('user_id',$input) && !empty($input['user_id']))
        {
            //dd($input['user_id']);
            $examLogs = $examLogs->where('user_id',$input['user_id']);
        }

        $examLogs = $examLogs->paginate(defaultPage());

        return view('admin.exam_logs.index')
            ->with('examLogs', $examLogs)
            ->with('input',$input);
    }

    /**
     * Show the form for creating a new ExamLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('exam_logs.create');
    }

    /**
     * Store a newly created ExamLog in storage.
     *
     * @param CreateExamLogRequest $request
     *
     * @return Response
     */
    public function store(CreateExamLogRequest $request)
    {
        $input = $request->all();

        $examLog = $this->examLogRepository->create($input);

        Flash::success('Exam Log saved successfully.');

        return redirect(route('examLogs.index'));
    }

    /**
     * Display the specified ExamLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $examLog = $this->examLogRepository->findWithoutFail($id);

        if (empty($examLog)) {
            Flash::error('Exam Log not found');

            return redirect(route('examLogs.index'));
        }

        return view('admin.exam_logs.show')->with('examLog', $examLog);
    }

    /**
     * Show the form for editing the specified ExamLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $examLog = $this->examLogRepository->findWithoutFail($id);

        if (empty($examLog)) {
            Flash::error('Exam Log not found');

            return redirect(route('examLogs.index'));
        }

        return view('admin.exam_logs.edit')->with('examLog', $examLog);
    }

    /**
     * Update the specified ExamLog in storage.
     *
     * @param  int              $id
     * @param UpdateExamLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExamLogRequest $request)
    {
        $examLog = $this->examLogRepository->findWithoutFail($id);

        if (empty($examLog)) {
            Flash::error('Exam Log not found');

            return redirect(route('examLogs.index'));
        }

        $examLog = $this->examLogRepository->update($request->all(), $id);

        Flash::success('Exam Log updated successfully.');

        return redirect(route('examLogs.index'));
    }

    /**
     * Remove the specified ExamLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $examLog = $this->examLogRepository->findWithoutFail($id);

        if (empty($examLog)) {
            Flash::error('Exam Log not found');

            return redirect(route('examLogs.index'));
        }

        $this->examLogRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('examLogs.index'));
    }
}
