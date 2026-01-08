<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ckeditor');
    }
  
    /**
     * Upload the image for the user.
     */
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName   = pathinfo($originName, PATHINFO_FILENAME);
            $extension  = $request->file('upload')->getClientOriginalExtension();
            $fileName   = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $url = asset('images/'.$fileName);
            return json_encode(['uploaded' => 1, "url"=> $url]);
        }
    }
}
