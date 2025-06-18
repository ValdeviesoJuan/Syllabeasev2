<?php

namespace App\Http\Controllers\BayanihanTeacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Memo;

class BTMemoController extends Controller
{
    public function index()
    {
        $memos = Memo::latest()->get();
        return view('BayanihanTeacher.Memo.btMemo', compact('memos'));
    }
}
