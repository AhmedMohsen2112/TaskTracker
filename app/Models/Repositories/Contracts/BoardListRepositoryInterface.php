<?php

namespace App\Models\Repositories\Contracts;

interface BoardListRepositoryInterface {

    public function getAll($where_array = array());

    public function findForEdit($id);

    public function findById($id);

    public function create($data = array());

    public function update($id, $data = array());

    public function delete($id);

    public function datatable($where_array = array());
}
