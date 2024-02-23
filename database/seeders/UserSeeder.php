<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role')->insert([
            'role' => 'owner'
        ]);
        DB::table('role')->insert([
            'role' => 'admin'
        ]);
        DB::table('role')->insert([
            'role' => 'manager'
        ]);

        DB::table('users')->insert([
            'username'  => 'admin',
            'name'      => 'Kenma Kanesi',
            'role_id'   => 2,
            'password'  => Hash::make('password')
        ]);

        DB::table('users')->insert([
            'username'  => 'owner',
            'name'      => 'Renge',
            'role_id'   => 1,
            'password'  => Hash::make('password')
        ]);

        DB::table('users')->insert([
            'username'  => 'manager',
            'name'      => 'Violet',
            'role_id'   => 3,
            'password'  => Hash::make('password')
        ]);

    }
}
