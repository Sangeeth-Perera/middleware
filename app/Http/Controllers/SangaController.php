<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SangaController extends Controller
{
    //
      public function __construct()
    {
        $this->middleware('auth');
    }
    public function test(){
         $this->middleware('auth');
        return view('mainInterface');
    }
}
