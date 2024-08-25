<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;

class InitTest extends TestCase
{
    public function test_home_route()
    {
        $user = Users::where('type', '=', 'admin')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . Auth::tokenById($user->id))->get('/');
        $response->assertStatus(200)->assertJsonStructure(['time_cron', 'db_connection', 'time', 'memory', 'erros_import']);
    }

    public function test_home_user_not_acess()
    {
        $user = Users::where('type', '=', 'user')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . Auth::tokenById($user->id))->get('/');
        $response->assertStatus(401)->assertJsonStructure(['erro', 'message']);
    }

    public function test_login()
    {
        $response = $this->post('/login', ['email' => 'admin@email.com.br', 'password' => 'admin%123']);
        $response->assertStatus(200)->assertJsonStructure([
            'token',
            'type',
            'expires_in'
        ]);
    }

    public function test_login_wrong(): void
    {
        $response = $this->post('/login', ['email' => 'user_1@email.com.br', 'password' => '12323']);
        $response->assertStatus(401);
    }

    public function test_login_required(): void
    {
        $response = $this->post('/login');
        $response->assertStatus(422)->assertJsonStructure([
            'email',
            'password'
        ]);
    }

    public function test_logout(): void
    {
        $user = Users::first();
        $response = $this->withHeader('Authorization', 'Bearer ' . Auth::tokenById($user->id))->post('/logout');
        $response->assertStatus(200);
    }
}
