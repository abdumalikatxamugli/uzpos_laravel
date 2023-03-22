<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'orderitems';

   public $timestamps = false;

   /**
    * Relations
    */
    public function product(){
      return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

