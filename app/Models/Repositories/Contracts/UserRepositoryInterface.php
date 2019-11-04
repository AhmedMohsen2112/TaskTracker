<?php

namespace App\Models\Repositories\Contracts;

interface UserRepositoryInterface {

    public function all_can($where_array = array());

    public function auth_user($guard, $with = []);

    public function check_auth($credentials = array());

    public function search($where_array = array());

    public function findForEdit($id);

    public function findById($id);

    public function create($data = array());

    public function update($id, $data = array());

    public function delete($id);

    public function datatable($where_array = array());
}
