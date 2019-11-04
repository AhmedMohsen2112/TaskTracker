<?php

namespace App\Models\Repositories;

use App\Models\User;
use App\Models\Repositories\Contracts\UserRepositoryInterface;
use App\Models\Repositories\BaseRepository;
use App\Http\Transformers\Users\AuthUserTransformer;
use App\Http\Transformers\Users\UserSearchTransformer;
use Auth;
use DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

    protected $model;
    protected $auth;

    /**
     * UserRepository constructor.
     * @param App\Models\User $user
     */
    public function __construct(User $user, Auth $auth) {
        $this->model = $user;
        $this->auth = $auth;
    }

    /**
     * get users that have access on specific permission
     * 
     * @return App\Models\User
     */
    public function all_can($where_array = array()) {
        $permissions = implode('|', $where_array['permissions']);
        $data = $this->model->join('groups', function ($join) use($permissions) {
                            $join->on('groups.id', '=', 'users.group_id');
                            $join->whereRaw('CONCAT(",", groups.permissions, ",") REGEXP ",(' . $permissions . '),"');
                        })
                        ->pluck('users.id')->toArray();
        return $data;
    }

    /**
     * get authenticated user
     * 
     * @return App\Models\User
     */
    public function auth_user($guard, $with = []) {
        $auth_user = Auth::guard($guard)->user();
        if ($auth_user) {
            $auth_user = AuthUserTransformer::transform($auth_user, [], $with);
//            dd($auth_user);
        }
        return $auth_user;
    }

    /**
     * check authenticated user
     * 
     * @param array $credentials
     * @return App\Models\User
     */
    public function check_auth($credentials = array()) {
        $admin = $this->model->where('active', 1)
                ->where('username', $credentials['username'])
                ->where('type', $credentials['type'])
                ->select('*')
                ->first();
        //dd($Admin);
        if ($admin) {
            if (password_verify($credentials['password'], $admin->password)) {
                return $admin;
            }
        }
        return false;
    }

    /**
     * users search
     * 
     * @param array $params
     * @return mixed
     */
    public function search($where_array = array()) {
        $lang_code = $this->getLangCode();
        $result = $this->model->select(['id', 'name', 'phone', 'username', 'email']);
        $result->whereRaw($this->handleKeywordWhere(['name', 'phone', 'username', 'email'], $where_array['keyword']));
        if (isset($where_array['type'])) {
//            dd($where_array);
            $result->where('type', $where_array['type']);
        }
        $result = $result->paginate(10);
        $items = $result->getCollection()->transform(function($one, $key) {
            return UserSearchTransformer::transform($one);
        });
//        dd($data);
        $data['result'] = $items;
        $data['total'] = $result->total();
        return $data;
    }

    public function findForEdit($id) {
        $lang_code = getLocale();
        $data = $this->findById($id);
        if ($data) {
            
        }
        return $data;
    }

    public function findById($id) {
        $data = $this->model->find($id);
        return $data;
    }

    public function create($data = []) {
        $insert = [
            'name' => $data['name'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'active' => $data['active'],
            'type' => $data['type']
        ];
        if (isset($data['password']) && $data['password']) {
            $insert['password'] = bcrypt($data['password']);
        }
        if (isset($data['group']) && $data['group']) {
            $insert['group_id'] = $data['group'];
        }
        if (isset($data['user_id']) && $data['user_id']) {
            $insert['created_by'] = $data['user_id'];
        }

        $item = $this->model->create($insert);

        return $item;
    }

    public function update($id, $data = []) {
        $update = [
            'name' => $data['name'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'email' => $data['email']
        ];
        if (isset($data['password']) && $data['password']) {
            $update['password'] = bcrypt($data['password']);
        }
        if (isset($data['group']) && $data['group']) {
            $update['group_id'] = $data['group'];
        }
        if (isset($data['active']) && $data['active']) {
            $update['active'] = $data['active'];
        }
        $this->model->where('id', $id)->update($update);

        if (isset($data['hotel']) && $data['hotel']) {
            $this->handleHotelAssigned(explode(',', $data['hotel']), $id, $data['user_id']);
        }
    }

    public function delete($id) {
        $this->model->where('id', $id)->delete();
    }

    public function datatable($where_array = array()) {
        $data = $this->model->leftJoin('users as u2', 'u2.id', '=', 'users.created_by');
        if (isset($where_array['type'])) {
            $data->where('users.type', $where_array['type']);
        }
        if (isset($where_array['auth_user_id'])) {
            $data->where('users.id', '!=', $where_array['auth_user_id']);
        }
        $data = $data->select(['users.id', 'users.username', 'users.created_at', 'users.email', 'users.phone', 'users.active', 'u2.username as created_by']);
        return $data;
    }

}
