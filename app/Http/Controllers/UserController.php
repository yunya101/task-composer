<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
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

    public function edit(Request $request)
    {
        $data = $request->validate([
            'name' => ['string', 'nullable', 'max:50'],
            'email' => ['email', 'nullable'],
            'password' => ['string', 'nullable', 'min:5', 'max:50', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->name = $data['name'] ?? $user->name;
        $user->email = $data['email'] ?? $user->email;
        $user->password = $data['password'] ?? $user->password;

        $user->update();

        return back();

    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
