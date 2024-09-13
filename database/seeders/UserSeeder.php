<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        DB::table('users')->insert([
            ['role_id' => 1,'first_name' => 'Syed','last_name' => 'Azlan Ali','email' => 'azlanali076@gmail.com','password' => bcrypt('admin123'),'created_at' => now(),'updated_at' => now()]
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
