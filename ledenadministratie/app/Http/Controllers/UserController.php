<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Show Registrate form
    public function create()
    {
        return view('users.register');
    }

    // Create new User
    public function store(Request $request) {

        try {
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

            return redirect('/')->with('message', 'User created and logged in');

        } catch (\Exception $e) {
            Log::error('Error while creating the user: ' . $e->getMessage());

            return back()->with('error', 'There is an error while creating the user.');
        }
    }

    // Logout USER
    public function logout(Request $request) {

        try {
            auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('message', 'User logged out');

        } catch (\Exception $e) {
            Log::error('Error while logging out the user: ' . $e->getMessage());

            return back()->with('error', 'There is an error while logging out the user.');
        }
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
        if(auth()->attempt($dataFields, $request->remember)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'User logged in');
        }

        return back()
        ->withErrors(['email' => 'Invalid username/password combination']);
    }
}