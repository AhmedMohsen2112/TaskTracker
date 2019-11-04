<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\Repositories\Contracts\AttachmentFileRepositoryInterface;
use App\Models\Repositories\Contracts\UserRepositoryInterface;
use App\Models\Repositories\Contracts\NotiRepositoryInterface;
use DB;

class AjaxController extends AdminController {

    private $location;

    public function __construct(AttachmentFileRepositoryInterface $attachment,  UserRepositoryInterface $user, NotiRepositoryInterface $noti) {
        parent::__construct();
        $this->attachment = $attachment;
        $this->user = $user;
        $this->noti = $noti;
    }
    


    function notifications(Request $request) {
        $offset = $request->input('offset', 0);
        $noti = $this->noti->getAll(['notifier_id' => $this->User->id, 'offset' => $offset]);
        return ok($noti);
    }


    public function change_lang(Request $request) {
        //dd('here');
        $lang_code = $request->input('lang_code');
        //dd($lang_code);
        $long = 7 * 60 * 24;
        return response()->json([
                    'type' => 'success',
                    'message' => $lang_code
                ])->cookie('AdminLang', $lang_code, $long);
    }


    public function delete_upload(Request $request, $id) {
        //dd($request->all());
        try {
            $AttachmentFile = $this->attachment->findById($id);
            if (!$AttachmentFile) {
                return not_found(t('resource_not_found'));
            }
            $AttachmentFile->delete();
            return no_content();
        } catch (\Exception $ex) {
            dd($ex);
            return bad_request(t('resource_not_found'));
        }
    }


    public function edit_upload($id) {
        try {
              $AttachmentFile = $this->attachment->findById($id);
            if (!$AttachmentFile) {
                return not_found(t('resource_not_found'));
            }
            //dd($Category->path());
            return ok($AttachmentFile);
        } catch (\Exception $ex) {
            dd($ex);
            return bad_request(t('error_is_occured'));
        }
    }

    public function update_upload(Request $request, $id) {


         $AttachmentFile = $this->attachment->findById($id);
        if (!$AttachmentFile) {
            return not_found(t('resource_not_found'));
        }

        DB::beginTransaction();
        try {
            $AttachmentFile->title = $request->input('title');
            $AttachmentFile->url = $request->input('url');
            $AttachmentFile->save();

            DB::commit();
            return ok(['message' => t('updated_successfully')]);
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return bad_request(t('error_is_occured'));
        }
    }


    public function searchUsers(Request $request) {

        //dd($request->all());
        $where_array['keyword'] = $request->input('q');
        $where_array['type'] = $request->input('type');
        $result = $this->user->search($where_array);
        return ok($result);
    }

}
