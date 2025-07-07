<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Memo;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

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
}
