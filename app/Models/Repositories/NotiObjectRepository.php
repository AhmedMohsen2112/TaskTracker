<?php

namespace App\Models\Repositories;

use App\Models\Noti;
use App\Models\NotiObject;
use App\Models\Facilitable;
use App\Models\Repositories\Contracts\NotiObjectRepositoryInterface;
use App\Models\Repositories\Contracts\BoardListIssueRepositoryInterface;
use App\Models\Repositories\BaseRepository;
use App\Http\Transformers\Notifications\NotificationBasicTransformer;
use Auth;
use DB;

class NotiObjectRepository extends BaseRepository implements NotiObjectRepositoryInterface {

    protected $model;
    protected $user;

    /**
     * UserRepository constructor.
     * @param App\Models\User $user
     */
    public function __construct(NotiObject $noti_object) {
        $this->model = $noti_object;
    }

    /**
     * get notification message
     * 
     * @return \Illuminate\Support\Collection
     */
    public function message($entity_type, $entity_id, $username) {
        $issue_repo = app(BoardListIssueRepositoryInterface::class);
        switch ($entity_type) {
            case config('constants.notifications.move_issue'):
                $issue = $issue_repo->findById($entity_id);
                $message = $username.' ' .  t('moved').' '.( $issue ? $issue->title : '') ;
                break;
            case config('constants.notifications.new_comment_on_issue'):
                $issue = $issue_repo->findById($entity_id);
                $message = $username.' ' .  t('commented_on').' '.( $issue ? $issue->title : '') ;
                break;
            case config('constants.notifications.new_attachment_on_issue'):
                $issue = $issue_repo->findById($entity_id);
                $message = $username.' ' .  t('has_attached_new_file_on_issue').' '.( $issue ? $issue->title : '') ;
                break;


            default:
                $message = '';
                break;
        }
        return $message;
    }

    /**
     * get notification url
     * 
     * @return \Illuminate\Support\Collection
     */
    public function url($entity_type, $entity_id, $layout = 'admin') {
        $issue_repo = app(BoardListIssueRepositoryInterface::class);
        switch ($entity_type) {
            case config('constants.notifications.move_issue'):
                $issue = $issue_repo->findById($entity_id);
                $url = route("admin.boards.view", ['id' => $issue->board_list->board->id]);
                break;
            case config('constants.notifications.new_comment_on_issue'):
                $issue = $issue_repo->findById($entity_id);
                $url = route("admin.boards.view", ['id' => $issue->board_list->board->id]);
                break;
            case config('constants.notifications.new_attachment_on_issue'):
                $issue = $issue_repo->findById($entity_id);
                $url = route("admin.boards.view", ['id' => $issue->board_list->board->id]);
                break;



            default:
                $url = '';
                break;
        }
        return $url;
    }

    /**
     * get notification notifiers
     * 
     * @return \Illuminate\Support\Collection
     */
    public function notifiers($entity_type,$entity_id) {
        $issue_repo = app(BoardListIssueRepositoryInterface::class);
        switch ($entity_type) {
            case config('constants.notifications.move_issue'):
                   $issue = $issue_repo->findById($entity_id);
                $notifiers = $issue->assigned_list()->pluck('id')->toArray();
                break;
            case config('constants.notifications.new_comment_on_issue'):
                   $issue = $issue_repo->findById($entity_id);
                $notifiers = $issue->assigned_list()->pluck('id')->toArray();
                break;
            case config('constants.notifications.new_attachment_on_issue'):
                   $issue = $issue_repo->findById($entity_id);
                $notifiers = $issue->assigned_list()->pluck('id')->toArray();
                break;

            default:
                $notifiers = [];
                break;
        }
        return $notifiers;
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\NotiObject
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
        return $this->model->create($data);
    }

}
