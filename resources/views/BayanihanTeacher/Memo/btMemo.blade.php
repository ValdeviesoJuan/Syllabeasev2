@extends('layouts.btSidebar')

@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="mt-16 p-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Memorandum Issued by the Dean</h1>
    </div>

    {{-- Search Bar + View Toggle Buttons --}}
    <form method="GET" action="{{ route('bayanihanteacher.memo') }}" class="mb-4 flex justify-between items-center">
        <div class="relative w-64">
            <input type="text" name="search" placeholder="Search..."
                value="{{ request('search') }}"
                class="pl-10 pr-4 py-2 w-full border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
            </svg>
        </div>

        {{-- View Toggle Buttons --}}
        <div class="flex gap-2">
            <button type="button" id="tableBtn" onclick="setView('table')"
                class="p-2 border border-transparent rounded-xl bg-[#d7ecf9] hover:bg-[#c3dff3] transition duration-200 ease-in-out"
                title="Table View"
                style="color: black; font-weight: 600;">
                <iconify-icon icon="mdi:table" width="22" height="22"></iconify-icon>
            </button>
            <button type="button" id="tilesBtn" onclick="setView('tiles')"
                class="p-2 border border-transparent rounded-xl bg-[#d7ecf9] hover:bg-[#c3dff3] transition duration-200 ease-in-out"
                title="Tile View"
                style="color: black; font-weight: 600;">
                <iconify-icon icon="mdi:view-grid" width="22" height="22"></iconify-icon>
            </button>
        </div>
    </form>

    {{-- Table View --}}
    <div id="tableView" class="overflow-x-auto">
        <table class="w-full table-fixed border-separate border-spacing-y-2">
            <thead>
                <tr class="bg-blue text-white text-sm">
                    <th class="px-2 py-2 w-[15%] rounded-l-lg">Title</th>
                    <th class="px-2 py-2 w-[60%]">Description</th>
                    <th class="px-2 py-2 w-[10%] rounded-r-lg">Date</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($memos as $memo)
                <tr onclick="handleRowClick(event, '{{ route('bayanihanteacher.memo.show', $memo->id) }}')"
                    class="bg-white rounded shadow-sm cursor-pointer hover:bg-gray-100 transition">
                    <td class="px-2 py-2 w-[15%]">{{ $memo->title }}</td>
                    <td class="px-2 py-2 w-[60%]">{{ Str::limit($memo->description, 80) }}</td>
                    <td class="px-2 py-2 w-[10%]">{{ \Carbon\Carbon::parse($memo->date)->format('F d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">No memos available at the moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Tile View --}}
    <div id="tileView" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($memos as $memo)
        <div onclick="window.location.href='{{ route('bayanihanteacher.memo.show', $memo->id) }}'"
            class="p-4 border rounded-lg shadow bg-white cursor-pointer hover:bg-gray-100 transition relative group">

            {{-- Title --}}
            <h2 class="text-lg font-semibold mb-2 text-gray-800">{{ $memo->title }}</h2>

            {{-- Description --}}
            <p class="text-gray-600 mb-2">{{ Str::limit($memo->description, 100) }}</p>

            {{-- Date --}}
            <div class="text-sm text-gray-500 mb-3">
                {{ \Carbon\Carbon::parse($memo->date)->format('F d, Y') }}
            </div>

            {{-- File Buttons (Prevent row click) --}}
            @php
                $files = json_decode($memo->file_name, true);
                $files = is_array($files) ? $files : [$memo->file_name];
            @endphp

            <div class="flex flex-wrap gap-2 z-10 relative">
                @foreach ($files as $file)
                    @php
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        $icon = match(strtolower($ext)) {
                            'pdf' => 'mdi:file-pdf-box',
                            'doc', 'docx' => 'mdi:file-word-box',
                            'xls', 'xlsx' => 'mdi:file-excel-box',
                            'jpg', 'jpeg', 'png' => 'mdi:file-image',
                            default => 'mdi:file-document-outline',
                        };

                        $iconColor = match(strtolower($ext)) {
                            'pdf' => '#DC2626',
                            'doc', 'docx' => '#1D4ED8',
                            'xls', 'xlsx' => '#15803D',
                            'jpg', 'jpeg', 'png' => '#CA8A04',
                            default => '#2563EB',
                        };
                    @endphp

                    <a href="{{ route('dean.downloadMemo', ['id' => $memo->id, 'filename' => $file]) }}"
                    onclick="event.stopPropagation()"
                    class="flex items-center gap-2 px-3 py-2 border rounded-lg shadow-md bg-[#E8F1FF] hover:shadow-lg transition"
                    style="border-color: #B3D4FC;"
                    title="Download {{ $file }}">
                        <iconify-icon icon="{{ $icon }}" width="20" height="20" style="color: {{ $iconColor }}"></iconify-icon>
                        <span class="text-sm font-medium text-[#1E3A8A] truncate max-w-[120px]">
                            {{ Str::limit($file, 20) }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
        @empty
        <p class="text-center py-6 text-gray-500 col-span-full">No memos available at the moment.</p>
        @endforelse
    </div>

<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

<script>
    function handleRowClick(event, url) {
        // If the clicked element or its parent has a "stop-row-click" class, don't redirect
        if (event.target.closest('.stop-row-click')) return;
        window.location = url;
    }
</script>

<script>
    function setView(view) {
        const tableView = document.getElementById('tableView');
        const tileView = document.getElementById('tileView');
        const tableBtn = document.getElementById('tableBtn');
        const tilesBtn = document.getElementById('tilesBtn');

        if (view === 'tiles') {
            tableView.classList.add('hidden');
            tileView.classList.remove('hidden');

            tableBtn.classList.remove('bg-[#D1D5DB]');
            tilesBtn.classList.add('bg-[#D1D5DB]');
        } else {
            tileView.classList.add('hidden');
            tableView.classList.remove('hidden');

            tilesBtn.classList.remove('bg-[#D1D5DB]');
            tableBtn.classList.add('bg-[#D1D5DB]');
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        setView('table');
    });
</script>

@endsection
