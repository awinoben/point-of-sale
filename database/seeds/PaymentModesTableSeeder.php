<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class PaymentModesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        //create custom users here
        $modes = [
            [
                'id' => Uuid::generate()->string,
                'mode' => env('MODE_MPESA'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Uuid::generate()->string,
                'mode' => env('MODE_CASH'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Uuid::generate()->string,
                'mode' => env('MODE_CREDIT'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Uuid::generate()->string,
                'mode' => env('MODE_BANK'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Uuid::generate()->string,
                'mode' => env('MODE_EQUITY'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        //store here
        DB::table('payment_modes')->insert($modes);
    }
}
