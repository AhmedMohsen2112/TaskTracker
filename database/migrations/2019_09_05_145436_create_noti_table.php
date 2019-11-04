<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotiTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('noti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('noti_object_id');
            $table->bigInteger('notifier_id')->unsigned();
            $table->tinyInteger('read_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('noti');
    }

}
