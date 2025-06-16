@extends('layouts.deanSidebar')

@section('content')
@include('layouts.modal')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="mt-16 p-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700">

    {{-- Header --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dean Memos</h1>
            <p class="text-gray-600 dark:text-gray-300">Issued memos and documents. Click download to access.</p>
        </div>
        <button onclick="openMemoModal()" 
            class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">
            Create Memo
        </button>
    </div>

    {{-- Memo Table --}}
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse text-left">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-white">Title</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-white">Description</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-white">Date</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($memos as $memo)
                <tr class="border-b dark:border-gray-600">
                    <td class="px-4 py-2">{{ $memo->title }}</td>
                    <td class="px-4 py-2 line-clamp-2">{{ Str::limit($memo->description, 60) }}</td>
                    <td class="px-4 py-2">
                        {{ $memo->date ? \Carbon\Carbon::parse($memo->date)->format('F d, Y') : 'No date' }}
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('dean.memo.download', $memo->id) }}"
                            class="text-blue-600 hover:underline text-sm">Download</a>
                        <button onclick="openEditMemoModal({{ $memo->id }}, '{{ $memo->title }}', '{{ $memo->description }}')"
                            class="text-blue-600 hover:underline">Edit</button>
                        <form action="{{ route('dean.memo.destroy', $memo->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">No memos available at the moment.</td>
                </tr>
                @endforelse
            </tbody>
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
