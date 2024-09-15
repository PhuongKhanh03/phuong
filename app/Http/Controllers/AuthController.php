<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function showRegistrationForm(){
        return view('auth.register');
    }
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        try{
            Log::info('Registering user with email: ' . $request->email);
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
            ]);
            Log::info('User registered successfully');
            return redirect()->route('login')->with('success','Registration successful! Please login. ');
        }catch(\Exception $e){
            Log::error('Registration failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }
    public function showLoginForm(){
        return view('auth.login');
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if(Auth::attempt($request->only('email','password'))){
            $request->session()->regenerate();

            if(Auth::user()->role === 'admin'){
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('welcome'));
        }
        return redirect()->back()->with('error', 'The provided credentials are incorrect. ');
    }
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
