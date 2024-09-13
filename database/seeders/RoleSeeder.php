<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        DB::table('roles')->insert([
            ['name' => 'Haist Admin','created_at' => now(),'updated_at' => now()],
            ['name' => 'Admin','created_at' => now(),'updated_at' => now()],
            ['name' => 'Manager','created_at' => now(),'updated_at' => now()],
            ['name' => 'Nurse','created_at' => now(),'updated_at' => now()],
            ['name' => 'Assistant Nurse','created_at' => now(),'updated_at' => now()],
            ['name' => 'Worker','created_at' => now(),'updated_at' => now()],
            ['name' => 'Patient','created_at' => now(),'updated_at' => now()]
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
