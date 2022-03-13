<?php

namespace App\Http\Controllers;

use App\Exceptions\UnexpectedErrorException;
use App\Exceptions\WrongCredentialsException;
use App\Http\Validators\AuthValidator;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
    public function getCurrentUser(user $user){
        return $user;
    }
    public function __call($method, $args){
        $method = explode("_", $method)[1];
        return App::call([new AuthValidator, $method]);
    }
}
