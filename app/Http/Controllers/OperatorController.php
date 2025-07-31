<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    public function operatorIndex()
    {
        $layout = match (auth()->user()->role) {
            'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        return view('admin.dashboard.operator', compact('layout'));
    }


}