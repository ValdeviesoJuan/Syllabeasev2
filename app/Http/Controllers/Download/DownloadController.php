<?php

namespace App\Http\Controllers\Download;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
class DownloadController extends Controller
{
    public function download($file)
    {
        $directory = public_path('downloads');
        $path = $directory . '/' . $file;
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->download($path);
    }
}
