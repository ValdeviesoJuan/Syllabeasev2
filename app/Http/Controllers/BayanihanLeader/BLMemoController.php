<?php

namespace App\Http\Controllers\BayanihanLeader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Memo;

class BLMemoController extends Controller
{
    public function index()
    {
        $memos = Memo::latest()->get(); // Same as Chair view
        return view('BayanihanLeader.Memo.blLeader', compact('memos'));
    }
}
