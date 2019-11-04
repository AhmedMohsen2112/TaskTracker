<?php

namespace App\Models\Repositories\Contracts;

interface BoardRepositoryInterface {

    public function getAll($where_array = array());

    public function findForEdit($id);

    public function findForView($id);

    public function findById($id);

    public function create($data = array());

    public function update($id, $data = array());

    public function delete($id);

}
