<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasubagController extends Controller
{
    public function index()
    {
        return view(view: 'kasubag.dashboard');
    }
}
