<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister(){
        return view('auth/register');
    }

    public function register(Request $request){
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->sendEmailVerificationNotification();

        Auth::login($user);
        return redirect('/dashboard');
    }

    public function showLogin(){
        return view('auth/login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            AuditLog::create([
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'log_action' => 'login',
        ]);
        
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function resendVerification(){
        Auth::user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification email sent');
    }

    public function logout(Request $request){

        AuditLog::create([
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'log_action' => 'logout',
        ]);

        Auth::logout($request);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showUpdatePassword(){
        return view('auth/update-password');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password_current' => 'required|current_password',
            'password' => 'required|min:8|confirmed',

        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'log_action' => 'update_password',
        ]);

        return back()->with('success', 'Password changed successfully');
    }

    public function updateProfile(Request $request){
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' .Auth::id(),
        ]);

        $user = Auth::user();
        $emailChanged = $request->email !==  $user->email;

            $user->name = $request->name;
            $user->email = $request->email;

        if($emailChanged){
            $user->email_verified_at = null;
        }

        $user->save();

        if($emailChanged){
            $user->sendEmailVerificationNotification();
        }

        return back()->with('success', 'Profile changed successfully');
    }
    
    
};  






