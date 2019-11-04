<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
//        Setting::truncate();
        Setting::insert([
            ['name' => 'general','slug' => 'general', 'value' => NULL]
        ]);
    }

}
