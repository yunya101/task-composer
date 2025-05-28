<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //TODO
    public function __invoke()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return view('welcome');
    }
}
