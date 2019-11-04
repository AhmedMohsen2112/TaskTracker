<?php

namespace App\Models\Repositories;

use App\Models\BoardListIssue;
use App\Models\Comment;
use App\Models\BoardListIssueAssignment;
use App\Models\Repositories\Contracts\BoardListIssueRepositoryInterface;
use App\Models\Repositories\BaseRepository;
use Auth;
use DB;

class BoardListIssueRepository extends BaseRepository implements BoardListIssueRepositoryInterface {

    protected $model;

    /**
     * UserRepository constructor.
     * @param App\Models\User $user
     */
    public function __construct(BoardListIssue $board_list_issue,Comment $comment) {
        $this->model = $board_list_issue;
        $this->comment = $comment;
    }

    /**
     * select all items with filter
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAll($where_array = array()) {
        $lang_code = getLocale();
        $result = $this->model->join('users', 'board_list_issues.created_by', '=', 'users.id');
        if (isset($where_array['list'])) {
            $result->where('board_list_issues.board_id', $where_array['board']);
        }
        $result = $result->select([
            'board_list_issues.id', "board_list_issues.title", "users.username as created_by", "board_list_issues.created_at"
        ]);
        return $result;
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\BoardListIssue
     */
    public function findForEdit($id) {
        $lang_code = $this->getLangCode();
        $data = $this->findById($id);
        if ($data) {
            $data->attachment_list = $this->transform_attachment($data->attachment);
            $data->assigned_list = $data->assigned_list();
            $data->comments_list = $data->comments_list();
        }
        return $data;
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\BoardListIssue
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
        $count = $this->model->where('list_id', $data['list'])->count();
//        dd($count);
        $item = $this->model->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'list_id' => $data['list'],
            'ord' => $count + 1,
            'created_by' => $data['user_id'],
        ]);
        $this->assign([$item->id], [$data['user_id']]);
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
            'description' => $data['description'],
            'due_date' => isset($data['due_date']) ? $data['due_date'] : NULL,
        ];
        $this->model->where('id', $id)->update($data_updated);
    }

    /**
     * new comment
     * 
     * @param array $data
     * @param int $id
     * @return void
     */
    public function new_comment($data = []) {

        $item = $this->comment->create([
            'comment' => $data['comment'],
            'commentable_id' => $data['issue'],
            'commentable_type' => get_class($this->model),
            'created_by' => $data['user_id'],
        ]);
        return $item;
    }
    /**
     * sorting up issue
     * 
     * @param int $id
     * @param int $index
     * @param int $old_order
     * @return void
     */
    public function sorting_up($id,$index,$old_order,$list_id) {

           $this->model->where('id', '!=', $id)
                        ->where('list_id', $list_id)
                        ->where(function ($query) use($old_order, $index) {
                            $query->where('ord', '>', $old_order)
                            ->where('ord', '<=', $index);
                        })
                        ->update(['ord' => DB::raw("ord-1")]);
    }
   
    
     /**
     * sorting down issue
     * 
     * @param int $id
     * @param int $index
     * @param int $old_order
     * @return void
     */
    public function sorting_down($id,$index,$old_order,$list_id) {

       $this->model->where('id', '!=', $id)
                        ->where('list_id', $list_id)
                        ->where(function ($query) use($old_order, $index) {
                            $query->where('ord', '>=', $index)
                            ->where('ord', '<', $old_order);
                        })
                        ->update(['ord' => DB::raw("ord+1")]);
    }
    
    
     /**
     * update list and order
     * 
     * @param int $id
     * @param int $index
     * @param int $list_id
     * @return void
     */
    public function updateListAndOrder($id,$index,$list_id) {

               $this->model->where('id', $id)
                    ->update(['ord' => $index, 'list_id' => $list_id]);
    }

    /**
     * assign issue to multiple users
     * 
     * @param array $data
     * @param int $id
     * @return void
     */
    public function assign($isuue = array(), $user = array()) {
        if (count($isuue) > 0 && count($user) > 0) {
            $data = [];
            foreach ($isuue as $isuue_id) {
                $old = BoardListIssueAssignment::where('issue_id', $isuue_id)->pluck('user_id')->toArray();
                $diff_result = array_diff($user, $old);
                BoardListIssueAssignment::whereNotIn('user_id', $user)->where('issue_id', $isuue_id)->delete();
                $data_insert = count($old) > 0 ? $diff_result : $user;
                $data_insert = array_values($data_insert);
//                dd($data_insert);
                if (count($data_insert) > 0 && (isset($data_insert[0]) && $data_insert[0])) {

                    foreach ($data_insert as $one) {
                        $data[] = array(
                            'user_id' => $one,
                            'issue_id' => $isuue_id,
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                        );
                    }
                }
            }
            BoardListIssueAssignment::insert($data);
        }
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
