<?php

namespace App\Models\Repositories\Contracts;

interface NotiRepositoryInterface {

    public  function getAll($where_array = array());

    public function markAsReadByNotifier($notifier_id, $noti_object_id, $read_status = 1);

    public  function allCount($notifier_id);

    public function unReadCount($notifier_id, $read_status);

    public function create($auth_user, $entity, $entity_type, $notifiers = array());
    
     public function datatable($where_array = array());
}
