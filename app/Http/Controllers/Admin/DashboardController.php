<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Repositories\Contracts\UserRepositoryInterface;
use App\Models\Repositories\Contracts\BoardRepositoryInterface;
use DB;
use Auth;
use Pusher\Pusher;

class DashboardController extends AdminController {

    public function __construct(UserRepositoryInterface $user, BoardRepositoryInterface $board) {
        parent::__construct();
        $this->user = $user;
        $this->board = $board;
    }

    public function index() {
        $this->data['boards'] = $this->board->getList(['limit'=>8]);
        return $this->_view('index');
    }

}
