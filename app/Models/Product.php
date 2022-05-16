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
    for($i=0; $i<12; $i++){
      $barcode .= rand(0,9);
      $i++;
    }
   
    if(self::where('bar_code', $barcode)->first()){
      return self::genBarcode();
    }
    return $barcode;
  }
}
