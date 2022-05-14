<?php

namespace App\Models;

use App\Exceptions\WrongCredentialsException;
use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     *
     * Traits
     */
    use Fabricatable;
     /**
      * Properties
      */
    protected $table = 'auth_user';
    protected $hidden = ['password', 'token'];
    public $timestamps = false;
    const salt = 'ujEdKc.{u2-?f(y5';
    const roles = [
        'ADMIN' => 0,
        'SELLER' => 1,
        'WAREHOUSE_MANAGER' => 3,
        'COLLECTOR' => 4,
        'ACCOUNTANT' => 5,
        'SHOP_MANAGER' => 6,
        'DELIVERY' => 7
    ];
    const BUSY = 1;
    const FREE = 0;
    /**
     *
     * Mutators
     */

    /**
     * password mutator
     */

    protected function password():Attribute{
        return Attribute::make(
            set: fn($value) => hash('sha3-256', self::salt.$value)
        );
    }
   
    /**
     * 
     * 
     * Accessors
     */
    
     public function getFullNameAttribute(){
         return "{$this->last_name} {$this->first_name}";
     }

    /**
     *
     * Custom function
     */

    /**
     * generate new token for the user
     * @params none
     * @return void
     */
    public function generateToken(){
        $this->token = hash('sha3-256', time().$this->username.$this->id);
        $this->save();
    }
    public static function login($credentials){
        $username = $credentials['username'];
        $password = hash('sha3-256', self::salt.$credentials['password']);
        $user = self::where(['username'=>$username, 'password'=>$password])->first();
        if($user){
            return $user;
        }
        throw new WrongCredentialsException();
    }
    public static function modPassword($credentials){
        $username = $credentials['username'];
        $password = hash('sha3-256', self::salt.$credentials['password']);
        $user = self::where('username', $username)->first();
        $user->password = $password;
        $user->save();
        return $user;
    }
    public static function makeBusy($user_id){
        $user = self::where('id', $user_id)->first();
        $user->busy = 1;
        $user->save();
    }
    public static function makeFree($user_id){
        $user = self::where('id', $user_id)->first();
        $user->busy = 0;
        $user->save();
    }
}
