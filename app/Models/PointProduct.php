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

   /**
    * Relations
    */

    public function product(){
      return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    /**
     * custom methods
     */
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
    public static function transferItem($item){
      $fromPointProduct = PointProduct::where([
          'product_id'=> $item->product_id,        
          'point_id'=> $item->transfer->from_point_id
      ])->first();

      $toPointProduct = PointProduct::where([
          'product_id'=> $item->product_id,        
          'point_id'=> $item->transfer->to_point_id
      ])->first();

      if($fromPointProduct->quantity < $item->quantity){
        throw new WarehouseOutOfProductException();
        return;
      }

      if($fromPointProduct){
        $fromPointProduct->quantity = $fromPointProduct->quantity - $item->quantity;
        $fromPointProduct->save();
        if($toPointProduct){
          $toPointProduct->quantity = $toPointProduct->quantity + $item->quantity;
          $toPointProduct->save();
        }else{
          $toPointProduct = new self();
          $toPointProduct->point_id = $item->transfer->to_point_id;
          $toPointProduct->product_id = $item->product_id;
          $toPointProduct->quantity = $item->quantity;
          $toPointProduct->created_by_id = auth()->user()->id;
          $toPointProduct->save();
        }
      }
      
      
    }
    public static function revertTranferItem($item){

    
      $fromPointProduct = PointProduct::where([
          'product_id'=> $item->product_id,        
          'point_id'=> $item->transfer->from_point_id
      ])->first();

      $toPointProduct = PointProduct::where([
          'product_id'=> $item->product_id,        
          'point_id'=> $item->transfer->to_point_id
      ])->first();

      if($toPointProduct->quantity < $item->quantity){
        throw new WarehouseOutOfProductException();
        return;
      }

      if($fromPointProduct){
        $fromPointProduct->quantity = $fromPointProduct->quantity + $item->quantity;
        $fromPointProduct->save();
        $toPointProduct->quantity = $toPointProduct->quantity - $item->quantity;
        $toPointProduct->save();        
      }
    }
}
