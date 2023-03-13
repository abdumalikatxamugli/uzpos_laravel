<?php

namespace App\Http\Controllers;

use App\Exceptions\WrongCredentialsException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     *
     * Log in from in user interface
     *
     * @expects username:password
     * @return View
     */
    public function login(){
        $validated = $this->validate_dashboardLogin();
        try{
           $user = User::login($validated);
           Auth::login($user);
           return redirect()->route('dashboard.main');
        }catch(WrongCredentialsException $e){
            return back()->withErrors(['username'=>'Credentials does not match']);
        }
    }
    /**
     * Logout user
     * @param Request
     * @return redirect
     */
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
   
}
