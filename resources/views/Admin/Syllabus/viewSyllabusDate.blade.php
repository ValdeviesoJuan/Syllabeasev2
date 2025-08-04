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
        <h1 class="text-xl font-bold">Override Dates for: </h1>
        <h1 class="text-2xl font-bold mb-6 text-center underline">{{ $syllabusDetails->course_title. ' - ' . $syllabusDetails->course_code . ', ' . $syllabusDetails->course_semester . ' ' . $syllabusDetails->bg_school_year }}</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Repeat this block for each syllabus -->
            @foreach ($syllabusVersions as $syllabus)
            <form action="{{ route('admin.overrideSyllabusDate', $syllabus->syll_id) }}" class="p-4 rounded shadow-2xl bg-[#F9FAFB]" method="POST">
                @csrf
                @method('PUT')
                <div class="flex items-center gap-2 mb-4 justify-between">
                    @php
                        $status = $syllabus->status;
                        $statusStyles = [
                            'Draft' => 'background-color: #D1D5DB; color: #4B5563; border-color: #9CA3AF;',
                            'Pending Chair Review' => 'background-color: #FEF3C7; color: #D97706; border-color: #FCD34D;',
                            'Returned by Chair' => 'background-color: #FECACA; color: #E11D48; border-color: #F87171;',
                            'Requires Revision (Chair)' => 'background-color: #FEE2E2; color: #EF4444; border-color: #FCA5A5;',
                            'Revised for Chair' => 'background-color: #DBEAFE; color: #3B82F6; border-color: #93C5FD;',
                            'Approved by Chair' => 'background-color: #D1FAE5; color: #059669; border-color: #6EE7B7;',
                            'Returned by Dean' => 'background-color: #FDA4AF; color: #BE123C; border-color: #FB7185;',
                            'Requires Revision (Dean)' => 'background-color: #FCE7F3; color: #EC4899; border-color: #F9A8D4;',
                            'Revised for Dean' => 'background-color: #BFDBFE; color: #2563EB; border-color: #93C5FD;',
                            'Approved by Dean' => 'background-color: #A7F3D0; color: #047857; border-color: #6EE7B7;',
                        ];
                        $style = $statusStyles[$status] ?? 'background-color: #F3F4F6; color: #6B7280; border-color: #D1D5DB;';
                    @endphp

                    <h2 class="text-base font-bold">SYLLABUS VERSION {{ $syllabus->version }}</h2>
                    <h2 class="text-sm px-2 py-1 border-2 rounded-md" style="{{ $style }}">
                        {{ $syllabus->status }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block mb-1 {{ is_null($syllabus->chair_submitted_at) ? 'text-gray4' : 'text-gray7' }}">
                            {{ is_null($syllabus->chair_submitted_at) ? 'Chair Submitted At: Null' : 'Chair Submitted At:' }}
                        </label>
                        <input type="datetime-local" name="chair_submitted_at"
                            value="{{ $syllabus->chair_submitted_at }}"
                            data-original="{{ $syllabus->chair_submitted_at }}"
                            {{ is_null($syllabus->chair_submitted_at) ? 'disabled' : '' }}
                            class="override-input w-full border border-gray1 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue disabled:bg-gray1 disabled:text-gray4 disabled:border-gray4 disabled:cursor-not-allowed" />
                    </div>
                    <div>
                        <label class="block mb-1 {{ is_null($syllabus->chair_rejected_at) ? 'text-gray4' : 'text-gray7' }}">
                            {{ is_null($syllabus->chair_rejected_at) ? 'Chair Rejected At: Null' : 'Chair Rejected At:' }}
                        </label>
                        <input type="datetime-local" name="chair_rejected_at"
                            value="{{ $syllabus->chair_rejected_at }}"
                            data-original="{{ $syllabus->chair_rejected_at }}"
                            {{ is_null($syllabus->chair_rejected_at) ? 'disabled' : '' }}
                            class="override-input w-full border border-gray1 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue disabled:bg-gray1 disabled:text-gray4 disabled:border-gray4 disabled:cursor-not-allowed" />
                    </div>
                    <div>
                        <label class="block mb-1 {{ is_null($syllabus->dean_submitted_at) ? 'text-gray4' : 'text-gray7' }}">
                            {{ is_null($syllabus->dean_submitted_at) ? 'Dean Submitted At: Null' : 'Dean Submitted At:' }}
                        </label>
                        <input type="datetime-local" name="dean_submitted_at"
                            value="{{ $syllabus->dean_submitted_at }}"
                            data-original="{{ $syllabus->dean_submitted_at }}"
                            {{ is_null($syllabus->dean_submitted_at) ? 'disabled' : '' }}
                            class="override-input w-full border border-gray1 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue disabled:bg-gray1 disabled:text-gray4 disabled:border-gray4 disabled:cursor-not-allowed" />
                    </div>
                    <div>
                        <label class="block mb-1 {{ is_null($syllabus->dean_rejected_at) ? 'text-gray4' : 'text-gray7' }}">
                            {{ is_null($syllabus->dean_rejected_at) ? 'Dean Rejected At: Null' : 'Dean Rejected At:' }}
                        </label>
                        <input type="datetime-local" name="dean_rejected_at"
                            value="{{ $syllabus->dean_rejected_at }}"
                            data-original="{{ $syllabus->dean_rejected_at }}"
                            {{ is_null($syllabus->dean_rejected_at) ? 'disabled' : '' }}
                            class="override-input w-full border border-gray1 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue disabled:bg-gray1 disabled:text-gray4 disabled:border-gray4 disabled:cursor-not-allowed" />
                    </div>
                    <div>
                        <label class="block mb-1 {{ is_null($syllabus->dean_approved_at) ? 'text-gray4' : 'text-gray7' }}">
                            {{ is_null($syllabus->dean_approved_at) ? 'Dean Approved At: Null' : 'Dean Approved At:' }}
                        </label>
                        <input type="datetime-local" name="dean_approved_at"
                            value="{{ $syllabus->dean_approved_at }}"
                            data-original="{{ $syllabus->dean_approved_at }}"
                            {{ is_null($syllabus->dean_approved_at) ? 'disabled' : '' }}
                            class="override-input w-full border border-gray1 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue disabled:bg-gray1 disabled:text-gray4 disabled:border-gray4 disabled:text-gray4disabled:cursor-not-allowed" />
                    </div>
                </div>

                <div class="flex justify-between gap-3 mt-4">
                    <button type="button" data-action="restore" class="bg-gray3 text-gray8 font-semibold px-4 py-2 rounded hover:bg-gray4 transition">
                        Restore Default Values
                    </button>
                    <button type="submit" class="bg-blue text-white font-semibold px-4 py-2 rounded hover:bg-blue2 transition">
                        Update Dates
                    </button>
                </div>
            </form>
            @endforeach
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('button[data-action="restore"]').forEach(button => {
            button.addEventListener('click', function () {
                const form = button.closest('form');
                form.querySelectorAll('.override-input').forEach(input => {
                    if (!input.disabled) {
                        input.value = input.dataset.original;
                    }
                });
            });
        });
    });
</script>
</body>

</html>
@endsection
