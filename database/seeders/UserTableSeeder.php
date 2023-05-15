<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            // Super Admin
            [
                'role' => 'Super Admin',
                'name' => 'Super Admin',
                'email' => 'superadmin@email.com',
                'profile_photo' => 'default_profile_photo.png',
                'status' => 'Active',
                'last_active' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'branch_id' => Null,
                'created_at' => Carbon::now(),
            ],
            // Admin
            [
                'role' => 'Admin',
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'profile_photo' => 'default_profile_photo.png',
                'status' => 'Active',
                'last_active' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'branch_id' => Null,
                'created_at' => Carbon::now(),
            ],
            // Manager
            [
                'role' => 'Manager',
                'name' => 'Manager',
                'email' => 'manager@email.com',
                'profile_photo' => 'default_profile_photo.png',
                'status' => 'Active',
                'last_active' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'branch_id' => 1,
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
