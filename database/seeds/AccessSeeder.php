<?php

use Illuminate\Database\Seeder;

use App\Access;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Access::create([
            'qr_code'    => sha1(uniqid()),
            'expire_day' => 0,
            'user_id'    => 1
        ]);
    }
}
