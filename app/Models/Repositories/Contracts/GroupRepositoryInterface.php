<?php

namespace App\Models\Repositories\Contracts;

interface GroupRepositoryInterface {

    public function getAll();

    public function findForEdit($id);

    public function findById($id);

    public function create($data = array());

    public function update($id, $data = array());

    public function delete($id);

    public function datatable($where_array = array());
}
