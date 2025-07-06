<!-- @-extends('layouts.adminNav') -->
@extends('layouts.adminSidebar')
@include('layouts.modal')

@section('content')
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
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain; 
            background-color: #EEEEEE;
        }
        </style>
</head>

<body>
    <div>
        <div class="p-4 shadow-lg bg-white border-dashed rounded-lg dark:border-gray-700 mt-10">
            <div class="" id="whole">
                <div class="flex overflow-hidden">
                    <div class="flex justify-between items-center mb-6 w-full">
                        <h2 class="ml-2 text-4xl mb-0 flex text-left text-black font-semibold leadi">Courses</h2>
                        <a href="{{ route('admin.createCourse') }}"
                           class="whitespace-nowrap rounded-xl hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex items-center gap-2 max-w-full"
                           style="background: #d7ecf9;"
                           onmouseover="this.style.background='#c3dff3';"
                           onmouseout="this.style.background='#d7ecf9';">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
                            </svg>
                            Create New Course
                        </a>
                    </div>
                </div>
                <livewire:admin-course-table />
                <div class='overflow-x-auto w-full'>
            </div>
        </div>
    </div>
</body>
</html>

@endsection






<!-- <body>
    <h1 class="">Courses</h1>
    <a href="{{ route('admin.createCourse') }}">Create New Course</a>
    <table class="">
        <thead>
            <tr>
                <th>Code</th>
                <th>Title</th>
                <th>Lec Unit</th>
                <th>Lab Unit</th>
                <th>Credit Unit</th>
                <th>Lec Hours</th>
                <th>Lab Hours</th>
                <th>Pre Req</th>
                <th>Co Req</th>
                <th>Curriculum</th>
                <th>Year Level</th>
                <th>Semester</th>
                <th class="actions_th">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $course->course_code }}</td>
                <td>{{ $course->course_title }}</td>
                <td>{{ $course->course_unit_lec }}</td>
                <td>{{ $course->course_unit_lab }}</td>
                <td>{{ $course->course_credit_unit }}</td>
                <td>{{ $course->course_hrs_lec }}</td>
                <td>{{ $course->course_hrs_lab}}</td>
                <td>{{ $course->course_pre_req }}</td>
                <td>{{ $course->course_co_req }}</td>
                <td>{{ $course->curr_code }}</td>
                <td>{{ $course->course_year_level }}</td>
                <td>{{ $course->course_semester }}</td>
                <td>

                    <form action="{{ route('admin.editCourse', $course->course_id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>

                    <form action="{{ route('admin.destroyCourse',$course->course_id) }}" method="Post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html> -->
