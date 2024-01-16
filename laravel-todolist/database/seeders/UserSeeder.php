<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = "Syauqi D. Djohan";
        $user->email = "syauqidd@gmail.com";
        $user->password = bcrypt("secret");
        $user->save();
    }
}
