<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends UuidModel
{
    /**
    * Traits
    */
   use Fabricatable;
   use HasFactory;
    /**
     * Properties
     */
   protected $table = 'uzpos_core_product';

   /**
    * custom functions
    */
  public static function genBarcode(){
    $barcode = rand(100000000000, 99900000000000);
    if(self::where('bar_code', $barcode)->first()){
      return self::genBarcode();
    }
    return $barcode;
  }
}
