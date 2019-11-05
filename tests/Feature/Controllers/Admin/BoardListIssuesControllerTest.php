<?php

namespace Tests\Feature\Controllers\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
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
        $attributes = ['title' => $this->faker->realText(rand(50, 120)), 'description' => $this->faker->realText(rand(120, 180)), 'ord' => 1, 'list' => factory_create(BoardList::class)->id];
        $response = $this->post(route('admin.board.list.issues.store'), $attributes)->assertSuccessful();
        $model = new BoardListIssue;
        $this->assertDatabaseHas($model->getTable(), ['title' => $attributes['title'], 'description' => $attributes['description'], 'list_id' => $attributes['list']]);
        return $response;
    }

    /** @test */
    public function a_user_can_update_issue() {
        $this->signIn();
        $this->check_authenticated();
        $model = factory_create(BoardListIssue::class);
        $model->title = $model->title;
        $model->description = $model->description;
        $model->due_date = $this->faker->dateTimeThisCentury->format('Y-m-d');
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

    /** @test */
    public function a_user_can_sort_issue() {
        $this->signIn();
        $this->check_authenticated();
        $list = factory_create(BoardList::class);
        $attributes = ['title' => $this->faker->realText(rand(50, 120)), 'description' => $this->faker->realText(rand(120, 180)), 'ord' => 0, 'list_id' => $list->id];
        $data = [];
        foreach (range(0, 5) as $one) {
            $attributes['ord'] += 1;
            $data[] = factory_create(BoardListIssue::class, $attributes);
        }
//        dd($data);

        $response = $this->get(route('admin.board.list.issues.sorting') . '?' . http_build_query(['list' => $data[0]->list_id, 'index' => 2, 'issue' => $data[0]->id]))->assertSuccessful();
        $this->assertDatabaseHas($data[0]->getTable(), ['id' => $data[0]->id, 'ord' => 2, 'list_id' => $data[0]->list_id]);
        return $response;
    }

    /** @test */
    public function a_user_can_commented_on_issue() {
        $this->signIn();
        $this->check_authenticated();
        $model = factory_create(BoardListIssue::class);
        $params=['issue' => $model->id, 'comment' => 'test comment'];
        $response = $this->post(route('admin.board.list.issues.comment'), $params)->assertSuccessful();

        $this->assertDatabaseHas('comments', ['commentable_id' => $model->id, 'commentable_type' => get_class(new BoardListIssue),'comment'=>$params['comment']]);
        return $response;
    }
    
    
    /** @test */
    public function a_user_can_assign_issue() {
        $this->signIn();
        $this->check_authenticated();
        $model = factory_create(BoardListIssue::class);
        $users = factory_create(User::class,[],5);
        $params=['issue' => $model->id, 'user' => implode(',', $users->pluck('id')->toArray())];
        $response = $this->post(route('admin.board.list.issues.assign'), $params)->assertSuccessful();
        $this->assertDatabaseHas('board_list_issue_assignment', ['issue_id' => $model->id, 'user_id'=>$users[0]->id]);
        return $response;
    }

}
