<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateUserBuyLogRequest;
use App\Http\Requests\UpdateUserBuyLogRequest;
use App\Repositories\UserBuyLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserBuyLogController extends AppBaseController
{
    /** @var  UserBuyLogRepository */
    private $userBuyLogRepository;

    public function __construct(UserBuyLogRepository $userBuyLogRepo)
    {
        $this->userBuyLogRepository = $userBuyLogRepo;
    }

    /**
     * Display a listing of the UserBuyLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userBuyLogRepository->pushCriteria(new RequestCriteria($request));
        $userBuyLogs = $this->descAndPaginateToShow($this->userBuyLogRepository);

        return view('admin.user_buy_logs.index')
            ->with('userBuyLogs', $userBuyLogs);
    }

    /**
     * Show the form for creating a new UserBuyLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.user_buy_logs.create');
    }

    /**
     * Store a newly created UserBuyLog in storage.
     *
     * @param CreateUserBuyLogRequest $request
     *
     * @return Response
     */
    public function store(CreateUserBuyLogRequest $request)
    {
        $input = $request->all();

        $userBuyLog = $this->userBuyLogRepository->create($input);

        Flash::success('User Buy Log saved successfully.');

        return redirect(route('userBuyLogs.index'));
    }

    /**
     * Display the specified UserBuyLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userBuyLog = $this->userBuyLogRepository->findWithoutFail($id);

        if (empty($userBuyLog)) {
            Flash::error('没有找到该购买记录');

            return redirect(route('userBuyLogs.index'));
        }

        return view('admin.user_buy_logs.show')->with('userBuyLog', $userBuyLog);
    }

    /**
     * Show the form for editing the specified UserBuyLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userBuyLog = $this->userBuyLogRepository->findWithoutFail($id);

        if (empty($userBuyLog)) {
            Flash::error('没有找到该购买记录');

            return redirect(route('userBuyLogs.index'));
        }

        return view('admin.user_buy_logs.edit')->with('userBuyLog', $userBuyLog);
    }

    /**
     * Update the specified UserBuyLog in storage.
     *
     * @param  int              $id
     * @param UpdateUserBuyLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserBuyLogRequest $request)
    {
        $userBuyLog = $this->userBuyLogRepository->findWithoutFail($id);

        if (empty($userBuyLog)) {
            Flash::error('没有找到该购买记录');

            return redirect(route('userBuyLogs.index'));
        }

        $userBuyLog = $this->userBuyLogRepository->update($request->all(), $id);

        Flash::success('购买记录更新成功.');

        return redirect(route('userBuyLogs.index'));
    }

    /**
     * Remove the specified UserBuyLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userBuyLog = $this->userBuyLogRepository->findWithoutFail($id);

        if (empty($userBuyLog)) {
            Flash::error('没有找到该购买记录');

            return redirect(route('userBuyLogs.index'));
        }

        $this->userBuyLogRepository->delete($id);

        Flash::success('购买记录删除成功');

        return redirect(route('userBuyLogs.index'));
    }
}
