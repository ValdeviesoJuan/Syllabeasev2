<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Memo;

class BLMemoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

         $memos = Memo::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        })->latest()->get();
        return view('BayanihanLeader.Memo.blLeader', compact('memos'));
    }

    public function show($id)
    {
        $memo = Memo::findOrFail($id);
        return view('BayanihanLeader.Memo.showMemoBleader', compact('memo'));
    }
}
