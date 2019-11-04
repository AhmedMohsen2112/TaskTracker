<?php

namespace App\Models\Repositories;

use App\Models\BoardList;
use App\Models\BoardListTranslation;
use App\Models\Repositories\Contracts\BoardListRepositoryInterface;
use App\Models\Repositories\BaseRepository;
use Auth;
use DB;

class BoardListRepository extends BaseRepository implements BoardListRepositoryInterface {

    protected $model;

    /**
     * UserRepository constructor.
     * @param App\Models\User $user
     */
    public function __construct(BoardList $board_list) {
        $this->model = $board_list;
    }

    /**
     * select all items with filter
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAll($where_array = array()) {
        $lang_code = getLocale();
        $result = $this->model->join('users', 'board_lists.created_by', '=', 'users.id');
        if(isset($where_array['board'])){
            $result->where('board_lists.board_id',$where_array['board']);
        }
        $result = $result->select([
            'board_lists.id',"board_lists.title", "users.username as created_by", "board_lists.created_at"
        ]);
        return $result;
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\BoardList
     */
    public function findForEdit($id) {
        $lang_code = $this->getLangCode();
        $data = $this->findById($id);
        if ($data) {

        }
        return $data;
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\BoardList
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
        $item = $this->model->create([
            'title' => $data['title'],
            'board_id' => $data['board'],
            'created_by' => $data['user_id'],
        ]);
        return $item;

    }

    /**
     * update record
     * 
     * @param array $data
     * @param int $id
     * @return void
     */
    public function update($id, $data = []) {
        $data_updated = [
              'title' => $data['title'],
        ];
        $this->model->where('id', $id)->update($data_updated);


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
     * select all records for datatable with filter
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable($where_array = array()) {

        return $this->getAll($where_array);
    }

    /**
     * select all records for list
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList($where_array = array()) {

        return $this->getAll($where_array)->get();
    }

}
