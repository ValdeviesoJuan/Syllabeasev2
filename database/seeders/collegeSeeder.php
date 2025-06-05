<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class collegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colleges')->insert([
            [
                'college_id' => '1',
                'college_code' => 'CEA',
                'college_description' => 'College of Engineering and Architecture',
                'college_status' => 'Active'
            ],
            [
                'college_id' => '2',
                'college_code' => 'CITC',
                'college_description' => 'College of Information TEchnology and Computing',
                'college_status' => 'Active'
            ],
            [
                'college_id' => '3',
                'college_code' => 'CSM',
                'college_description' => 'College of Science and Mathematics',
                'college_status' => 'Active'
            ],
            [
                'college_id' => '4',
                'college_code' => 'CSTE',
                'college_description' => 'College of Science and Technology Education',
                'college_status' => 'Active'
            ],
            [
                'college_id' => '5',
                'college_code' => 'CoT',
                'college_description' => 'College of Technology',
                'college_status' => 'Active'
            ],
        ]);
    }
}
