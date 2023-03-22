<?php

namespace App\Models;

use App\Exceptions\WarehouseOutOfProductException;
use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PointProduct extends Model
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'pointproduct';

   /**
    * Relations
    */

    public function product(){
      return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function point(){
      return $this->belongsTo(Point::class, 'division_id', 'id');
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
      }else{
        $pointProduct = new self();
        $pointProduct->point_id = $item->party->point_id;
        $pointProduct->product_id = $item->product_id;
        $pointProduct->quantity = $item->quantity;
        $pointProduct->created_by_id = auth()->user()->id;
        $pointProduct->save();
      }
    }
    
    public static function removeItem($item){
      $pointProduct = PointProduct::where([
        'product_id'=> $item->product_id,        
        'point_id'=> $item->party->point_id
      ])->first();

      if($pointProduct->quantity >= $item->quantity ){
        $pointProduct->quantity = $pointProduct->quantity - $item->quantity;
        $pointProduct->save();
      }else{
        throw new WarehouseOutOfProductException(); 
      }
    }
    public static function addItemByParty($party, $only_new=false){
      DB::transaction(function() use($party, $only_new){
        foreach($party->items as $item){
          $pointProduct = PointProduct::where([
            'product_id'=> $item->product_id,        
            'point_id'=> $party->point_id
          ])->first();
            
          if($pointProduct && $only_new){
            continue;
          }
          if($pointProduct){
            $pointProduct->quantity = $pointProduct->quantity + $item->quantity;
            $pointProduct->save();
            continue;
          }else{
            $pointProduct = new self();
            $pointProduct->point_id = $item->party->point_id;
            $pointProduct->product_id = $item->product_id;
            $pointProduct->quantity = $item->quantity;
            $pointProduct->created_by_id = auth()->user()->id;
            $pointProduct->save();
          }
        }
      });      
    }
    public static function removeItemByParty($party){
      DB::transaction(function() use($party){
        foreach($party->items as $item){
          $pointProduct = PointProduct::where([
            'product_id'=> $item->product_id,        
            'point_id'=> $party->point_id
          ])->first();
    
          if($pointProduct->quantity >= $item->quantity ){
            $pointProduct->quantity = $pointProduct->quantity - $item->quantity;
            $pointProduct->save();
          }else{
            throw new WarehouseOutOfProductException(); 
          }
        }
      });
      
    }
    public static function removeItemByOrder($order){
      DB::transaction(function() use($order){
        foreach($order->items as $item){
          $pointProduct = PointProduct::where([
            'product_id'=> $item->product_id,        
            'point_id'=> $order->from_point_id
          ])->first();

          if($pointProduct->quantity >= $item->quantity ){
            $pointProduct->quantity = $pointProduct->quantity - $item->quantity;
            $pointProduct->save();
          }else{
            throw new WarehouseOutOfProductException(); 
          }
        }
      });
    }
    public static function addItemByOrder($order){
      DB::transaction(function() use($order){
        foreach($order->items as $item){
          $pointProduct = PointProduct::where([
            'product_id'=> $item->product_id,        
            'point_id'=> $order->from_point_id
          ])->first();
          if(!$pointProduct){
            $pointProduct = new PointProduct();
            $pointProduct->point_id = $order->shop_id;
            $pointProduct->product_id = $item->product_id;
            $pointProduct->save();
          }
          $pointProduct->quantity = $pointProduct->quantity + $item->quantity;
          $pointProduct->save();
        }
      });
    }
    public static function transferItemBulk($transfer){
      DB::transaction(function() use($transfer){
        foreach($transfer->items as $item){
          self::transferItem($item);
        }
      });
    }
    public static function revertTranferItemBulk($transfer){
      DB::transaction(function() use($transfer){
        foreach($transfer->items as $item){
          self::revertTranferItem($item);
        }
      });
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

    /**
     * get available products
     */

    public static function getAvailableAmount($product_id, $shop_id){
      $pp = self::where(['point_id'=>$shop_id, 'product_id'=>$product_id])->first();
      if(!$pp){
        return 0;
      }
      return $pp->quantity;
    }

    /**
     * 
     * get matching shops to satisfy the shortages
     */
    public static function getMatches($items){
      $fullMatches = collect([]);
      $partialMatches = collect([]);
      $shops = Point::all();
      foreach($shops as $shop){
        $match = true;
        foreach($items as $item){
          $available = self::where(['point_id'=>$shop->id, 'product_id'=>$item->product_id])->where('quantity', '>=', $item->quantity)->first();
          if(!$available){
            $match = false;
          }
          if($available &&  $partialMatches->has($shop->id)){
            $initial = $partialMatches->get($shop->id);
            $items = $initial->get('items');
            $items->push($item);
            $initial->put('items', $items);
            $partialMatches->put($shop->id, $initial );
          }
          if($available &&  !$partialMatches->has($shop->id)){
            $partialMatches->put($shop->id, collect(['shop'=>$shop, 'items'=>collect([$item])]) );
          }
        }
        if($match){
          $fullMatches->put($shop->id,$shop);
        }
      }
      foreach($fullMatches as $key=>$fm){
        $partialMatches->forget($key);
      }
      return [
        'fullMatches'=>$fullMatches,
        'partialMatches'=>$partialMatches
      ];
    }
}
