<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
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
        $this->post('/login', [
            "user" => "syauqi",
            "password" => "secret"
        ])->assertRedirect("/")->assertSessionHas("user", "syauqi");
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
