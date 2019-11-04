<?php

namespace App\Models\Repositories\Contracts;

interface NotiObjectRepositoryInterface {

    public function create($data = []);

    public function message($entity_type, $entity_id, $username);

    public function url($entity_type, $entity_id);

    public function notifiers($entity_type,$entity_id);
}
