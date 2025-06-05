<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use App\Models\Chairperson as ModelsChairperson;
use App\Models\Deadline;
use App\Models\Dean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeanReportsController extends Controller
{
    public function index(){
        $user = Auth::user(); 
        $notifications = $user->notifications;
        return view('Dean.Reports.reports' ,compact('notifications'));
    }
}