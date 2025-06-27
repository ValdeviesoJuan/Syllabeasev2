<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TOS;

class AuditorTOSController extends Controller
{
    public function index()
    {   
        return view('auditor.TOS.tosList');
    }

    public function viewTos($tos_id)
    {
        return view('auditor.TOS.tosView');
    }
}
