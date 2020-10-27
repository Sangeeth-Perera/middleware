<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\messageHistory;

class MessageHistoryController extends Controller
{
    //
    public function count()
    {
        $msgs = messageHistory::all();

       

        return view('history', compact('msgs'));
    }
}
