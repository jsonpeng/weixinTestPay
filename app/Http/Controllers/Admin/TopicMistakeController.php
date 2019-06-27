<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateTopicMistakeRequest;
use App\Http\Requests\UpdateTopicMistakeRequest;
use App\Repositories\TopicMistakeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TopicMistakeController extends AppBaseController
{
    /** @var  TopicMistakeRepository */
    private $topicMistakeRepository;

    public function __construct(TopicMistakeRepository $topicMistakeRepo)
    {
        $this->topicMistakeRepository = $topicMistakeRepo;
    }

    /**
     * Display a listing of the TopicMistake.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->topicMistakeRepository->pushCriteria(new RequestCriteria($request));
        $topicMistakes = $this->descAndPaginateToShow($this->topicMistakeRepository);

        return view('topic_mistakes.index')
            ->with('topicMistakes', $topicMistakes);
    }

    /**
     * Show the form for creating a new TopicMistake.
     *
     * @return Response
     */
    public function create()
    {
        return view('topic_mistakes.create');
    }

    /**
     * Store a newly created TopicMistake in storage.
     *
     * @param CreateTopicMistakeRequest $request
     *
     * @return Response
     */
    public function store(CreateTopicMistakeRequest $request)
    {
        $input = $request->all();

        $topicMistake = $this->topicMistakeRepository->create($input);

        Flash::success('Topic Mistake saved successfully.');

        return redirect(route('topicMistakes.index'));
    }

    /**
     * Display the specified TopicMistake.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $topicMistake = $this->topicMistakeRepository->findWithoutFail($id);

        if (empty($topicMistake)) {
            Flash::error('Topic Mistake not found');

            return redirect(route('topicMistakes.index'));
        }

        return view('topic_mistakes.show')->with('topicMistake', $topicMistake);
    }

    /**
     * Show the form for editing the specified TopicMistake.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $topicMistake = $this->topicMistakeRepository->findWithoutFail($id);

        if (empty($topicMistake)) {
            Flash::error('Topic Mistake not found');

            return redirect(route('topicMistakes.index'));
        }

        return view('topic_mistakes.edit')->with('topicMistake', $topicMistake);
    }

    /**
     * Update the specified TopicMistake in storage.
     *
     * @param  int              $id
     * @param UpdateTopicMistakeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTopicMistakeRequest $request)
    {
        $topicMistake = $this->topicMistakeRepository->findWithoutFail($id);

        if (empty($topicMistake)) {
            Flash::error('Topic Mistake not found');

            return redirect(route('topicMistakes.index'));
        }

        $topicMistake = $this->topicMistakeRepository->update($request->all(), $id);

        Flash::success('Topic Mistake updated successfully.');

        return redirect(route('topicMistakes.index'));
    }

    /**
     * Remove the specified TopicMistake from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $topicMistake = $this->topicMistakeRepository->findWithoutFail($id);

        if (empty($topicMistake)) {
            Flash::error('Topic Mistake not found');

            return redirect(route('topicMistakes.index'));
        }

        $this->topicMistakeRepository->delete($id);

        Flash::success('Topic Mistake deleted successfully.');

        return redirect(route('topicMistakes.index'));
    }
}
