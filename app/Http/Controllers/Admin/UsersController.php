<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\Repositories\Contracts\UserRepositoryInterface;
use App\Models\Repositories\Contracts\GroupRepositoryInterface;
use App\Http\Requests\Admin\UsersRequest;
use Validator;

class UsersController extends AdminController {

    private $group;
    private $user;

    public function __construct(GroupRepositoryInterface $group, UserRepositoryInterface $user) {
        parent::__construct();
        $this->group = $group;
        $this->user = $user;

    }

    public function index() {
      
        $this->data['groups'] = $this->group->getAll();
        return $this->_view('users.index');
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
    public function store(UsersRequest $request) {

        try {
            $data = $request->all();
            $data['user_id'] = $this->User->id;
            $data['type'] = config('constants.users.admin_type');
            $this->user->create($data);
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
            $find = $this->user->findForEdit($id);

            if (!$find) {

                return not_found(t('resource_not_found'));
            }
            return ok($find);
        } catch (\Exception $ex) {
//            dd($ex);
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
    public function update(UsersRequest $request, $id) {
        //dd($request->all());
        $admin = $this->user->findById($id);
        if (!$admin) {
            return not_found(t('resource_not_found'));
        }
        try {
              $data = $request->all();
            $data['user_id'] = $this->User->id;
            $this->user->update($id, $data);
            return ok(['message' => t('updated_successfully')]);
        } catch (\Exception $ex) {
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
        $admin = $this->user->findById($id);
        if (!$admin) {
            return not_found(t('resource_not_found'));
        }
        try {
            $admin->delete();
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

        $where_array['auth_user_id'] = $this->User->id;
        $where_array['type'] = config('constants.users.admin_type');

        return \Datatables::of($this->user->datatable($where_array))
                        ->escapeColumns([])
                        ->make(true);
    }

}
