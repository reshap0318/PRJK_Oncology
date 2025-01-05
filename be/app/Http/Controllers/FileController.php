<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    function getFile($name) {
        $path = str_replace("_", "/", $name);
        $dir = storage_path('app/private/' . $path);
        if(!File::exists($dir))
        {
            $dir = public_path()."/custom/images/filed-not-found.png";
        }
        return response()->file($dir);
    }
}
