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
            /* background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain; */
            background-color: #EEEEEE;
        }
        </style>
</head>

<body>
    <div>
        <div class="p-4 shadow-lg bg-white border-dashed rounded-lg dark:border-gray-700 mt-10">
            <div class="" id="whole">
                <div class="flex overflow-hidden">
                    <h2 class="ml-2 text-4xl mb-4 flex text-left text-black font-semibold leadi ">Courses</h2>
                </div>
                <a class="ml-2 whitespace-nowrap mb-6 w-50 bg-seThird rounded-xl mr-1.5 hover:scale-105 w-max transition ease-in-out p-2 text-black font-semibold flex max-w-full " href="{{ route('admin.createCourse') }}">
                    <svg class="mr-2" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    Create New Course
                </a>
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
