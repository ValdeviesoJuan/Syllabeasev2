<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            [
                'department_id' => '11', 
                'department_code' => 'DA',
                'department_name' => 'Department of Architecture',
		        'program_code' => 'BSA',
		        'program_name' => 'Bachelor of Science in Architecture',
                'department_status' => 'Active',
                'college_id' => '1',//CEA
            ],
            [
                'department_id' => '12', 
                'department_code' => 'DCE',
                'department_name' => 'Department of Civil Engineering',
		        'program_code' => 'BSCE',
		        'program_name' => 'Bachelor of Science in Civil Engineering',
                'department_status' => 'Active',
                'college_id' => '1',//CEA
            ],
            [
                'department_id' => '13', 
                'department_code' => 'DME',
                'department_name' => 'Department of Mechanical Engineering',
		        'program_code' => 'BSME',
		        'program_name' => 'Bachelor of Science in Mechanical Engineering',
                'department_status' => 'Active',
                'college_id' => '1',//CEA
            ],
            [
                'department_id' => '14', 
                'department_code' => 'DCpE',
                'department_name' => 'Department of Computer Engineering',
		        'program_code' => 'BSCpE',
		        'program_name' => 'Bachelor of Science in Computer Engineering',
                'department_status' => 'Active',
                'college_id' => '1',//CEA
            ],
            [
                'department_id' => '15', 
                'department_code' => 'DGE',
                'department_name' => 'Department of Geodetic Engineering',
		        'program_code' => 'BSGE',
		        'program_name' => 'Bachelor of Science in Geodetic Engineering',
                'department_status' => 'Active',
                'college_id' => '1',//CEA
            ],
            [
                'department_id' => '16', 
                'department_code' => 'DELECTRICAL',
                'department_name' => 'Department of Electrical Engineering',
		        'program_code' => 'BSELECTRICAL',
		        'program_name' => 'Bachelor of Science in Electrical Engineering',
                'department_status' => 'Active',
                'college_id' => '1',//CEA
            ],
            [
                'department_id' => '17', 
                'department_code' => 'DELECTRONICS',
                'department_name' => 'Department of Electronics Engineering',
		        'program_code' => 'BSELECTRONICS',
		        'program_name' => 'Bachelor of Science in Electronics Engineering',
                'department_status' => 'Active',
                'college_id' => '1',//CEA
            ],
            [
                'department_id' => '21', 
                'department_code' => 'DIT',
                'department_name' => 'Department of Information Technology',
		        'program_code' => 'BSIT',
		        'program_name' => 'Bachelor of Science in Information Technology',
                'department_status' => 'Active',
                'college_id' => '2', // CITC
            ],
            [
                'department_id' => '22', 
                'department_code' => 'DTCM',
                'department_name' => 'Department of Technology Communication Management',
		        'program_code' => 'BSTCM',
		        'program_name' => 'Bachelor of Science in Technology Communication Management',
                'department_status' => 'Active',
                'college_id' => '2', // CITC
            ],
            [
                'department_id' => '23', 
                'department_code' => 'DDS',
                'department_name' => 'Department of Data Science',
		        'program_code' => 'BSDS',
		        'program_name' => 'Bachelor of Science in Data Science',
                'department_status' => 'Active',
                'college_id' => '2', // CITC
            ],
            [
                'department_id' => '24', 
                'department_code' => 'DCS',
                'department_name' => 'Department of Computer Science',
		        'program_code' => 'BSCS',
		        'program_name' => 'Bachelor of Science in Computer Science',
                'department_status' => 'Active',
                'college_id' => '2', // CITC
            ],
            [
                'department_id' => '31', 
                'department_code' => 'DAPPLIEDMATH',
                'department_name' => 'Department of Applied Mathematics',
		        'program_code' => 'BSAPPLIEDMATH',
		        'program_name' => 'Bachelor of Science in Applied Mathematics',
                'department_status' => 'Active',
                'college_id' => '3', // CSM
            ],
            [
                'department_id' => '32', 
                'department_code' => 'DAPPLIEDPHYSICS',
                'department_name' => 'Department of Applied Physics',
		        'program_code' => 'BSAPPLIEDPHYSICS',
		        'program_name' => 'Bachelor of Science in Applied Physics',
                'department_status' => 'Active',
                'college_id' => '3', // CSM
            ],
            [
                'department_id' => '33', 
                'department_code' => 'DCHEM',
                'department_name' => 'Department of Chemistry',
		        'program_code' => 'BSCHEM',
		        'program_name' => 'Bachelor of Science in Chemistry',
                'department_status' => 'Active',
                'college_id' => '3', // CSM
            ],
            [
                'department_id' => '34', 
                'department_code' => 'DENVISCI',
                'department_name' => 'Department of Environmental Science',
		        'program_code' => 'BSENVISCI',
		        'program_name' => 'Bachelor of Science in Environmental Science',
                'department_status' => 'Active',
                'college_id' => '3', // CSM
            ],
            [
                'department_id' => '35', 
                'department_code' => 'DFOODTECH',
                'department_name' => 'Department of Food Technology',
		        'program_code' => 'BSFOODTECH',
		        'program_name' => 'Bachelor of Science in Food Technology',
                'department_status' => 'Active',
                'college_id' => '3', // CSM
            ],
            [
                'department_id' => '41', 
                'department_code' => 'DEDMS',
                'department_name' => 'Department of Secondary Education Major in Science',
		        'program_code' => 'BSEDMS',
		        'program_name' => 'Bachelor in Secondary Education Major in Science',
                'department_status' => 'Active',
                'college_id' => '4', // CSTE
            ],
            [
                'department_id' => '42', 
                'department_code' => 'DEMS',
                'department_name' => 'Department of Secondary Education Major in Mathematics',
		        'program_code' => 'BSEMS',
		        'program_name' => 'Bachelor in Secondary Education Major in Mathematics',
                'department_status' => 'Active',
                'college_id' => '4', // CSTE
            ],
            [
                'department_id' => '43', 
                'department_code' => 'DTLED',
                'department_name' => 'Department of Technology and Livelihood Education',
		        'program_code' => 'BTLED',
		        'program_name' => 'Bachelor in Technology and Livelihood Education',
                'department_status' => 'Active',
                'college_id' => '4', // CSTE
            ],
            [
                'department_id' => '44', 
                'department_code' => 'DTVTED',
                'department_name' => 'Department of Technical-Vocational Teacher Education',
		        'program_code' => 'BTVTED',
		        'program_name' => 'Bachelor in Technical-Vocational Teacher Education',
                'department_status' => 'Active',
                'college_id' => '4', // CSTE
            ],
            [
                'department_id' => '51', 
                'department_code' => 'DET',
                'department_name' => 'Department of Electronics Technology',
		        'program_code' => 'BSET',
		        'program_name' => 'Bachelor of Science in Electronics Technology',
                'department_status' => 'Active',
                'college_id' => '5', // CoT
            ],
            [
                'department_id' => '52', 
                'department_code' => 'DAUTOTRONICS',
                'department_name' => 'Department of Autotronics',
		        'program_code' => 'BSAUTOTRONICS',
		        'program_name' => 'Bachelor of Science Autotronics',
                'department_status' => 'Active',
                'college_id' => '5', // CoT
            ],
            [
                'department_id' => '53', 
                'department_code' => 'DESM',
                'department_name' => 'Department of Energy Systems and Management',
		        'program_code' => 'BSESM',
		        'program_name' => 'Bachelor of Science in Energy Systems and Management',
                'department_status' => 'Active',
                'college_id' => '5', // CoT
            ],
            [
                'department_id' => '54', 
                'department_code' => 'DEMT',
                'department_name' => 'Department of Electro-Mechanical Technology',
		        'program_code' => 'BSEMT',
		        'program_name' => 'Bachelor of Science in Electro-Mechanical Technology',
                'department_status' => 'Active',
                'college_id' => '5', // CoT
            ], 
            [
                'department_id' => '55', 
                'department_code' => 'DMET',
                'department_name' => 'Department of Manufacturing Engineering Technology',
		        'program_code' => 'BSMET',
		        'program_name' => 'Bachelor of Science in Manufacturing Engineering Technology',
                'department_status' => 'Active',
                'college_id' => '5', // CoT
            ],
        ];

        foreach ($data as $record) {
            DB::table('departments')->insert($record);
        }
    }
}