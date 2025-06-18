@extends('layouts.btSidebar')

@section('content')
<div class="mt-16 p-4 shadow bg-white border-dashed rounded-lg dark:border-gray-700">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dean Memos</h1>
        <p class="text-gray-600 dark:text-gray-300">View and download memos issued by the Dean.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse text-left">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-white">Title</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-white">Description</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-white">Date</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-white">Download</th>
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
                        <td class="px-4 py-2">
                            <a href="{{ route('dean.memo.download', $memo->id) }}"
                               class="text-blue-600 hover:underline text-sm">Download</a>
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
@endsection
