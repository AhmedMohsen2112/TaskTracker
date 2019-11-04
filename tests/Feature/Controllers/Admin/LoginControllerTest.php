<?php

namespace Tests\Feature\Controllers\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase {

    protected function setUp(): void {
        parent::setUp();
        //$this->setBaseRoute('admin.login.index');
    }

    /** @test */
    public function is_login_form() {
        $response = $this->get(route('admin.login'));
        $view = 'main_content.admin.login';
        $response->assertViewIs($view);
    }

    /** @test */
    public function a_user_can_log_in() {

        $user = factory_create(\App\Models\User::class, [
            'name' => 'Ahmed',
            'username' => 'AhmedMohsen',
            'email' => 'mr.success789@gmail.com',
            'phone' => '01007363256',
            'type' => config('constants.users.admin_type'),
            'password' => bcrypt('123123')
        ]);

        $response = $this->post(route('admin.login.submit'), ['username' => $user->username, 'password' => '123123'])->assertSuccessful();
        $response
                ->assertStatus(200)
                ->assertJson([
                    'url' => route('admin.dashboard'),
        ]);
    }

}
