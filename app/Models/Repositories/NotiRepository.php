<?php

namespace App\Models\Repositories;

use App\Models\Noti;
use App\Models\NotiObject;
use App\Models\Facilitable;
use App\Models\Repositories\Contracts\NotiRepositoryInterface;
use App\Models\Repositories\BaseRepository;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\NotiObjectRepository;
use App\Events\NotiEvent;
use App\Http\Transformers\Notifications\NotificationBasicTransformer;
use Auth;
use DB;
use Pusher;
use App\Helpers\OneSignal;

class NotiRepository extends BaseRepository implements NotiRepositoryInterface {

    protected $model;
    protected $noti_object;
    protected $user;

    /**
     * UserRepository constructor.
     * @param App\Models\User $user
     */
    public function __construct(Noti $noti, NotiObjectRepository $noti_object, UserRepository $user, Pusher $pusher) {
        $this->model = $noti;
        $this->noti_object = $noti_object;
        $this->user = $user;
        $this->pusher = $pusher;
    }

    /**
     * select all items with filter
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAll($where_array = array()) {
        $lang_code = getLocale();
        $title_sql = "'' as 'title'";
        $result = DB::table('noti_object as n_o')->join('noti as n', 'n.noti_object_id', '=', 'n_o.id');
        $result->join('users', 'n_o.user_id', '=', 'users.id');
        $result->select('n.id', 'n_o.id as noti_object_id', 'n_o.entity_id', 'n_o.entity_type_id', 'n.notifier_id', 'n_o.created_at', "users.username", 'n.read_status', DB::RAW($title_sql));
        if (isset($where_array['notifier_id'])) {
            $result->where(function ($query) use($where_array) {
                $query->where('n.notifier_id', $where_array['notifier_id']);
            });
        }
        if (isset($where_array['read_status'])) {
            $result->where('n.read_status', $where_array['read_status']);
        }

        if (isset($where_array['option']) && $where_array['option'] == 'count') {
            $result = $result->count();
        } else if (isset($where_array['option']) && $where_array['option'] == 'datatable') {
            $result = $result;
        } else {
            $result->orderBy('n_o.created_at', 'DESC');
            if (isset($where_array['offset'])) {
                $result->skip($where_array['offset']);
            }
//            dd($result->get());
            $result->limit(4);
            $result = NotificationBasicTransformer::transform($result->get());
        }


        return $result;
    }

    /**
     * mark notification as read by notifier
     * 
     * @return void
     */
    public function markAsReadByNotifier($notifier_id, $noti_object_id, $read_status = 1) {
        $sql = "UPDATE noti_object n_o 
                JOIN noti n ON n_o.id = n.noti_object_id And n.read_status=0 And n.notifier_id=$notifier_id And n_o.id=$noti_object_id             
                SET n.read_status = $read_status";
        DB::statement($sql);
    }

    /**
     * get all notification count by notifier
     * 
     * @return int
     */
    public  function allCount($notifier_id) {
        return $this->model->where('notifier_id', $notifier_id)->count();
    }

    /**
     * get all un read notification count by notifier
     * 
     * @return int
     */
    public  function unReadCount($notifier_id, $read_status = 0) {
        return $this->model->where('notifier_id', $notifier_id)->where('read_status', $read_status)->count();
    }

    /**
     * create new notification
     * 
     * @return int
     */
    public function create($auth_user, $entity, $entity_type, $notifiers = array()) {
        $NotiObject = $this->noti_object->create([
            'entity_id' => $entity->id,
            'entity_type_id' => $entity_type,
            'user_id' => $auth_user->id,
        ]);
        if (count($notifiers) == 0) {
            $notifiers = $this->noti_object->notifiers($entity_type,$entity->id);
        }
//        dd($notifiers);
        if (count($notifiers) > 0) {
            $notifiers_insert = [];

            foreach ($notifiers as $one) {
//                if ($auth_user->id == $one) {
//                    continue;
//                }
                $notifiers_insert[] = array(
                    'notifier_id' => $one,
                    'noti_object_id' => $NotiObject->id
                );
                $message = $this->noti_object->message($entity_type, $entity->id, $auth_user->username);
                $url = $this->noti_object->url($entity_type, $entity->id);
                $notification = ['noti_object_id' => $NotiObject->id, 'notifier_id' => $one, 'title' => t(''), 'message' => $message, 'type' => $entity_type, 'url' => $url];

//                event(new NotiEvent($notification));
//                dd($notification);
                
                
//                $this->pusher->trigger('notification', 'new_notification_' . $one, $notification);
//               $res= app(OneSignal::class)->trigger($notification);
//               dd($res);
            }
            $this->model->insert($notifiers_insert);
        }
    }

    /**
     * select all records for datatable with filter
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable($where_array = array()) {
        return $this->getAll($where_array);
    }

}
