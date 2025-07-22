@extends('layouts.adminSidebar') 
@section('content')
@include('layouts.modal') 

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

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="mt-16 p-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Memorandum</h1>
    </div>

    {{-- Search & Controls --}}
    <form method="GET" action="{{ route('admin.memo') }}" class="mb-4 flex justify-between items-center">
        <div class="relative w-64">
            <input type="text" name="search" placeholder="Search.."
                value="{{ request('search') }}"
                class="pl-10 pr-4 py-2 w-full border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
            </svg>
        </div>

        <div class="flex gap-2">
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

            {{-- Create Memo Button --}}
            <button type="button" onclick="openMemoModal()"
                class="whitespace-nowrap rounded-xl hover:scale-105 transition ease-in-out px-6 py-2 text-black font-semibold flex items-center gap-2"
                style="background: #d7ecf9;"
                onmouseover="this.style.background='#c3dff3';"
                onmouseout="this.style.background='#d7ecf9';">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
                </svg>
                Create Memo
            </button>
        </div>
    </form>

    {{-- Table View --}}
    <div id="tableView" class="overflow-x-auto">
        <table class="w-full table-fixed border-separate border-spacing-y-2">
            <thead>
                <tr class="bg-[#007BFF] text-white text-sm">
                    <th class="px-2 py-2 w-[15%] rounded-l-lg">Title</th>
                    <th class="px-2 py-2 w-[55%]">Description</th>
                    <th class="px-2 py-2 w-[15%]">Date</th>
                    <th class="px-2 py-2 w-[10%] rounded-r-lg">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($memos as $memo)
                <tr onclick="handleRowClick(event, '{{ route('admin.showMemo', $memo->id) }}')"
                    class="bg-white rounded shadow-sm cursor-pointer transition"
                    style="transition: background-color 0.2s ease;"
                    onmouseover="this.style.backgroundColor='#e6f0ff';"
                    onmouseout="this.style.backgroundColor='white';"
                >
                    <td class="px-2 py-2 w-[15%]">{{ $memo->title }}</td>
                    <td class="px-2 py-2 w-[55%]">{{ Str::limit($memo->description, 80) }}</td>
                    <td class="px-2 py-2 w-[15%]">{{ \Carbon\Carbon::parse($memo->date)->format('F d, Y') }}</td>
                    <td class="px-2 py-2 w-[10%]">
                        <div class="flex flex-wrap gap-2">
                            @php
                                $files = json_decode($memo->file_name, true);
                                $files = is_array($files) ? $files : [$memo->file_name];
                            @endphp

                            {{-- Edit --}}
                            <button onclick="openEditMemoModal({{ $memo->id }}, '{{ $memo->title }}', '{{ $memo->description }}')"
                                title="Edit"
                                class="stop-row-click border-[2px] border-[#28a745] rounded-full px-3 py-2 inline-flex items-center justify-center transition"
                                style="color: #28a745;"
                                onmouseover="this.style.backgroundColor='#d4edda';"
                                onmouseout="this.style.backgroundColor='transparent';"
                            >
                                <iconify-icon icon="mdi:pencil" width="18" height="18" style="color: #28a745;"></iconify-icon>
                            </button>

                            {{-- Delete --}}
                            <form action="{{ route('dean.memo.destroy', $memo->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')" class="inline stop-row-click">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete"
                                    class="border-[2px] border-[#dc3545] rounded-full px-3 py-2 inline-flex items-center justify-center transition"
                                    style="color: #dc3545;"
                                    onmouseover="this.style.backgroundColor='#f8d7da';"
                                    onmouseout="this.style.backgroundColor='transparent';"
                                >
                                    <iconify-icon icon="mdi:trash-can" width="18" height="18" style="color: #dc3545;"></iconify-icon>
                                </button>
                            </form>
                        </div>
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

    {{-- Tile View --}}
    <div id="tileView" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($memos as $memo)
        <div onclick="window.location.href='{{ route('admin.showMemo', $memo->id) }}'"
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

                    <a href="{{ route('dean.memo.download', ['id' => $memo->id, 'filename' => $file]) }}"
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


