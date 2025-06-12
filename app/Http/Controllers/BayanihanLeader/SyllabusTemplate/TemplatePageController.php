<?php

namespace App\Http\Controllers\BayanihanLeader\SyllabusTemplate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // optional, if you plan to get notifications from user

class TemplatePageController extends Controller
{
    public function show()
    {
        $notifications = []; 
        return view('bayanihanleader.SyllabusTemplate.Template', compact('notifications'));
    }
}
