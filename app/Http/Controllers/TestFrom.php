<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestFrom extends Controller
{
    public function Show(){
        return view('TestForm');
    }
}
