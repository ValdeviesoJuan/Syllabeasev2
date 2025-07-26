@extends('layouts.adminSidebar')

@section('content')
<div class="mt-16 max-w-4xl mx-auto bg-white p-6 shadow rounded-lg dark:bg-gray-800">
    <style>
        .bg svg {
            transform: scaleY(-1);
            min-width: 1880px;
        }

        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
    </style>
    
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white break-words" title="{{ $memo->title }}">
            {{ $memo->title }}
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-300">
            {{ \Carbon\Carbon::parse($memo->date)->format('F d, Y') }}
        </p>
    </div>

    <hr class="mb-6">

    {{-- Description --}}
    <div class="mb-6">
        <p class="text-gray-700 dark:text-gray-200 whitespace-pre-line break-words">
            {{ $memo->description }}
        </p>
    </div>

    {{-- File Download(s) --}}
    @php
        $files = json_decode($memo->file_name, true);
    @endphp

    @if (is_array($files))
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Attachments</h2>
            <div class="space-y-3">
                @foreach ($files as $file)
                    @include('admin.Memo.partials.attachment', ['file' => $file])
                @endforeach
            </div>
        </div>
    @elseif (!empty($memo->file_name)) {{-- fallback for older data --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Attachment</h2>
            <div class="space-y-3">
                @include('admin.Memo.partials.attachment', ['file' => $memo->file_name])
            </div>
        </div>
    @endif

    {{-- Back Button --}}
    <div class="flex justify-end">
        <a href="{{ route('admin.memo') }}"
           class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
            Back to Memos
        </a>
    </div>
</div>
@endsection
