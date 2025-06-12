<?php

namespace App\Http\Controllers\BayanihanLeader\SyllabusTemplate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SyllabusTemplateController extends Controller
{
    public function create()
    {
        return view('bayanihanleader.SyllabusTemplate.CreateTemplate');
    }
}