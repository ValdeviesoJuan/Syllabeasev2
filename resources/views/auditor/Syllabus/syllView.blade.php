@extends('layouts.AUsyllabus')
@section('content')
@include('layouts.modal')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase - Auditor View</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <style>
        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }

        .notice {
            @apply flex flex-col border-2 bg-white bg-opacity-75 w-[500px] rounded-lg mt-2 mx-auto;
        }
    </style>
</head>

<body class="font-thin">
    <div class="notice border-blue3">
        <div class="flex items-center justify-center p-2">
            <div class="mx-1">
                <svg fill="#2468d2" width="40px" height="40px" viewBox="0 0 32 32">
                    <path d="M15.5 3c-7.456 0-13.5 6.044-13.5 13.5s6.044 13.5 13.5 13.5 13.5-6.044 13.5-13.5-6.044-13.5-13.5-13.5zM15.5 27c-5.799 0-10.5-4.701-10.5-10.5s4.701-10.5 10.5-10.5 10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zM15.5 10c-0.828 0-1.5 0.671-1.5 1.5v5.062c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-5.062c0-0.829-0.672-1.5-1.5-1.5zM15.5 20c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5 1.5-0.672 1.5-1.5-0.672-1.5-1.5-1.5z"></path>
                </svg>
            </div>
            <div class="mt-1">
                <span class="font-semibold">Notice:</span> This syllabus is in read-only mode. You may view all details but editing is disabled.
            </div>
        </div>
    </div>

    <div class="container mx-auto mt-5 bg-white bg-opacity-90 p-5 rounded shadow">
        <div class="text-center mb-4">
         <h2 class="text-2xl font-bold">
    {{ $syll->course->course_title ?? 'N/A' }} ({{ $syll->course->course_code ?? 'N/A' }})

</h2>

            <p>Semester: {{ $syll->course_semester }} | SY {{ $syll->bg_school_year }}</p>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-5">
            <div>
                <h3 class="font-bold">College & Department</h3>
                <p>{{ $syll->college_description }}<br>{{ $syll->department_name }}</p>
            </div>
            <div>
                <h3 class="font-bold">Instructor(s)</h3>
                @foreach ($instructors[$syll->syll_id] ?? [] as $instructor)
                    <p>{{ $instructor->firstname }} {{ $instructor->lastname }} - {{ $instructor->email }}</p>
                @endforeach
            </div>
        </div>

        <h3 class="text-xl font-semibold mb-2">Course Description</h3>
        <p class="mb-5">{{ $syll->syll_course_description }}</p>

        <h3 class="text-xl font-semibold mb-2">Program Educational Objectives</h3>
        <ul class="list-disc list-inside mb-5">
            @foreach($poes as $poe)
                <li><strong>{{ $poe->poe_code }}:</strong> {{ $poe->poe_description }}</li>
            @endforeach
        </ul>

        <h3 class="text-xl font-semibold mb-2">Program Outcomes</h3>
        <ul class="list-disc list-inside mb-5">
            @foreach($programOutcomes as $po)
                <li><strong>{{ $po->po_letter }}:</strong> {{ $po->po_description }}</li>
            @endforeach
        </ul>

        <h3 class="text-xl font-semibold mb-2">Course Outcomes</h3>
        <table class="w-full table-auto border border-gray-400 mb-5">
            <thead>
                <tr class="bg-blue-100">
                    <th class="border px-2 py-1">CO</th>
                    <th class="border px-2 py-1">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courseOutcomes as $co)
                    <tr>
                        <td class="border px-2 py-1">{{ $co->syll_co_code }}</td>
                        <td class="border px-2 py-1">{{ $co->syll_co_description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="text-xl font-semibold mb-2">Course Outline</h3>
        <table class="w-full table-auto border border-gray-400 text-sm mb-6">
            <thead class="bg-blue-100">
                <tr>
                    <th class="border px-2 py-1">Time</th>
                    <th class="border px-2 py-1">ILO</th>
                    <th class="border px-2 py-1">Topics</th>
                    <th class="border px-2 py-1">Readings</th>
                    <th class="border px-2 py-1">Activities</th>
                    <th class="border px-2 py-1">Assessments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courseOutlines as $cot)
                    <tr>
                        <td class="border px-2 py-1">{!! nl2br(e($cot->syll_allotted_time)) !!}</td>
                        <td class="border px-2 py-1">{!! nl2br(e($cot->syll_intended_learning)) !!}</td>
                        <td class="border px-2 py-1">{!! nl2br(e($cot->syll_topics)) !!}</td>
                        <td class="border px-2 py-1">{!! nl2br(e($cot->syll_suggested_readings)) !!}</td>
                        <td class="border px-2 py-1">{!! nl2br(e($cot->syll_learning_act)) !!}</td>
                        <td class="border px-2 py-1">{!! nl2br(e($cot->syll_asses_tools)) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="text-xl font-semibold mb-2">Course Requirements</h3>
        <div class="mb-10">
            {!! $syll->syll_course_requirements !!}
        </div>
    </div>
</body>

</html>
@endsection
