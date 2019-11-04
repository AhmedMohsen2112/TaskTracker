<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\Repositories\Contracts\BoardListIssueRepositoryInterface;
use App\Http\Requests\Admin\BoardListIssuesRequest;
use App\Http\Requests\Admin\BoardListIssueCommentsRequest;
use App\Jobs\NotificationJob;
use App\Models\Repositories\NotiRepository;
use Validator;
use DB;

class BoardListIssuesController extends AdminController {

    private $board_list_issue;

    public function __construct(BoardListIssueRepositoryInterface $board_list_issue) {
        parent::__construct();
        $this->board_list_issue = $board_list_issue;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        return $this->_view('board_list_issues/create', 'backend');
    }

    /**
     * assign issue to multiple users
     *
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request) {
//        dd($request->all());
        DB::beginTransaction();
        try {

            $issue = [$request->input('issue')];
            $user = explode(',', $request->input('user'));
            $this->board_list_issue->assign($issue, $user);

            DB::commit();
            return ok(['message' => t('process_done_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return bad_request(t('error_is_occured'));
        }
    }

    public function sorting(Request $request) {
        try {
            $BoardListIssue = $this->board_list_issue->findById($request->input('issue'));
            if (!$BoardListIssue) {
                return not_found(t('resource_not_found'));
            }
            $index = $request->input('index');
            $list_id = $request->input('list');
            if ($BoardListIssue->ord > $index) { //down
                $this->board_list_issue->sorting_down($BoardListIssue->id, $index, $BoardListIssue->ord, $list_id);
            } else if ($BoardListIssue->ord < $index) {  //up
                $this->board_list_issue->sorting_up($BoardListIssue->id, $index, $BoardListIssue->ord, $list_id);
            }

            $this->board_list_issue->updateListAndOrder($BoardListIssue->id, $index, $list_id);
//            app(NotiRepository::class)->create($this->User, $BoardListIssue, config('constants.notifications.move_issue'));
            dispatch((new NotificationJob($this->User, $BoardListIssue, config('constants.notifications.move_issue')))->delay(\Carbon\Carbon::now()->addSeconds(config('constants.notifications_delay'))));
            return no_content();
        } catch (\Exception $ex) {
            dd($ex);
            return bad_request(t('error_is_occured'));
        }
    }

    public function store(BoardListIssuesRequest $request) {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['user_id'] = $this->User->id;
            $BoardListIssue = $this->board_list_issue->create($data);

            DB::commit();
            return created(['message' => t('added_successfully'), 'issue' => $BoardListIssue]);
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return bad_request(t('error_is_occured'));
        }
    }

    public function comment(BoardListIssueCommentsRequest $request) {
//         dd($request->all());
        DB::beginTransaction();
        try {
            $BoardListIssue = $this->board_list_issue->findById($request->input('issue'));
            if (!$BoardListIssue) {
                return not_found(t('resource_not_found'));
            }
            $data['issue'] = $request->input('issue');
            $data['comment'] = $request->input('comment');
            $data['user_id'] = $this->User->id;
            $comment = $this->board_list_issue->new_comment($data);
            $comment = $BoardListIssue->comments_list()->where('id', $comment->id)->first();
             app(NotiRepository::class)->create($this->User, $BoardListIssue, config('constants.notifications.new_comment_on_issue'));
//            dispatch((new NotificationJob($this->User, $BoardListIssue, config('constants.notifications.new_comment_on_issue')))->delay(\Carbon\Carbon::now()->addSeconds(config('constants.notifications_delay'))));

            DB::commit();
            return created(['message' => t('comment_is_added_successfully'), 'comment' => $comment]);
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return bad_request(t('error_is_occured'));
        }
    }

    public function upload(Request $request) {
//        dd($request->all());
        try {

            $name = $request->input('name');
            $files = $request->file('attachment');
            // dd($files);
            $new_uploaded = array();
            $count = 0;
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $file_arr = $this->board_list_issue->upload($file, true, $name, $request->input('attachment_id'));
                    $new_uploaded[$count] = $file_arr;
                    $count++;
                }
            }
            $json_arr['uploaded'] = $new_uploaded;
            dispatch((new NotificationJob($this->User, $this->board_list_issue->findById($request->input('attachment_id')), config('constants.notifications.new_attachment_on_issue')))->delay(\Carbon\Carbon::now()->addSeconds(config('constants.notifications_delay'))));

            return ok($json_arr);
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
            $BoardListIssue = $this->board_list_issue->findForEdit($id);
            if (!$BoardListIssue) {
                return not_found(t('resource_not_found'));
            }
            return ok($BoardListIssue);
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
    public function update(BoardListIssuesRequest $request, $id) {


        $BoardListIssue = $this->board_list_issue->findById($id);
        if (!$BoardListIssue) {
            return not_found(t('resource_not_found'));
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            $this->board_list_issue->update($id, $data);

            DB::commit();
            return ok(['message' => t('updated_successfully'), 'issue' => $this->board_list_issue->findById($id)]);
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
        $BoardListIssue = $this->board_list_issue->findById($id);
        if (!$BoardListIssue) {
            return _json('error', _lang('app.resource_not_found'), 404);
        }
        DB::beginTransaction();
        try {
            $BoardListIssue->delete();
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
