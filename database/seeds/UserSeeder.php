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
            'name'     => '顏敬柏',
            'email'    => 'jeremy5189@gmail.com',
            'password' => Hash::make('password'),
            'phone'    => '0912000111',
            'level'    => 1,
            'fb_id'    => 'null'
        ]);

        User::create([
            'name'     => '陳儀玲',
            'email'    => 'jolin1234x@gmail.com',
            'password' => Hash::make('password'),
            'phone'    => '0912000111',
            'level'    => 1,
            'fb_id'    => 'null'
        ]);

        User::create([
            'name'     => '林美馨',
            'email'    => 'ear120ear120@gmail.com',
            'password' => Hash::make('password'),
            'phone'    => '0912000111',
            'level'    => 1,
            'fb_id'    => 'null'
        ]);
    }
}
