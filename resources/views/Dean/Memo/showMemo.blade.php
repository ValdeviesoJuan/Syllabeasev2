@extends('layouts.deanSidebar')

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
        <h1 
            class="text-2xl font-bold break-words" 
            style="
                color: 
                @if($memo->color === 'green') #22c55e;    /* Tailwind green-500 */
                @elseif($memo->color === 'yellow') #eab308;  /* Tailwind yellow-500 */
                @elseif($memo->color === 'red') #dc2626;    /* Tailwind red-600 */
                @else #1f2937;    /* Tailwind gray-800 fallback */
                @endif
            "
            title="{{ $memo->title }}"
        >
            {{ $memo->title }}
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-300">
            {{ \Carbon\Carbon::parse($memo->date)->format('F d, Y') }}
        </p>
        @if($memo->user)
            <p class="text-sm text-gray-500 dark:text-gray-300">
                Uploaded by: <span class="font-medium">{{ $memo->user->firstname }} {{ $memo->user->lastname }}</span>
                ({{ $memo->user->email }})
            </p>
        @endif
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
                    @include('Dean.Memo.partials.attachment', ['file' => $file])
                @endforeach
            </div>
        </div>
    @elseif (!empty($memo->file_name)) {{-- fallback for older data --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Attachment</h2>
            <div class="space-y-3">
                @include('Dean.Memo.partials.attachment', ['file' => $memo->file_name])
            </div>
        </div>
    @endif

    {{-- Back Button --}}
    <div class="flex justify-end">
        <a href="{{ route('dean.memo') }}"
           class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
            Back to Memos
        </a>
    </div>
</div>
@endsection
