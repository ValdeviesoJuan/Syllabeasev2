<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Memo;

class ChairMemoController extends Controller
{
    public function index()
    {
        $memos = Memo::latest()->get(); // You can filter by dean if needed
        return view('Chairperson.Memo.chairMemo', compact('memos'));
    }
}
