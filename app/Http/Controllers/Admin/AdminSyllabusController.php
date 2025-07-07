<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Syllabus;
use App\Models\BayanihanGroup;

use Illuminate\Support\Facades\Auth;

class AdminSyllabusController extends Controller
{
    public function index() 
    {
        return view('admin.syllabus.sylllist');
    }
    
}
