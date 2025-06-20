@extends('layouts.deanSidebar')

@section('content')
@include('layouts.modal')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="mt-16 p-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700">

    {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Memorandum</h1>
        </div>

        <form method="GET" action="{{ route('dean.memo') }}" class="mb-4 flex justify-between items-center">
            <div class="relative w-64">
                <input type="text" name="search" placeholder="Search.."
                    value="{{ request('search') }}"
                    class="pl-10 pr-4 py-2 w-full border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                </svg>
            </div>

            <button type="button" onclick="openMemoModal()" class="bg-blue text-white px-4 py-2 rounded">
                Create Memo
            </button>
        </form>

        {{-- Memo Table --}}
        <div class="overflow-x-auto">
            <table class="w-full table-fixed border-separate border-spacing-y-2">
                <thead>
                    <tr class="bg-blue text-white text-sm">
                        <th class="p-3 rounded-l-lg w-[3%]">Title</th>
                        <th class="p-3 w-[8%]">Description</th>
                        <th class="p-3 w-[3%]">Date</th>
                        <th class="p-3 rounded-r-lg w-[2%]">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse($memos as $memo)
                    <tr class="bg-white rounded shadow-sm">
                        <td class="p-3">{{ $memo->title }}</td>
                        <td class="p-3">{{ Str::limit($memo->description, 80) }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($memo->date)->format('F d, Y') }}</td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                {{-- Download --}}
                                <a href="{{ route('dean.memo.download', $memo->id) }}" title="Download"
                                class="border-[2px] border-black rounded-full px-3 py-2 inline-flex items-center justify-center">
                                    <iconify-icon icon="mdi:download" width="18" height="18" class="text-black"></iconify-icon>
                                </a>

                                {{-- Edit --}}
                                <button onclick="openEditMemoModal({{ $memo->id }}, '{{ $memo->title }}', '{{ $memo->description }}')"
                                        title="Edit"
                                        class="border-[2px] border-green rounded-full px-3 py-2 inline-flex items-center justify-center">
                                    <iconify-icon icon="mdi:pencil" width="18" height="18" class="text-green"></iconify-icon>
                                </button>

                                {{-- Delete --}}
                                <form action="{{ route('dean.memo.destroy', $memo->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete"
                                            class="border-[2px] border-red rounded-full px-3 py-2 inline-flex items-center justify-center">
                                        <iconify-icon icon="mdi:trash-can" width="18" height="18" class="text-red"></iconify-icon>
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
        </table>
    </div>
</div>

<!-- Create Memo Modal -->
<div id="memoModal" class="fixed inset-0 z-40 flex items-center justify-center bg-gray bg-opacity-30 hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-lg shadow-lg relative z-50">
        <button onclick="closeMemoModal()"
            class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl font-bold"
            aria-label="Close Modal">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Create New Memo</h2>

        <form id="createMemoForm" action="{{ route('dean.memo.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-medium">Title</label>
                <input type="text" name="title" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-medium">Description</label>
                <textarea name="description" rows="3" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-medium">Date</label>
                <input type="date" name="date" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-medium">Upload File (PDF only)</label>
                <input type="file" name="file" accept="application/pdf" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label for="emails" class="block text-gray-700 dark:text-gray-300 font-medium">Recipient Emails</label>
                <select name="emails[]" id="emails" multiple
                    class="form-control select2 px-1 py-[6px] w-full border rounded border-[#a3a3a3]" size="10">
                    @foreach($users as $user)
                        <option value="{{ $user->email }}">{{ $user->lastname }} {{ $user->firstname }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">You can select or type new email addresses.</p>
            </div>
            <div class="text-right">
                <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">Upload Memo</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Memo Modal -->
<div id="editMemoModal" class="fixed inset-0 flex items-center justify-center bg-gray bg-opacity-30 z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-2xl relative">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Edit Memo</h2>

        <button onclick="document.getElementById('editMemoModal').classList.add('hidden')"
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>

        <form id="editMemoForm" method="POST"
            action="{{ route('dean.memo.update', ['id' => '__ID__']) }}"
            data-action-template="{{ route('dean.memo.update', ['id' => '__ID__']) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="editMemoTitle"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="editMemoDescription" rows="4"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-medium">Upload New File (optional)</label>
                <input type="file" name="file" accept="application/pdf"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500 font-semibold">
                    Update Memo
                </button>
            </div>
        </form>
    </div>
</div>

<!-- jQuery & Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

<!-- Init Select2 -->
<script>
    $(document).ready(function() {
        $('#emails').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            placeholder: "Select or type email(s)",
            width: '100%'
        });
    });
</script>

<!-- Open Memo Modal -->
<script>
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
</script>

<!-- Edit Memo Modal Script -->
<script>
function openEditMemoModal(id, title, description) {
    const modal = document.getElementById('editMemoModal');
    const titleInput = document.getElementById('editMemoTitle');
    const descInput = document.getElementById('editMemoDescription');
    const form = document.getElementById('editMemoForm');

    if (!modal || !titleInput || !descInput || !form) {
        console.error('One or more elements not found');
        return;
    }

    modal.classList.remove('hidden');
    titleInput.value = title;
    descInput.value = description;

    const actionTemplate = form.getAttribute('data-action-template');
    form.action = actionTemplate.replace('__ID__', id);
}
</script>

@endsection
