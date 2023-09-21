<?php

namespace App\Models;

use App\Exceptions\WrongCredentialsException;
use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    
    /**
     *
     * Traits
     */
    use SoftDeletes;
    use Fabricatable;

    /**
     * Relations
     */

    public function division()
    {
        return $this->belongsTo(Point::class, 'division_id', 'id');
    }

     /**
      * Properties
      */
    protected $table = 'users';
    protected $hidden = ['password', 'token'];
    public $timestamps = false;
    const salt = 'ujEdKc.{u2-?f(y5';
    const roles = [
        'ADMIN' => 0,
        'SELLER' => 1,
        'WAREHOUSE_MANAGER' => 2,
        'COLLECTOR' => 3,
        'ACCOUNTANT' => 4,
        'SHOP_MANAGER' => 5,
        'DELIVERY' => 6,
        'OWNER'=>7
    ];
    const ADMIN = 0;
    const SELLER = 1;
    const WAREHOUSE_MANAGER = 3;
    const COLLECTOR = 4;
    // const ACCOUNTANT = 4;
    // const SHOP_MANAGER = 5;
    const DELIVERY = 7;
    // const OWNER = 7;

    public function getRoleName()
    {
        switch($this->user_role)
        {
            case self::ADMIN:
                return 'Админ';
            case self::SELLER:
                return 'Продавец';
            case self::WAREHOUSE_MANAGER:
                return 'Складчик';
            case self::COLLECTOR:
                return 'Сборщик';
            case self::ACCOUNTANT:
                return 'Бухгалтер';
            case self::SHOP_MANAGER:
                return 'Менеджер магазина';
            case self::DELIVERY:
                return 'Доставщик';
            case self::OWNER:
                return 'Владелец';
        }
    }

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
        $user = self::where(['username'=>$username, 'password'=>$password, 'is_active'=>1])->first();
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
