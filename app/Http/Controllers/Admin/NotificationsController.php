<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\Repositories\Contracts\NotiRepositoryInterface;
use App\Models\Repositories\Contracts\NotiObjectRepositoryInterface;
use App\Models\Category;
use App\Models\LocationCategory;
use App\Http\Requests\Admin\MealPlansRequest;
use Validator;
use DB;

class NotificationsController extends AdminController {

    private $noti;
    private $noti_object;

    public function __construct(NotiRepositoryInterface $noti, NotiObjectRepositoryInterface $noti_object) {
        parent::__construct();
//        $this->middleware('CheckPermission:meal_plans,open', ['only' => ['index']]);
//        $this->middleware('CheckPermission:meal_plans,add_edit', ['only' => ['store', 'edit', 'update']]);
//        $this->middleware('CheckPermission:meal_plans,delete', ['only' => ['destroy']]);
        $this->noti = $noti;
        $this->noti_object = $noti_object;
    }

    public function index(Request $request) {
        return $this->_view('notifications/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try {
            $noti_object = $this->noti_object->findById($id);
            if (!$noti_object) {
                return abort(404);
            }
            $this->noti->markAsReadByNotifier($this->User->id, $noti_object->id);
            $url = $this->noti_object->url($noti_object->entity_type_id, $noti_object->entity_id);
//            dd($noti_object->entity_type_id);
            return redirect($url);
        } catch (\Exception $ex) {
            dd($ex);
            return abort(400);
        }
    }

    public function data(Request $request) {

        return \Datatables::of($this->noti->datatable(['notifier_id' => $this->User->id,'option'=>'datatable']))
                        ->addColumn('message', function ($item) {
                            return $this->noti_object->message($item->entity_type_id, $item->entity_id, $item->username);
                        })
                        ->addColumn('time', function ($item) {
                            return \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans();
                        })
                        ->addColumn('url', function ($item) {
                            return $this->noti_object->url($item->entity_type_id, $item->entity_id);
                        })
                        ->make(true);
    }

}
