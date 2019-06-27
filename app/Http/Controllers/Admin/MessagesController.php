<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateMessagesRequest;
use App\Http\Requests\UpdateMessagesRequest;
use App\Repositories\MessagesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MessagesController extends AppBaseController
{
    /** @var  MessagesRepository */
    private $messagesRepository;

    public function __construct(MessagesRepository $messagesRepo)
    {
        $this->messagesRepository = $messagesRepo;
    }

    /**
     * Display a listing of the Messages.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->messagesRepository->pushCriteria(new RequestCriteria($request));
        $messages = $this->descAndPaginateToShow($this->messagesRepository);

        return view('admin.messages.index')
            ->with('messages', $messages);
    }

    /**
     * Show the form for creating a new Messages.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.messages.create');
    }

    /**
     * Store a newly created Messages in storage.
     *
     * @param CreateMessagesRequest $request
     *
     * @return Response
     */
    public function store(CreateMessagesRequest $request)
    {
        $input = $request->all();

        $messages = $this->messagesRepository->create($input);

        Flash::success('添加成功.');

        return redirect(route('messages.index'));
    }

    /**
     * Display the specified Messages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            Flash::error('没有找到该通知消息');

            return redirect(route('messages.index'));
        }

        return view('admin.messages.show')->with('messages', $messages);
    }

    /**
     * Show the form for editing the specified Messages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            Flash::error('没有找到该通知消息');

            return redirect(route('messages.index'));
        }

        return view('admin.messages.edit')->with('messages', $messages);
    }

    /**
     * Update the specified Messages in storage.
     *
     * @param  int              $id
     * @param UpdateMessagesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMessagesRequest $request)
    {
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            Flash::error('没有找到该通知消息');

            return redirect(route('messages.index'));
        }

        $messages = $this->messagesRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('messages.index'));
    }

    /**
     * Remove the specified Messages from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            Flash::error('没有找到该通知消息');

            return redirect(route('messages.index'));
        }

        $this->messagesRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('messages.index'));
    }
}
