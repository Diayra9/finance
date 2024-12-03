<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert(array(
            0 =>
            array(
                'id' => 4,
                'name' => 'Dian',
                'email' => 'dianayurahmawati006@gmail.com',
                'password' => '$2y$10$d935fnlD94AgfL2zzGpUs.QXkUJV2IaCe9AD3AvKYNVf1B1nR1HQy',
                'created_at' => '2024-11-21 08:48:19',
                'updated_at' => '2024-11-21 08:48:19',
            ),
            1 =>
            array(
                'id' => 5,
                'name' => 'Admin',
                'email' => 'dianayurahmawati69@gmail.com',
                'password' => '$2y$10$DcQbcIODTXgH2AOO9pkM6.1yRWuY2rol2Y5kZnT.jGycKmed32bq6',
                'created_at' => '2024-12-01 06:40:10',
                'updated_at' => '2024-12-01 06:40:10',
            ),
        ));
    }
}
