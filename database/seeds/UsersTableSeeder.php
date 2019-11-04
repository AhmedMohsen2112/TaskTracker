<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Group;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $User = new User;
        $User->name = "developer";
        $User->username = "developer";
        $User->phone = "01007363256";
        $User->email = "mr.success789@gmail.com";
        $User->password = bcrypt('123123');
        $User->active = 1;
        $User->type = config('constants.users.admin_type');
        $User->group_id = $this->getGroup();
        $User->remember_token = str_random(10);
        $User->save();
    }

   

    private function getGroup() {
        $Group = new Group;
        $Group->name = 'developers';
        $Group->permissions = modulesAsJson();
        $Group->active = 1;
        $Group->save();
        return $Group->id;
    }

}
