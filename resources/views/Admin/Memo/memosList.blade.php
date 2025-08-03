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
                    <th class="px-2 py-2 w-[15%] rounded-r-lg">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($memos as $memo)
                    @php
                        $files = json_decode($memo->file_name, true);
                        $files = is_array($files) ? $files : [$memo->file_name];

                        $borderHex = match($memo->color) {
                            'green' => '#22c55e',   // green
                            'yellow' => '#facc15',  // yellow
                            'red' => '#ef4444',     // red
                            default => '#d1d5db',   // gray
                        };
                    @endphp

                    <tr>
                        <td colspan="4" class="p-0">
                            <div onclick="handleRowClick(event, '{{ route('admin.showMemo', $memo->id) }}')"
                                class="grid grid-cols-4 items-center bg-white rounded shadow-sm cursor-pointer transition px-2 py-2"
                                style="border: 2px solid {{ $borderHex }}; transition: background-color 0.2s ease;"
                                onmouseover="this.style.backgroundColor='#e6f0ff';"
                                onmouseout="this.style.backgroundColor='white';"
                            >
                                <div class="truncate font-medium pr-2">{{ $memo->title }}</div>
                                <div class="truncate px-2">{{ Str::limit($memo->description, 80) }}</div>
                                <div class="text-sm text-gray-600 pr-2">
                                    {{ \Carbon\Carbon::parse($memo->date)->format('F d, Y') }}
                                </div>
                                <div class="flex justify-end gap-2 stop-row-click">
                                    {{-- Edit --}}
                                    <button onclick="openEditMemoModal({{ $memo->id }}, '{{ $memo->title }}', '{{ $memo->description }}')"
                                        title="Edit"
                                        class="border-[2px] border-[#28a745] rounded-full px-3 py-2 inline-flex items-center justify-center transition"
                                        style="color: #28a745;"
                                        onmouseover="this.style.backgroundColor='#d4edda';"
                                        onmouseout="this.style.backgroundColor='transparent';"
                                    >
                                        <iconify-icon icon="mdi:pencil" width="18" height="18"></iconify-icon>
                                    </button>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.memo.destroy', $memo->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete"
                                            class="border-[2px] border-[#dc3545] rounded-full px-3 py-2 inline-flex items-center justify-center transition"
                                            style="color: #dc3545;"
                                            onmouseover="this.style.backgroundColor='#f8d7da';"
                                            onmouseout="this.style.backgroundColor='transparent';"
                                        >
                                            <iconify-icon icon="mdi:trash-can" width="18" height="18"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
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
            @php
                $files = json_decode($memo->file_name, true);
                $files = is_array($files) ? $files : [$memo->file_name];

                // Use HEX values for border color based on importance
                $borderHex = match($memo->color) {
                    'green' => '#22c55e',   // green-500
                    'yellow' => '#facc15',  // yellow-400
                    'red' => '#ef4444',     // red-500
                    default => '#d1d5db',   // gray-300
                };
            @endphp

            <div onclick="window.location.href='{{ route('admin.showMemo', $memo->id) }}'"
                class="p-4 rounded-lg shadow bg-white cursor-pointer hover:bg-gray-100 transition relative group overflow-hidden"
                style="border: 2px solid {{ $borderHex }};"
            >

                {{-- Title --}}
                <h2 class="text-lg font-semibold mb-2 text-gray-800 truncate" title="{{ $memo->title }}">
                    {{ $memo->title }}
                </h2>

                {{-- Description --}}
                <p class="text-gray-600 mb-2 break-words line-clamp-3">
                    {{ $memo->description }}
                </p>

                {{-- Date --}}
                <div class="text-sm text-gray-500 mb-3">
                    {{ \Carbon\Carbon::parse($memo->date)->format('F d, Y') }}
                </div>

                {{-- File Buttons --}}
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

                        <a href="{{ route('admin.downloadMemo', ['id' => $memo->id, 'filename' => $file]) }}"
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
<div id="memoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-[#00000080] overflow-y-auto px-4 py-4">
    <div class="relative bg-white dark:bg-[#1F2937] w-full max-w-lg rounded-lg shadow-lg mt-6 mb-6">

        <!-- Close Button -->
        <button onclick="closeMemoModal()"
            class="absolute top-3 right-3 text-[#9CA3AF] hover:text-[#4B5563] text-2xl font-bold z-10"
            aria-label="Close Modal">&times;</button>

        <!-- Modal Content -->
        <div class="p-4">
            <h2 class="text-lg font-bold mb-3 text-[#1F2937] dark:text-white">Create New Memo</h2>

            <form id="createMemoForm" action="{{ route('admin.memo.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] text-sm font-medium">Title</label>
                    <input type="text" name="title" required
                        class="w-full px-3 py-1.5 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white text-sm">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] text-sm font-medium">Description</label>
                    <textarea name="description" rows="2" required
                        class="w-full px-3 py-1.5 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white text-sm"></textarea>
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] text-sm font-medium">Date</label>
                    <input type="date" name="date" required
                        class="w-full px-3 py-1.5 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white text-sm">
                </div>

                <!-- File Upload -->
                <div class="mb-3">
                    <label class="block text-[#374151] dark:text-[#D1D5DB] text-sm font-medium">Upload Files (PDF only)</label>
                    <input type="file" name="files[]" accept="application/pdf" multiple
                        class="w-full px-3 py-1.5 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white text-sm">
                </div>

                <!-- From -->
                <div class="mb-3">
                    <label for="from" class="block text-[#374151] dark:text-[#D1D5DB] text-sm font-medium">From</label>
                    <select name="from" id="from"
                        class="select2 px-1 py-1 w-full border rounded border-[#a3a3a3] bg-white dark:bg-[#374151] dark:text-white text-sm">
                        <option></option>
                        @foreach($users as $user)
                            <option value="{{ $user->email }}">
                                {{ $user->lastname }} {{ $user->firstname }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-[#6B7280] mt-1">You can select or type a new uploader email.</p>
                </div>

                <!-- Emails -->
                <div class="mb-3">
                    <label for="emails" class="block text-[#374151] dark:text-[#D1D5DB] text-sm font-medium">Recipient Emails</label>
                    <select name="emails[]" id="emails" multiple
                        class="select2 px-1 py-1 w-full border rounded border-[#a3a3a3] bg-white dark:bg-[#374151] dark:text-white text-sm" size="6">
                        @foreach($users as $user)
                            <option value="{{ $user->email }}">
                                {{ $user->lastname }} {{ $user->firstname }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-[#6B7280] mt-1">You can select or type new email addresses.</p>
                </div>

                <!-- Importance Level + Submit -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-3">
                    <!-- Importance Dropdown -->
                    <div class="w-full md:w-1/2">
                        <label for="color" class="block text-[#374151] dark:text-[#D1D5DB] text-sm font-medium mb-1">Importance Level</label>
                        <select name="color" id="color" required
                            class="w-full px-3 py-1.5 border rounded-lg border-[#D1D5DB] bg-white dark:bg-[#374151] dark:text-white text-sm">
                            <option value="green">Normal (Green)</option>
                            <option value="yellow">Important (Yellow)</option>
                            <option value="red">Must Read (Red)</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="w-full md:w-auto text-right">
                        <button type="submit"
                            class="w-full md:w-auto px-4 py-1.5 rounded text-white bg-[#000000] hover:bg-[#1F2937] transition duration-200 mt-2 md:mt-6 text-sm">
                            Upload Memo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Memo Modal -->
<div id="editMemoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-[#00000080] overflow-y-auto px-4 py-4">
    <div class="relative bg-white dark:bg-[#1F2937] w-full max-w-lg rounded-lg shadow-lg mt-6 mb-6">

        <!-- Close Button -->
        <button onclick="document.getElementById('editMemoModal').classList.add('hidden')"
            class="absolute top-3 right-3 text-[#9CA3AF] hover:text-[#4B5563] text-2xl font-bold z-10"
            aria-label="Close Modal">&times;</button>

        <!-- Modal Content -->
        <div class="p-4">
            <h2 class="text-lg font-bold mb-3 text-[#1F2937] dark:text-white">Edit Memo</h2>

            <form id="editMemoForm" method="POST"
                action="{{ route('admin.memo.update', ['id' => '__ID__']) }}"
                data-action-template="{{ route('admin.memo.update', ['id' => '__ID__']) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-3">
                    <label class="block text-sm text-[#374151] dark:text-[#D1D5DB] font-medium">Title</label>
                    <input type="text" name="title" id="editMemoTitle" required
                        class="w-full px-3 py-1.5 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white text-sm">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="block text-sm text-[#374151] dark:text-[#D1D5DB] font-medium">Description</label>
                    <textarea name="description" id="editMemoDescription" rows="2" required
                        class="w-full px-3 py-1.5 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white text-sm"></textarea>
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label class="block text-sm text-[#374151] dark:text-[#D1D5DB] font-medium">Date</label>
                    <input type="date" name="date" id="editMemoDate" required
                        class="w-full px-3 py-1.5 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white text-sm">
                </div>

                <!-- File Upload -->
                <div class="mb-3">
                    <label class="block text-sm text-[#374151] dark:text-[#D1D5DB] font-medium">Upload New Files (PDF only)</label>
                    <input type="file" name="files[]" accept="application/pdf" multiple
                        class="w-full px-3 py-1.5 border border-[#D1D5DB] rounded-lg bg-white dark:bg-[#374151] dark:text-white text-sm">
                </div>

                <!-- From -->
                <div class="mb-3">
                    <label for="from" class="block text-sm text-[#374151] dark:text-[#D1D5DB] font-medium">From</label>
                    <select name="from" id="from"
                        class="select2 px-1 py-1 w-full border rounded border-[#a3a3a3] bg-white dark:bg-[#374151] dark:text-white text-sm">
                        <option></option>
                        @foreach($users as $user)
                            <option value="{{ $user->email }}">
                                {{ $user->lastname }} {{ $user->firstname }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-[#6B7280] mt-1">You can select or type a new uploader email.</p>
                </div>

                <!-- Emails -->
                <div class="mb-3">
                    <label for="editEmails" class="block text-sm text-[#374151] dark:text-[#D1D5DB] font-medium">Recipient Emails</label>
                    <select name="emails[]" id="editEmails" multiple
                        class="select2 px-1 py-1 w-full border rounded border-[#a3a3a3] bg-white dark:bg-[#374151] dark:text-white text-sm" size="6">
                        @foreach($users as $user)
                            <option value="{{ $user->email }}">
                                {{ $user->lastname }} {{ $user->firstname }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-[#6B7280] mt-1">You can select or type new email addresses.</p>
                </div>

                <!-- Importance Level + Submit -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-3">
                    <!-- Importance Dropdown -->
                    <div class="w-full md:w-1/2">
                        <label for="editColor" class="block text-sm text-[#374151] dark:text-[#D1D5DB] font-medium mb-1">Importance Level</label>
                        <select name="color" id="editColor" required
                            class="w-full px-3 py-1.5 border rounded-lg border-[#D1D5DB] bg-white dark:bg-[#374151] dark:text-white text-sm">
                            <option value="green">Normal (Green)</option>
                            <option value="yellow">Important (Yellow)</option>
                            <option value="red">Must Read (Red)</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="w-full md:w-auto text-right">
                        <button type="submit"
                            class="w-full md:w-auto px-4 py-1.5 rounded text-white bg-[#FACC15] hover:bg-[#EAB308] transition duration-200 mt-2 md:mt-6 text-sm">
                            Update Memo
                        </button>
                    </div>
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

        $('#from, #editFrom').select2({
            tags: true, // ✅ allow typing new email
            tokenSeparators: [',', ' '],
            placeholder: "Select or type uploader email",
            width: '100%' // ✅ match width
        });
    });

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

    function openEditMemoModal(id, title, description, date, emails = [], from = '') {
        const modal = document.getElementById('editMemoModal');
        const titleInput = document.getElementById('editMemoTitle');
        const descInput = document.getElementById('editMemoDescription');
        const dateInput = document.getElementById('editMemoDate');
        const emailSelect = $('#editEmails');
        const fromSelect = $('#editFrom'); // 🆕 Select2 for 'From'
        const form = document.getElementById('editMemoForm');

        if (!modal || !titleInput || !descInput || !form || !dateInput || !fromSelect.length) {
            console.error('One or more elements not found');
            return;
        }

        // Populate fields
        titleInput.value = title;
        descInput.value = description;
        dateInput.value = date;
        emailSelect.val(emails).trigger('change');

        // 🆕 Set the "From" dropdown
        fromSelect.val(from).trigger('change');

        // Set form action
        const actionTemplate = form.getAttribute('data-action-template');
        form.action = actionTemplate.replace('__ID__', id);

        modal.classList.remove('hidden');
    }
</script>
@endsection