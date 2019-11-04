<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\Repositories\Contracts\BoardRepositoryInterface;
use App\Http\Requests\Admin\BoardsRequest;
use Validator;
use DB;

class BoardsController extends AdminController {

    private $board;

    public function __construct(BoardRepositoryInterface $board) {
        parent::__construct();
        $this->board = $board;
//        app(\App\Helpers\OneSignal::class)->send_message();
//        dd(app(\App\Helpers\OneSignal::class)->send_message());
    }

    public function index(Request $request) {
        $this->data['boards'] = $this->board->getList();

    
        return $this->_view('boards/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        return $this->_view('boards/create', 'backend');
    }

    public function store(BoardsRequest $request) {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['user_id'] = $this->User->id;
            $Board = $this->board->create($data);

            DB::commit();
            return created(['message' => t('added_successfully'), 'board' => $Board]);
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return bad_request(t('error_is_occured'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
        try {
            $Board = $this->board->findForView($id);
            if (!$Board) {
                return abort(404);
            }
            $this->data['board'] = $Board;
            return $this->_view('boards.view');
        } catch (\Exception $ex) {
            return abort(400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        try {
            $Board = $this->board->findForEdit($id);
            if (!$Board) {
                return not_found(t('resource_not_found'));
            }
            return ok($Board);
        } catch (\Exception $ex) {
            return bad_request(t('error_is_occured'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BoardsRequest $request, $id) {


        $Board = $this->board->findById($id);
        if (!$Board) {
            return not_found(t('resource_not_found'));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            $this->board->update($id, $data);

            DB::commit();
            return ok(['message' => t('updated_successfully'), 'board' => $this->board->findById($id)]);
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return bad_request(t('error_is_occured'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $Board = $this->board->findById($id);
        if (!$Board) {
            return _json('error', _lang('app.resource_not_found'), 404);
        }
        DB::beginTransaction();
        try {
            $Board->delete();
            DB::commit();
            return _json('success', _lang('app.deleted_successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            if ($ex->getCode() == 23000) {
                return _json('error', _lang('app.this_record_can_not_be_deleted_for_linking_to_other_records'), 400);
            } else {
                return _json('error', _lang('app.error_is_occured'), 400);
            }
        }
    }

    public function data(Request $request) {

        return \Datatables::of($this->board->datatable($request->all()))
                        ->make(true);
    }

}
