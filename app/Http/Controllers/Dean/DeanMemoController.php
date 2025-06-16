<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Memo; // Ensure you have a Memo model
use Illuminate\Support\Facades\Mail;
use App\Mail\MemoNotification;
use Illuminate\Support\Facades\Storage;

class DeanMemoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        $memos = Memo::latest()->get();
        $users = \App\Models\User::select('email')->get(); // Add this line

        return view('Dean.Memo.memos', compact('notifications', 'memos', 'users'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,pdf',
            'date' => 'nullable|date',
            'emails' => 'required|array', // ← change from string to array
            'emails.*' => 'email' // validate each item as an email
        ]);

        // Handle the file upload
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/memos', $filename);

        // Store the memo
        $memo = Memo::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_name' => $filename,
            'date' => $validated['date'],
        ]);

        // Send email to each valid recipient
        foreach ($validated['emails'] as $email) {
            Mail::to($email)->send(new \App\Mail\MemoNotification($memo));
        }

        return redirect()->route('dean.memo')->with('success', 'Memo uploaded and emails sent.');
    }

    public function edit($id)
    {
        $memo = Memo::findOrFail($id);
        return view('Dean.Memo.editMemo', compact('memo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'file' => 'nullable|mimes:pdf|max:2048',
        ]);

        $memo = Memo::findOrFail($id);
        $memo->title = $request->title;
        $memo->description = $request->description;
        $memo->date = $request->date;

        if ($request->hasFile('file')) {
            // Delete old file
            if ($memo->file_name && Storage::exists('public/memos/' . $memo->file_name)) {
                Storage::delete('public/memos/' . $memo->file_name);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/memos', $filename);
            $memo->file_name = $filename;
        }

        $memo->save();

        return redirect()->route('dean.memo')->with('success', 'Memo updated successfully.');
    }

    public function destroy($id)
    {
        $memo = Memo::findOrFail($id);

        if ($memo->file_name && Storage::exists('public/memos/' . $memo->file_name)) {
            Storage::delete('public/memos/' . $memo->file_name);
        }

        $memo->delete();

        return redirect()->route('dean.memo')->with('success', 'Memo deleted successfully.');
    }

    public function download($id)
    {
        $memo = Memo::findOrFail($id);
        $filePath = storage_path('app/public/memos/' . $memo->file_name);

        if (file_exists($filePath)) {
            return response()->download($filePath, $memo->file_name);
        }

        return redirect()->back()->with('error', 'File not found.');
    }
}
