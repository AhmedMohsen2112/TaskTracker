<?php

namespace Tests\Feature\Controllers\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Board;

class BoardsControllerTest extends TestCase {


    protected function setUp(): void {
        parent::setUp();
    }

    /** @test */
    public function a_user_can_create_board() {
        $this->signIn();
        $this->check_authenticated();
        $attributes = factory_raw(Board::class);
        $response = $this->post(route('admin.boards.store'), $attributes)->assertSuccessful();
        $model= new Board;
        $this->assertDatabaseHas($model->getTable(), $attributes);
        return $response;

    
    }
    
    
     /** @test */
    public function a_user_can_update_board() {
        $this->signIn();
        $this->check_authenticated();
        $model = factory_create(Board::class);
        $model->title = "Updated Title";
        $response = $this->patch(route('admin.boards.update',['id'=>$model->id]), $model->toArray())->assertSuccessful();
        $this->assertDatabaseHas($model->getTable(), $model->toArray());
        return $response;

    
    }
    
    
      /** @test */
    public function a_user_can_delete_board() {
        $this->signIn();
        $this->check_authenticated();
        $model = factory_create(Board::class);
        $response = $this->delete(route('admin.boards.delete',['id'=>$model->id]), $model->toArray())->assertSuccessful();
        $this->assertDatabaseMissing($model->getTable(), $model->toArray());
        return $response;

    
    }



}
