<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
     'name' => 'テストユーザー',
     'email' => 'test123@example.com',
     'password' => Hash::make('coachtech123test'),
     ]);
    }
}
