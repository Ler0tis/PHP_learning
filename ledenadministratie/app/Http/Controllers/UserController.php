<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Show register form
    public function create()
    {
        return view('users.register');
    }

    // Create new user
    public function store(RegisterRequest $request)
    {
        try {
            $dataFields = $request->validated();

            // Hash password with  Bcrypt
            $dataFields['password'] = bcrypt($dataFields['password']);

            // Create USER
            $user = User::create($dataFields);

            // LOGIN
            Auth::login($user);

            return redirect('/')->with('message', 'Created user and logged in.');
        } catch (\Exception $e) {
            Log::error('Error while creating this user: ' . $e->getMessage());

            return back()->with('error', 'There was an Error while creating this user.');
        }
    }

    // Show login form
    public function login()
    {
        return view('users.login');
    }

    // Authenticate user
    public function authenticate(LoginRequest $request)
    {
        $dataFields = $request->validated();

        // Checked user Remember me? Cookie gets saved for next time login
        $remember = $request->has('remember') ? true : false;

        if (Auth::attempt($dataFields, $remember)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'User logged in');
        }

        return back()->withErrors(['email' => 'Invalid combination of credentials.']);
    }


    // Logout user
    public function logout()
    {
        try {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect('/')->with('message', 'User logged out.');
        } catch (\Exception $e) {
            Log::error('Error while logging out user: ' . $e->getMessage());

            return back()->with('error', 'There was an Error while loggin out this user.');
        }
    }
}