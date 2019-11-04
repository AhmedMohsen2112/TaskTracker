<?php

namespace App\Models\Repositories;

use App\Models\Board;
use App\Models\BoardList;
use App\Models\BoardTranslation;
use App\Models\Repositories\Contracts\BoardRepositoryInterface;
use App\Models\Repositories\BaseRepository;
use Auth;
use DB;

class BoardRepository extends BaseRepository implements BoardRepositoryInterface {

    protected $model;

    /**
     * UserRepository constructor.
     * @param App\Models\User $user
     */
    public function __construct(Board $board) {
        $this->model = $board;
    }

    /**
     * select all items with filter
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAll($where_array = array()) {
        $lang_code = getLocale();
        $result = $this->model->join('users', 'boards.created_by', '=', 'users.id');

        $result = $result->select([
            'boards.id', "boards.title", "users.username as created_by", "boards.created_at"
        ]);
        $result->orderBy('boards.created_at','desc');
        if (isset($where_array['limit'])) {
            $result->limit($where_array['limit']);
        }

        return $result;
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\Board
     */
    public function findForEdit($id) {
        $lang_code = $this->getLangCode();
        $data = $this->findById($id);
        if ($data) {
            
        }
        return $data;
    }

    /**
     * find one for view
     * 
     * @param int $id
     * @return App\Models\Board
     */
    public function findForView($id) {
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
     * @return App\Models\Board
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
            'created_by' => $data['user_id'],
        ]);
        $item->lists()->saveMany([
            new BoardList(['title' => 'To Do']),
            new BoardList(['title' => 'In Progress']),
            new BoardList(['title' => 'Done'])
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
     * select all records for list
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList($where_array = array()) {

        return $this->getAll($where_array)->get();
    }

}
