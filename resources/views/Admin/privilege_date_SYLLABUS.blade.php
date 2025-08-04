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
    <div class="p-4 shadow-lg bg-white border-dashed rounded mt-10">
        <h1 class="text-lg font-bold mb-6">Override Dates for All Syllabi Versions</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Repeat this block for each syllabus -->
            @foreach ($syllabi as $syllabus)
            <form class="p-4 border border-gray-200 rounded-lg shadow-sm bg-gray-50">
                <h2 class="text-base font-semibold mb-4">Syllabus Version: {{ $syllabus->version_name ?? 'Version #' . $syllabus->syllabus_id }}</h2>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Chair Submitted At</label>
                        <input type="datetime-local" name="chair_submitted_at" value="{{ $syllabus->chair_submitted_at }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue" />
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Dean Submitted At</label>
                        <input type="datetime-local" name="dean_submitted_at" value="{{ $syllabus->dean_submitted_at }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue" />
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Chair Rejected At</label>
                        <input type="datetime-local" name="chair_rejected_at" value="{{ $syllabus->chair_rejected_at }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue" />
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Dean Rejected At</label>
                        <input type="datetime-local" name="dean_rejected_at" value="{{ $syllabus->dean_rejected_at }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue" />
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Dean Approved At</label>
                        <input type="datetime-local" name="dean_approved_at" value="{{ $syllabus->dean_approved_at }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue" />
                    </div>
                </div>

                <div class="flex justify-between gap-3 mt-4">
                    <button type="submit" class="bg-blue text-white font-semibold px-4 py-2 rounded hover:bg-blue2 transition">
                        Update Dates
                    </button>
                    <button type="button" class="bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded hover:bg-gray-400 transition">
                        Restore Default
                    </button>
                </div>
            </form>
            @endforeach
        </div>
    </div>

</body>

</html>
@endsection
