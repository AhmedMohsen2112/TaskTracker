<?php

namespace Tests\Feature\Controllers\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Board;
use App\Models\BoardList;

class BoardListsControllerTest extends TestCase {

    use WithFaker;

    protected function setUp(): void {
        parent::setUp();
    }

    /** @test */
    public function a_user_can_create_list() {

        $this->signIn();
        $this->check_authenticated();
        $attributes =  ['title' => $this->faker->realText(rand(50,120)), 'board' => factory_create(Board::class)->id];
        $response = $this->post(route('admin.board.lists.store'), $attributes)->assertSuccessful();
        $model = new BoardList;
        $this->assertDatabaseHas($model->getTable(), ['title' => $attributes['title'], 'board_id' => $attributes['board']]);
        return $response;
    }

    /** @test */
    public function a_user_can_update_list() {
        $this->signIn();
        $this->check_authenticated();
        $model = factory_create(BoardList::class);
        $model->title = "Updated Title";
        $response = $this->patch(route('admin.board.lists.update', ['id' => $model->id]), $model->toArray())->assertSuccessful();
        $this->assertDatabaseHas($model->getTable(), $model->toArray());
        return $response;
    }

    /** @test */
    public function a_user_can_delete_board() {
        $this->signIn();
        $this->check_authenticated();
        $model = factory_create(BoardList::class);
        $response = $this->delete(route('admin.board.lists.delete', ['id' => $model->id]), $model->toArray())->assertSuccessful();
        $this->assertDatabaseMissing($model->getTable(), $model->toArray());
        return $response;
    }

}
