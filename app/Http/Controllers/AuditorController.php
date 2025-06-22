<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditorController extends Controller
{
    public function home()
    {
        return view('auditor.home');
    }
}

