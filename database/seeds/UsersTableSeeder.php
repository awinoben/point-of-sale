<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        DB::table((new User())->getTable())->insert(
            [
                [
                    'id' => Uuid::generate()->string,
                    'name' => 'System Account',
                    'email' => 'dev.techguy@gmail.com',
                    'phoneNumber' => '0713255791',
                    'pin' => random_int(10000, 50000),
                    'superAdmin' => true,
                    'email_verified_at' => now(),
                    'password' => bcrypt('0713255791'), // password
                    'remember_token' => Str::random(10),
                ]
            ]);
    }
}
