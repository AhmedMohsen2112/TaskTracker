<?php

use Illuminate\Database\Seeder;
use App\Models\Group;

class UpdatePermissionsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $permissions=modulesAsJson();
        
        Group::where('id',1)->update(['permissions'=>$permissions]);
    }
    



}
