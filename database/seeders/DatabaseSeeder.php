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
            ['name' => 'Office 1', 'prefix' => 'O1'],
            ['name' => 'Office 2', 'prefix' => 'O2'],
            ['name' => 'Office 3', 'prefix' => 'O3'],
            ['name' => 'Office 4', 'prefix' => 'O4'],
            ['name' => 'Office 5', 'prefix' => 'O5'],
        ]);

        DB::table('queues')->insert([
            ['office_id' => '1', 'number' => '1', 'code' => 'O1_0001'],
        ]);
    }
}
