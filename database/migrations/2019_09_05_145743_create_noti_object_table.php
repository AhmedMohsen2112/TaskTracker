<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotiObjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noti_object', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('entity_id');
            $table->integer('entity_type_id');
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('notifiable_type')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noti_object');
    }
}
