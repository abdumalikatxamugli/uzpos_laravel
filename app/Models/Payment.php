<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'payments';
   /**
    * Relations
    */
    public function repayments(){
      return $this->hasMany(Repayment::class, 'payment_id', 'id');
    }
   /**
    * constants
    */
    const TERMINAL = 0;
    const CASH = 1;
    const ACCRUAL = 2;
    const DEBT = 3;

    const PAYMENT_TYPES = [
      'TERMINAL'=>[
        'code'=>0,
        'name'=>'Терминал'
      ],
      'CASH'=>[
        'code'=>1,
        'name'=>'Наличные'
      ],
      'ACCRUAL'=>[
        'code'=>2,
        'name'=>'Начисления'
      ],
      'DEBT'=>[
        'code'=>3,
        'name'=>'Долг'
      ]
    ];
    const PAYMENT_TYPES_REVERT = [
      0=>'Терминал',
      1=>'Наличные',
      2=>'Начисления',
      3=>'Долг'
    ];
    const CURRENCIES = [
      'UZS'=>[
        'code'=>2,
        'name'=>'Сум'
      ],
      'USD'=>[
        'code'=>1,
        'name'=>'Доллары'
      ]
    ];
    const CURRENCIES_REVERT = [
      2=>'Сум',
      1=>'Доллары'
    ];
    /** 
     * Accessors
     */
    public function getCurrencyTypeNameAttribute(){
      return self::CURRENCIES_REVERT[$this->currency]??'';
    }
    
    public function getPaymentTypeNameAttribute(){
      return self::PAYMENT_TYPES_REVERT[$this->payment_type]??'';
    }
}