<!-- Create Memo Modal -->
<div id="memoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-[#00000080] overflow-y-auto px-4 py-6">
    <div class="relative bg-white dark:bg-[#1F2937] w-full max-w-lg rounded-lg shadow-lg mt-10 mb-10">

        <!-- Close Button -->
        <button onclick="closeMemoModal()"
            class="absolute top-3 right-3 text-[#9CA3AF] hover:text-[#4B5563] text-2xl font-bold z-10"
            aria-label="Close Modal">&times;</button>

        <!-- Modal Content -->
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4 text-[#1F2937] dark:text-white">Create New Memo</h2>

            <form id="createMemoForm" action="{{ route('dean.memo.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Title</label>
                    <input type="text" name="title" required
                        class="w-full px-3 py-2 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Description</label>
                    <textarea name="description" rows="3" required
                        class="w-full px-3 py-2 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white"></textarea>
                </div>

                <!-- Date -->
                <div class="mb-4">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Date</label>
                    <input type="date" name="date" required
                        class="w-full px-3 py-2 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white">
                </div>

                <!-- File Upload -->
                <div class="mb-4">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Upload Files (PDF only)</label>
                    <input type="file" name="files[]" accept="application/pdf" multiple
                        class="w-full px-3 py-2 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white">
                </div>

                <!-- Emails -->
                <div class="mb-4">
                    <label for="emails" class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Recipient Emails</label>
                    <select name="emails[]" id="emails" multiple
                        class="form-control select2 px-1 py-[6px] w-full border rounded border-[#a3a3a3] bg-white dark:bg-[#374151] dark:text-white" size="10">
                        @foreach($users as $user)
                            <option value="{{ $user->email }}">
                                {{ $user->lastname }} {{ $user->firstname }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-[#6B7280] mt-1">You can select or type new email addresses.</p>
                </div>

                <!-- Submit -->
                <div class="text-right">
                    <button type="submit"
                        class="px-4 py-2 rounded text-white bg-[#000000] hover:bg-[#1F2937] transition duration-200">
                        Upload Memo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Memo Modal -->
<div id="editMemoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-[#00000080] overflow-y-auto px-4 py-6">
    <div class="relative bg-white dark:bg-[#1F2937] w-full max-w-lg rounded-lg shadow-lg mt-10 mb-10">

        <!-- Close Button -->
        <button onclick="document.getElementById('editMemoModal').classList.add('hidden')"
            class="absolute top-3 right-3 text-[#9CA3AF] hover:text-[#4B5563] text-2xl font-bold z-10"
            aria-label="Close Modal">&times;</button>

        <!-- Modal Content -->
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4 text-[#1F2937] dark:text-[#FFFFFF]">Edit Memo</h2>

            <form id="editMemoForm" method="POST"
                action="{{ route('dean.memo.update', ['id' => '__ID__']) }}"
                data-action-template="{{ route('dean.memo.update', ['id' => '__ID__']) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Title</label>
                    <input type="text" name="title" id="editMemoTitle" required
                        class="w-full px-3 py-2 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Description</label>
                    <textarea name="description" id="editMemoDescription" rows="3" required
                        class="w-full px-3 py-2 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white"></textarea>
                </div>

                <!-- Date -->
                <div class="mb-4">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Date</label>
                    <input type="date" name="date" id="editMemoDate" required
                        class="w-full px-3 py-2 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white">
                </div>

                <!-- File Upload -->
                <div class="mb-4">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Upload New Files (PDF only)</label>
                    <input type="file" name="files[]" accept="application/pdf" multiple
                        class="w-full px-3 py-2 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white">
                </div>

                <!-- Emails -->
                <div class="mb-4">
                    <label for="editEmails" class="block text-[#374151] dark:text-[#D1D5DB] font-medium">Recipient Emails</label>
                    <select name="emails[]" id="editEmails" multiple
                        class="form-control select2 px-1 py-[6px] w-full border rounded border-[#a3a3a3] bg-white dark:bg-[#374151] dark:text-white" size="10">
                        @foreach($users as $user)
                            <option value="{{ $user->email }}">
                                {{ $user->lastname }} {{ $user->firstname }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-[#6B7280] mt-1">You can select or type new email addresses.</p>
                </div>

                <!-- Submit -->
                <div class="text-right">
                    <button type="submit"
                        class="px-4 py-2 rounded text-white bg-[#FACC15] hover:bg-[#EAB308] transition duration-200">
                        Update Memo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

<!-- Existing modal & edit modal scripts (unchanged) -->
<script>
    $(document).ready(function () {
        $('#emails, #editEmails').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            placeholder: "Select or type email(s)",
            width: '100%'
        });
    });

    function openMemoModal() {
        const modal = document.getElementById('memoModal');
        const form = modal.querySelector('form');
        form.reset();
        $('#emails').val(null).trigger('change');
        modal.classList.remove('hidden');
    }

    function closeMemoModal() {
        const modal = document.getElementById('memoModal');
        const form = modal.querySelector('form');
        form.reset();
        $('#emails').val(null).trigger('change');
        modal.classList.add('hidden');
    }

    function openEditMemoModal(id, title, description, date, emails = []) {
        const modal = document.getElementById('editMemoModal');
        const titleInput = document.getElementById('editMemoTitle');
        const descInput = document.getElementById('editMemoDescription');
        const dateInput = document.getElementById('editMemoDate');
        const emailSelect = $('#editEmails');
        const form = document.getElementById('editMemoForm');

        if (!modal || !titleInput || !descInput || !form || !dateInput) {
            console.error('One or more elements not found');
            return;
        }

        // Populate fields
        titleInput.value = title;
        descInput.value = description;
        dateInput.value = date;

        // Set selected emails (must be pre-loaded or dynamically added)
        emailSelect.val(emails).trigger('change');

        // Set form action
        const actionTemplate = form.getAttribute('data-action-template');
        form.action = actionTemplate.replace('__ID__', id);

        modal.classList.remove('hidden');
    }
</script>
@endsection