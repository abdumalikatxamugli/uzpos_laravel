<?php

namespace App\Models;

use App\Exceptions\WarehouseOutOfProductException;
use App\Traits\Fabricatable;

class PointProduct extends UuidModel
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'uzpos_core_pointproduct';

    public static function addItem($item){
      $pointProduct = PointProduct::where([
          'product_id'=> $item->product_id,        
          'point_id'=> $item->party->point_id
      ])->first();

      if($pointProduct){
        $pointProduct->quantity = $pointProduct->quantity + $item->quantity;
        $pointProduct->save();
        return;
      }
      $pointProduct = new self();
      $pointProduct->point_id = $item->party->point_id;
      $pointProduct->product_id = $item->product_id;
      $pointProduct->quantity = $item->quantity;
      $pointProduct->created_by_id = auth()->user()->id;
      $pointProduct->save();
    }
    public static function removeItem($item){
      $pointProduct = PointProduct::where([
        'product_id'=> $item->product_id,        
        'point_id'=> $item->party->point_id
      ])->first();

      if($pointProduct->quantity >= $item->quantity ){
        $pointProduct->quantity = $pointProduct->quantity - $item->quantity;
        $pointProduct->save();
        return;
      }else{
        throw new WarehouseOutOfProductException(); 
      }
    }
    
}
