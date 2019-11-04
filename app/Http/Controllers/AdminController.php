<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Models\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Traits\BasicTrait;
use Auth;
use Image;
use Config;
use Mail;
use DB;
use Cookie;

class AdminController extends Controller {

    use BasicTrait;

    public $lang_code;
    public $User;
    public $data = array();

    public function __construct() {
        $this->middleware('auth.admin');
        $this->init();
    }

    private function init() {
        $this->User = app(UserRepositoryInterface::class)->auth_user('admin',['withPermissions']);
        $this->data['User'] = $this->User;
        $this->locales = config('settings.locales');
        $this->lang_code = getLocale();
        $this->data['sidebar_close']=true;
      
    }


    protected function _view($main_content) {
        $main_content = "main_content/admin/$main_content";
        return view($main_content, $this->data);
    }

}
