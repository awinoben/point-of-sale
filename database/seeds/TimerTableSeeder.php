<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;

class TimerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $timer = [
            [
                'id' => Uuid::generate()->string,
                'period' => config('timer.period'),
                'secret' => Hash::make(config('timer.secret_key') . config('timer.period')),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        //Store
        DB::table('timers')->insert($timer);
    }
}
