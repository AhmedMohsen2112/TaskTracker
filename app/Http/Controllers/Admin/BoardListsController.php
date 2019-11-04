<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\Repositories\Contracts\BoardListRepositoryInterface;
use App\Http\Requests\Admin\BoardListsRequest;
use Validator;
use DB;

class BoardListsController extends AdminController {

    private $board_list;

    public function __construct(BoardListRepositoryInterface $board_list) {
        parent::__construct();
        $this->board_list = $board_list;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        return $this->_view('board_lists/create', 'backend');
    }

    public function store(BoardListsRequest $request) {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['user_id'] = $this->User->id;
            $BoardList = $this->board_list->create($data);

            DB::commit();
            return created(['message' => t('added_successfully'), 'list' => $BoardList]);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        try {
            $BoardList = $this->board_list->findForEdit($id);
            if (!$BoardList) {
                return not_found(t('resource_not_found'));
            }
            return ok($BoardList);
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
    public function update(BoardListsRequest $request, $id) {


        $BoardList = $this->board_list->findById($id);
        if (!$BoardList) {
            return not_found(t('resource_not_found'));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            $this->board_list->update($id, $data);

            DB::commit();
            return ok(['message' => t('updated_successfully'), 'list' =>  $this->board_list->findById($id)]);
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
        $BoardList = $this->board_list->findById($id);
        if (!$BoardList) {
            return _json('error', _lang('app.resource_not_found'), 404);
        }
        DB::beginTransaction();
        try {
            $BoardList->delete();
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


}
