<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        return view('users.account', compact('user'));
    }
}
