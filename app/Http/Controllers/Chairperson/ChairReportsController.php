<?php

namespace App\Http\Controllers\Chairperson;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChairReportsController extends Controller
{
    public function index()
    {
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Chairperson.Reports.reports', compact('notifications'));
    }
}