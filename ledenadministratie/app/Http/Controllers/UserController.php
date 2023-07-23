<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Registrate form
    public function create()
    {
        return view('users.register');
    }

    // Create new User
    public function store(Request $request) {
        $dataFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash password with Bcrypt
        $dataFields['password'] = bcrypt($dataFields['password']);

        //create USER
        $user = User::create($dataFields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'Gebruiker aangemaakt en ingelogd.');

    }

    // Logout USER
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Succesvol uitgelogd');
    }

    // Show login form
    public function login() {
        return view('users.login');
    }

    // Authenticate USER
    public function authenticate(Request $request) {
        $dataFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        // attempt to login user and if failed, gets errormessage.
        if(auth()->attempt($dataFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Succesvol ingelogd');
        }

        return back()->withErrors(['email' => 'Ongeldige gegevens'])->onlyInput('email');
    }
}