<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /**
    * Traits
    */

   use SoftDeletes;
   use Fabricatable;
   use HasFactory;
    /**
     * Properties
     */
   protected $table = 'products';
  
   /**
    * Relations
    */
    public function metric(){
      return $this->belongsTo(Metric::class, 'metric_id', 'id');
    }
   /**
    * custom functions
    */
  public static function genBarcode(){
    $barcode = "";
    for($i=0; $i<12; $i++){
      $barcode .= strval(rand(0,9));
    }
   
    if(self::where('bar_code', $barcode)->first()){
      return self::genBarcode();
    }
    return $barcode;
  }
}
