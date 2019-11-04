<?php

namespace App\Models\Repositories\Contracts;

interface SettingRepositoryInterface {

    public function getAll();

    public function findBySlug($slug);

    public function update($id, $data = array());

    public function datatable();
}
