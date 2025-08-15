<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('roles')->insert([
            [
                'role_id' => '1',
                'role_name' => 'Admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'role_id' => '2',
                'role_name' => 'Dean',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'role_id' => '3',
                'role_name' => 'Chairperson',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'role_id' => '4',
                'role_name' => 'Bayanihan Leader',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'role_id' => '5',
                'role_name' => 'Bayanihan Teacher',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'role_id' => '6',
                'role_name' => 'Auditor',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
