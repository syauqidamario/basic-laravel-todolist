<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from users");
    }
    public function testLoginPage()
    {
        $this->get('/login')->assertSeeText("login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "syauqi"
        ])->get('/login')
            ->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        $this->post('/login', [
            "user" => "syauqidd@gmail.com",
            "password" => "secret"
        ])->assertRedirect("/")->assertSessionHas("user", "syauqidd@gmail.com");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "syauqi"
        ])->post('/login', [
            "user" => "syauqi",
            "password" => "secret"
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "syauqi"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }
}
