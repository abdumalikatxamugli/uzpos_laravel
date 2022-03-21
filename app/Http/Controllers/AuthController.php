<?php

namespace App\Http\Controllers;

use App\Exceptions\UnexpectedErrorException;
use App\Exceptions\WrongCredentialsException;
use App\Http\Validators\AuthValidator;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Log in the user if credential match
     *
     * @return \Illuminate\Http\Response
     * @expects
     * {
     *     "username":"root",
     *     "password":"r00t"
     * }
     */
    public function login(Request $request)
    {
        $validated = $this->validate_login();

        try{
            $user = User::login($validated);
            $user->generateToken();
            return [ 'token' => $user->token ];
        }catch(WrongCredentialsException $e){
            throw $e;
        }catch(Exception $e){
            // throw $e;
            throw new UnexpectedErrorException();
        }
    }
    /**
     * Get current authorized user
     *
     * @expects none
     * @headers Authorization
     * @return \Illuminate\Http\Response
     */
    public function getCurrentUser(User $user){
        return $user;
    }
    /**
     *
     * Log in from in user interface
     *
     * @expects username:password
     * @return View
     */
    public function dashboardLogin(){
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
     *
     * __call function for validation methods to work
     */
    public function __call($method, $args){
        $method = explode("_", $method)[1];
        return App::call([new AuthValidator, $method]);
    }
}
