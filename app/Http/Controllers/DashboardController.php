<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //TODO
    public function __invoke()
    {
        $groups = Auth::user()->groups()->wherePivot('is_active', true)->get();

        return view('dashboard', compact('groups'));
    }
}
