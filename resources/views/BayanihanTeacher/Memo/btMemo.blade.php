@extends('layouts.btSidebar')

@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="mt-16 p-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Memorandum Issued by the Dean</h1>
    </div>

    {{-- Search Bar --}}
    <form method="GET" action="{{ route('bayanihanteacher.memo') }}" class="mb-4 flex justify-between items-center">
        <div class="relative w-64">
            <input type="text" name="search" placeholder="Search..."
                value="{{ request('search') }}"
                class="pl-10 pr-4 py-2 w-full border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
            </svg>
        </div>
    </form>

    {{-- Memo Table --}}
    <div class="overflow-x-auto">
        <table class="w-full table-fixed border-separate border-spacing-y-2">
            <thead>
                <tr class="bg-blue text-white text-sm">
                    <th class="p-3 rounded-l-lg w-[25%]">Title</th>
                    <th class="p-3 w-[45%]">Description</th>
                    <th class="p-3 w-[20%]">Date</th>
                    <th class="p-3 rounded-r-lg w-[5%]">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($memos as $memo)
                <tr class="bg-white rounded shadow-sm">
                    <td class="p-3">{{ $memo->title }}</td>
                    <td class="p-3">{{ Str::limit($memo->description, 80) }}</td>
                    <td class="p-3">
                        {{ $memo->date ? \Carbon\Carbon::parse($memo->date)->format('F d, Y') : 'No date' }}
                    </td>
                    <td class="p-3">
                        {{-- Download --}}
                        <a href="{{ route('dean.memo.download', $memo->id) }}" title="Download"
                           class="border-[2px] border-black rounded-full px-3 py-2 inline-flex items-center justify-center">
                            <iconify-icon icon="mdi:download" width="18" height="18" class="text-black"></iconify-icon>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">No memos available at the moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
@endsection
