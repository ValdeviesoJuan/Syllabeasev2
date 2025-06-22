<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Memo;

class ChairMemoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

         $memos = Memo::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        })->latest()->get();
        return view('Chairperson.Memo.chairMemo', compact('memos'));
    }
}
