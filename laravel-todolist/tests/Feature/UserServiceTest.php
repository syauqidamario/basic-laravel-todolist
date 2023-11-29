<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login("syauqi", "secret"));
    }

    public function testLoginUserNotFound()
    {
        self::assertFalse($this->userService->login("damario", "damario"));
    }

    public function testLoginWrongPassword()
    {
        self::assertFalse($this->userService->login("syauqi", "wrong"));
    }
}
