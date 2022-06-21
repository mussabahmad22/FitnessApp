<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class UploadController extends Controller
{

    // public function index()
    // {
    //     return view('file-upload');
    // }

    public function store(Request $request){

        //dd('request');

        if ($request->file('video_file') == null) {
           
            return "Your File is empty";

        } else {
            $name = $request->file('video_file')->getClientOriginalName();
 
            $path = $request->file('video_file')->store('public/files');
            $vedio_name = "files/" .  basename($path);

            // $save = new File; 
            // $save->name = $name;
            // $save->path = $path;
            // $save->save();
            return $vedio_name;
        }



    }
}
