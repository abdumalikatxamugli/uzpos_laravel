<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AuthUserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $this->app->bind(User::class, function($app) use ($request) {
            if($request->hasHeader('Authorization') && User::where('token', $request->bearerToken())->exists()){
                return User::where('token', $request->bearerToken())->first();
            }
            if(auth()->user()){
                return auth()->user();
            }
        });
    }
}
