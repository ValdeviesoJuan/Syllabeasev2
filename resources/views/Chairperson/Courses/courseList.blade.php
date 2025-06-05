@extends('layouts.chairSidebar')

@section('content')
@include('layouts.modal')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <style>
        body {
            /* background-image: url("{{ asset('assets/Wave1.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            min-width: 100vh;
            background-size: contain; */
            background-color: #EEEEEE;
        }
    </style>
</head>

<body>
<div class="p-4 pb-10 shadow bg-white border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex justify-center align-items-center">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                <h1 class="font-bold text-4xl text-[#201B50] mb-4 ">Courses</h1>
                        <a class="whitespace-nowrap mb-6 w-50 bg-blue5 text-white rounded-lg mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex max-w-full" href="{{ route('chairperson.createCourse') }}">
                            <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Create New Course
                        </a>
                </div>
                <livewire:chair-courses />
                <div class='overflow-x-auto w-full'>
                    <!-- <table class='w-full table-auto overflow-scroll w-full p-6 text-left whitespace-nowrap'>
                        <thead>
                            <tr class="bg-blue text-2xl text-white">
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Code </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Title  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Lec Unit  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Lab Unit  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Credit Unit  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Lec Hours  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Lab Hours  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Pre Req  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Co Req  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Curriculum  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Year Level  </th>
                                <th class="px-6 py-3 text-start text-lg font-bold text-white uppercase"> Semester  </th>
                                <th class=""> </th>
                                <th class=""> </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#e5e7eb] bg-[#f9fafb] ">
                            @foreach ($courses as $course)
                                <tr>
                                    <td class="px-6 py-4 font-bold">
                                        <div class="flex items-center space-x-3">
                                            <div>
                                                <p>{{ $course->course_code }}</p>
                                            </div>
                                        </div>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_title }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="text-center">{{ $course->course_unit_lec }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="text-center">{{ $course->course_unit_lab }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="text-center">{{ $course->course_credit_unit }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="text-center">{{ $course->course_hrs_lec }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="text-center">{{ $course->course_hrs_lab}}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_pre_req }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_co_req }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->curr_code }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_year_level }}</p>
                                    </td>
        
                                    <td class="px-6 py-4">
                                        <p class="">{{ $course->course_semester }}</p>
                                    </td>
        
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('chairperson.editCourse', $course->course_id) }}" method="GET">
                                        @csrf
                                            <button type="submit" class="bg-blue p-1 rounded-lg mr-2 hover:bg-green">
                                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
        
                                    <td>
                                        <form action="{{ route('chairperson.destroyCourse',$course->course_id) }}" method="Post">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="bg-blue p-1 rounded-lg mr-2 shadow-lg hover:bg-red">
                                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 11V17" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M14 11V17" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M4 7H20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table> -->
<!-- 
                    <div class="mt-4">
                        <div class="flex justify-center">
                            <span class="text-gray-600 text-sm">Page {{ $courses->currentPage() }} of {{ $courses->lastPage() }}</span>
                        </div>
        
                        <div class="mb-9">
                            {{ $courses->links() }} 
                        </div>
                    </div> -->
                </div>

            </div>
        </div>
    </div>
</body>
</html>

@endsection

