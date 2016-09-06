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
            'qr_code'    => 'e472b7e8d315004ec7a14268f18f95d8a9728173',
            'expire_day' => 0,
            'user_id'    => 1
        ]);
    }
}
