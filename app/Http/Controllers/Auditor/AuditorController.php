<?php

namespace App\Http\Controllers\Auditor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TOS;
use App\Models\Syllabus; 

class AuditorController extends Controller
{
    public function home()
    {
        return view('auditor.home');
    }

    public function tos()
    {
        $toss = TOS::all();
        return view('auditor.TOS.tosList', compact('toss'));
    }

    public function syllabus()
    {
        $syll = Syllabus::all(); 
        return view('auditor.Syllabus.syllView', compact('syll'));
    }
}
