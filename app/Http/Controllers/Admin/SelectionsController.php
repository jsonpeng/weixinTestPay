<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSelectionsRequest;
use App\Http\Requests\UpdateSelectionsRequest;
use App\Repositories\SelectionsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SelectionsController extends AppBaseController
{
    /** @var  SelectionsRepository */
    private $selectionsRepository;

    public function __construct(SelectionsRepository $selectionsRepo)
    {
        $this->selectionsRepository = $selectionsRepo;
    }

    /**
     * Display a listing of the Selections.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->selectionsRepository->pushCriteria(new RequestCriteria($request));
        $selections = $this->selectionsRepository->all();

        return view('selections.index')
            ->with('selections', $selections);
    }

    /**
     * Show the form for creating a new Selections.
     *
     * @return Response
     */
    public function create()
    {
        return view('selections.create');
    }

    /**
     * Store a newly created Selections in storage.
     *
     * @param CreateSelectionsRequest $request
     *
     * @return Response
     */
    public function store(CreateSelectionsRequest $request)
    {
        $input = $request->all();

        $selections = $this->selectionsRepository->model()::create($input);

        Flash::success('添加选项成功.');

        return redirect(route('topics.index').'?subject_id='.$input['subject_id'].'&sec='.$input['sec']);
    }

    /**
     * Display the specified Selections.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $selections = $this->selectionsRepository->findWithoutFail($id);

        if (empty($selections)) {
            Flash::error('没有找到该选项');

            return redirect(route('selections.index'));
        }

        return view('selections.show')->with('selections', $selections);
    }

    /**
     * Show the form for editing the specified Selections.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $selections = $this->selectionsRepository->findWithoutFail($id);

        if (empty($selections)) {
            Flash::error('没有找到该选项');

            return redirect(route('selections.index'));
        }

        return view('selections.edit')->with('selections', $selections);
    }

    /**
     * Update the specified Selections in storage.
     *
     * @param  int              $id
     * @param UpdateSelectionsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSelectionsRequest $request)
    {
        $selections = $this->selectionsRepository->findWithoutFail($id);

        if (empty($selections)) {
            Flash::error('没有找到该选项');

            return redirect(route('selections.index'));
        }
        $input = $request->all();
        $selections->update($input);

        Flash::success('更新选项成功.');

        return redirect(route('topics.index').'?subject_id='.$input['subject_id'].'&sec='.$input['sec']);
    }

    /**
     * Remove the specified Selections from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $selections = $this->selectionsRepository->findWithoutFail($id);

        if (empty($selections)) {
            Flash::error('没有找到该选项');

            return redirect(route('selections.index'));
        }

        $this->selectionsRepository->delete($id);

        Flash::success('Selections deleted successfully.');

        return redirect(route('selections.index'));
    }
}
