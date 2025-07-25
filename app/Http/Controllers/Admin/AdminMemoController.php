<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Memo;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminMemoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $memos = Memo::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        })->latest()->get();

        $users = User::select('email')->get();

        return view('admin.memo.memoslist', compact('memos', 'users'));
    }
    public function show($id)
    {
        $memo = Memo::findOrFail($id);
        return view('admin.memo.showMemo', compact('memo'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files.*' => 'required|file|mimes:pdf',
            'date' => 'nullable|date',
            'emails' => 'required|array',
            'emails.*' => 'email'
        ]);

        $fileNames = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/memos', $filename);
                $fileNames[] = $filename;
            }
        }

        $memo = Memo::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_name' => json_encode($fileNames),
            'date' => $validated['date'],
        ]);

        foreach ($validated['emails'] as $email) {
            Mail::to($email)->send(new \App\Mail\MemoNotification($memo));
        }

        return redirect()->route('admin.memo')->with('success', 'Memo uploaded and emails sent.');
    }
    public function edit($id)
    {
        $memo = Memo::findOrFail($id);
        return view('admin.Memo.editMemo', compact('memo'));
    }
    public function download($id, $filename)
    {
        $memo = Memo::findOrFail($id);
        $rawFiles = json_decode($memo->file_name, true);
        $files = is_array($rawFiles) ? $rawFiles : [$memo->file_name];

        if (!in_array($filename, $files)) {
            return back()->with('error', 'File not associated with this memo.');
        }

        $filePath = storage_path('app/public/memos/' . $filename);
        return file_exists($filePath) ? response()->download($filePath) : back()->with('error', 'File not found.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'files.*' => 'nullable|mimes:pdf|max:2048',
        ]);

        $memo = Memo::findOrFail($id);
        $memo->title = $request->title;
        $memo->description = $request->description;
        $memo->date = $request->date;

        $fileNames = $memo->file_name ? json_decode($memo->file_name, true) : [];

        if ($request->hasFile('files')) {
            // Delete old files
            foreach ($fileNames as $file) {
                if (Storage::exists('public/memos/' . $file)) {
                    Storage::delete('public/memos/' . $file);
                }
            }

            $fileNames = [];
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/memos', $filename);
                $fileNames[] = $filename;
            }

            $memo->file_name = json_encode($fileNames);
        }

        $memo->save();

        return redirect()->route('admin.memo')->with('success', 'Memo updated successfully.');
    }
    public function destroy($id)
    {
        $memo = Memo::findOrFail($id);

        if (!empty($memo->file_name)) {
            $filePath = 'public/memos/' . $memo->file_name;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        $memo->delete();

        return redirect()->route('admin.memo')->with('success', 'Memo deleted successfully.');
    }
}
