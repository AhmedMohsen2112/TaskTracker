<?php

namespace Tests\Feature\Controllers\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase {

    protected function setUp(): void {
        parent::setUp();
        //$this->setBaseRoute('admin.login.index');
    }

    /** @test */
    public function a_new_user_can_register() {

        $data=[
            'name' => 'Ahmed',
            'username' => 'AhmedMohsen',
            'email' => 'mr.success789@gmail.com',
            'phone' => '01007363256',
              'type' => config('constants.users.admin_type'),
            'password' => bcrypt('123123')
        ];

        $response = $this->post(route('admin.register.submit'), $data)->assertSuccessful();
        $this->assertEquals(200, $response->getStatusCode());
    }

}
