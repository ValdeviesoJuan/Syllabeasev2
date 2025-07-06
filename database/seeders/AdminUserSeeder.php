<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create the user
        $userId = DB::table('users')->insertGetId([
            'email' => 'ratunil.josiah30@gmail.com',
            'password' => Hash::make('123456789'),
            'firstname' => 'Josiah Joshua',
            'lastname' => 'Ratunil',
            'prefix' => null,
            'suffix' => null,
            'phone' => '09123456789',
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign admin role (role_id = 1)
        DB::table('user_roles')->insert([
            'user_id' => $userId,
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
