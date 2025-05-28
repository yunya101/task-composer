<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:50'],
            'email' => ['required', 'email'],
            'password' => ['string', 'min:5', 'max:50', 'confirmed'],
        ]);

        $user = User::create($data);
        $user->sendEmailVerificationNotification();

        Auth::login($user, $request->filled('remember'));

        return redirect()->route('dashboard');
    }
}
