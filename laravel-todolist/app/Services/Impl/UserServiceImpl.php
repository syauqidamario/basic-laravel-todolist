<?php

namespace App\Services\Impl;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserServiceImpl implements UserService
{

      private array $users = [
            "syauqi" => "secret"
      ];

      function login(string $email, string $password): bool
      {
            return Auth::attempt([
                  "email" => $email,
                  "password" => $password
            ]);
      }
}
