@extends('layouts.deanSidebar')

@section('content')
<div class="mt-16 p-6 max-w-2xl mx-auto bg-white shadow rounded-lg dark:bg-gray-800">
    <a href="{{ route('dean.memo') }}" class="text-gray-600 hover:text-red-600 text-2xl font-bold float-right">
        &times;
    </a>
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Edit Memo</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('dean.memo.update', $memo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-medium">Title</label>
            <input type="text" name="title" value="{{ $memo->title }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-medium">Description</label>
            <textarea name="description" rows="3" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">{{ $memo->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-medium">Date</label>
            <input type="date" name="date" value="{{ $memo->date }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-medium">Upload New File (optional)</label>
            <input type="file" name="file" accept="application/pdf"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">
            <p class="text-sm text-gray-500 mt-1">Current File: <strong>{{ $memo->file_name }}</strong></p>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">Update Memo</button>
        </div>
    </form>
</div>
@endsection
