<?php

namespace App\Models\Repositories;

use App\Models\Group;
use App\Models\Repositories\Contracts\GroupRepositoryInterface;
use App\Models\Repositories\BaseRepository;
use Auth;

class GroupRepository extends BaseRepository implements GroupRepositoryInterface {

    protected $model;

 

    /**
     * UserRepository constructor.
     * @param App\Models\User $user
     */
    public function __construct(Group $group) {
        $this->model = $group;
    }

    /**
     * select all items
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAll() {
        return $this->model->select('id', 'name')->whereNotNull('created_by')->get();
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\Group
     */
    public function findForEdit($id) {
        $data = $this->findById($id);
        if ($data) {
            $data->permissions = explode(',',$data->permissions);
        }
        return $data;
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\Group
     */
    public function findById($id) {
        $data = $this->model->find($id);
        return $data;
    }

    /**
     * insert new record
     * 
     * @param array $data
     * @return void
     */
    public function create($data = []) {

        $this->model->create([
            'name' => $data['name'],
            'permissions' => isset($data['group_options']) ? implode(',',$data['group_options']) : NULL,
            'active' => $data['active'],
            'created_by' => $data['user_id'],
        ]);
    }

    /**
     * update record
     * 
     * @param array $data
     * @param int $id
     * @return void
     */
    public function update($id, $data = []) {
        $this->model->where('id', $id)->update([
            'name' => $data['name'],
            'permissions' => isset($data['group_options']) ? implode(',',$data['group_options']) : NULL,
            'active' => $data['active'],
        ]);
    }

     /**
     * delete record
     * 
     * @param int $id
     * @return void
     */
    public function delete($id) {
        $this->model->where('id', $id)->delete();
    }

     /**
     * select all records for datatable
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable($where_array=array()) {
        return $this->model->join('users', 'users.id', '=', 'groups.created_by')
                        ->select(['groups.id', 'groups.name', 'groups.active', 'users.username as created_by']);
    }

}
