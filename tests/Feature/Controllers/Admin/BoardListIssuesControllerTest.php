<?php

namespace Tests\Feature\Controllers\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\BoardListIssue;

class BoardListIssuesControllerTest extends TestCase {

    use WithFaker;

    protected function setUp(): void {
        parent::setUp();
    }

    /** @test */
    public function a_user_can_create_issue() {

        $this->signIn();
        $this->check_authenticated();
        $attributes =  ['title' => $this->faker->realText(rand(50,120)),'description' => $this->faker->realText(rand(120,180)),'ord'=>1, 'list' => factory_create(BoardList::class)->id];
        $response = $this->post(route('admin.board.list.issues.store'), $attributes)->assertSuccessful();
        $model = new BoardListIssue;
        $this->assertDatabaseHas($model->getTable(), ['title' => $attributes['title'],'description' => $attributes['description'], 'list_id' => $attributes['list']]);
        return $response;
    }

    /** @test */
    public function a_user_can_update_issue() {
        $this->signIn();
        $this->check_authenticated();
        $model = factory_create(BoardListIssue::class);
        $model->title = $model->title;
        $model->description = $model->description;
        $model->due_date=  $this->faker->dateTimeThisCentury->format('Y-m-d'); 
        $response = $this->patch(route('admin.board.list.issues.update', ['id' => $model->id]), $model->toArray())->assertSuccessful();
        $this->assertDatabaseHas($model->getTable(), $model->toArray());
        return $response;
    }

    /** @test */
    public function a_user_can_delete_issue() {
        $this->signIn();
        $this->check_authenticated();
        $model = factory_create(BoardListIssue::class);
        $response = $this->delete(route('admin.board.list.issues.delete', ['id' => $model->id]), $model->toArray())->assertSuccessful();
        $this->assertDatabaseMissing($model->getTable(), $model->toArray());
        return $response;
    }

}
