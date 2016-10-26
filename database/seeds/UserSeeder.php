<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'name'     => 'Manager',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone'    => '0912000111',
            'level'    => 1,
            'fb_id'    => 'null'
        ]);
    }
}
