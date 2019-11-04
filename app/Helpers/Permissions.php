<?php

namespace App\Helpers;

use App\Models\Group;
use Auth;

class Permissions {

    public static function check($page, $permission = "open") {
        //dd('sss');

        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            //dd($user);
            $group = $user->group;
//            dd($group);
            if ($group) {

                $permissions = explode(',', $group->permissions);
                $check = $page . '_' . $permission;
//                dd($permissions);
                if (in_array($check, $permissions)) {
                    return true;
                }
            }
        }

        return false;
    }

}
