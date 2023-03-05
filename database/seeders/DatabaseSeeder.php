<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            ['username' => 'admin',
            'role'=> 1,
            'password' => Hash::make('password')],

            ['username' => 'kiosk',
            'role'=> 2,
            'password' => Hash::make('password')]
        ]);

        DB::table('offices')->insert([
            ['name' => 'Treasurer\'s Office', 'prefix' => 'T'],
            ['name' => 'Registrar', 'prefix' => 'R'],
            ['name' => 'Assessor\'s Office', 'prefix' => 'A'],
            ['name' => 'Mayor\'s Office', 'prefix' => 'M'],
            ['name' => 'Vice Mayor\'s Office', 'prefix' => 'V'],
        ]);

        DB::table('windows')->insert([
            ['office_id' => 1, 'number' => '1', 'purpose' => 'cedula'],
            ['office_id' => 1, 'number' => '2', 'purpose' => 'payments'],
            ['office_id' => 1, 'number' => '3', 'purpose' => 'miscellaneous'],
            ['office_id' => 2, 'number' => '1', 'purpose' => 'registrar'],
            ['office_id' => 2, 'number' => '2', 'purpose' => 'registrar'],
            ['office_id' => 3, 'number' => '1', 'purpose' => 'assessor'],
            ['office_id' => 3, 'number' => '2', 'purpose' => 'assessor'],
            ['office_id' => 3, 'number' => '3', 'purpose' => 'assessor'],


        ]);

        // DB::table('queues')->insert([
        //     ['office_id' => '1', 'number' => '1', 'code' => 'O1_0001', 'purpose' => 'payments'],
        // ]);
    }
}
