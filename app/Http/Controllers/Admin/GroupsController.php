<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\Repositories\GroupRepository;
use App\Http\Requests\Admin\GroupsRequest;
use Validator;
use Config;

class GroupsController extends AdminController {

    private $group;

    public function __construct(GroupRepository $group) {
        parent::__construct();
        $this->group = $group;
        $this->middleware('CheckPermission:groups,open', ['only' => ['index']]);
        $this->middleware('CheckPermission:groups,add_edit', ['only' => ['store', 'edit', 'update']]);
        $this->middleware('CheckPermission:groups,delete', ['only' => ['destroy']]);
    }

    public function index() {
//        dd(modulesAsJson());
        $this->data['modules'] = Config::get('settings.modules');
        return $this->_view('groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupsRequest $request) {



        try {
            $data=$request->all();
            $data['user_id']= $this->User->id;
            $this->group->create($data);
           
            return created(['message' => t('added_successfully')]);
        } catch (\Exception $ex) {
            dd($ex);
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
            $find = $this->group->findForEdit($id);
            if (!$find) {
                return not_found(t('resource_not_found'));
            }
            return ok($find);
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
    public function update(GroupsRequest $request, $id) {
//        dd($request->all());
        $group = $this->group->findById($id);
        if (!$group) {
            return not_found(t('resource_not_found'));
        }
        try {
            $this->group->update($id,$request->all());
            return ok(['message' => t('updated_successfully')]);
        } catch (\Exception $ex) {
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

        $group = $this->group->findById($id);
        if (!$group) {
            return not_found(t('resource_not_found'));
        }
        try {
            $this->group->delete($id);
            return ok(['message' => t('deleted_successfully')]);
        } catch (\Exception $ex) {
            if ($ex->getCode() == 23000) {
                return bad_request(t('this_record_can_not_be_deleted_for_linking_to_other_records'));
            } else {
                return bad_request(t('error_is_occured'));
            }
        }
    }

    public function data() {
    

        return \Datatables::of($this->group->datatable())
                        ->make(true);
    }

}
