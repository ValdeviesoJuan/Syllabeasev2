<?php

namespace App\Http\Controllers\BayanihanLeader\SyllabusTemplate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyllabusTemplateController extends Controller
{
    public function create()
    {
        // Get the logged-in user's notifications
        $notifications = Auth::user()->notifications;

        // Pass the notifications to the view
        return view('bayanihanleader.SyllabusTemplate.CreateTemplate', compact('notifications'));
    }
}
