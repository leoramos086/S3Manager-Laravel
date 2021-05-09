<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3Controller extends Controller
{


    public function getFiles(Request $request){
        return Storage::disk('s3')->files('/',);
    }
}
