<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
    public $incrementing = false;
    protected $keyType = 'string';
   protected $table = 'uzpos_sales_order';

   /**
    * events 
    */
    protected static function booted()
    {
        static::creating(function($order){
            $order->id = (string) Str::uuid();
        });
        static::updating(function($order){
          if($order->status == 2 && $order->getOriginal('status')==1){
            PointProduct::removeItemByOrder($order);
          }
          if($order->status == 3 && $order->getOriginal('status')==2){
            PointProduct::addItemByOrder($order);
          }
        });
    }
   /**
    * Relations
    */
    public function client(){
      return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function items(){
      return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    public function payments(){
      return $this->hasMany(Payment::class, 'order_id', 'id');
    }
    
    /**
     * 
     * constants
     */

    const DRAFT = 1;
    const CONFIRMED = 2;
    const BROKEN = 3;

    /**
     * 
     * Accessors 
     */

     public function getStatusNameAttribute(){
       switch($this->status){
        case 1:
          return 'ЧЕРНОВЕК';
        case 2:
          return 'ПОДВЕРЖДЕН';
        case 3:
          return 'БРАК';
       }
     }
    /**
     * custom functions
     */
    public function getClientFullName(){
      if($this->client){
        return $this->client->fullName;
      }else{
        return '';
      }
    }
    public function getTotalItemCount(){
      $quantity = 0;
      foreach($this->items as $item){
        $quantity += $item->quantity;
      }
      return $quantity;
    }
    public function getTotalCost(){
      $cost = 0;
      foreach($this->items as $item){
        $cost += $item->price * $item->quantity;
      }
      return $cost;
    }
    public function getTotalPaid(){
      $paid = 0;
      foreach($this->payments as $payment){
        $paid += $payment->amount_real;
      }
      return $paid;
    }

    /**
     * 
     * check if order has enough payment and shop has enough items to accept the order
     */
    public function canBeConfirmed(){
      $shouldBePaid = $this->getTotalCost();
      $paid = 0;
      foreach($this->payments as $payment){
        $paid = $paid + $payment->amount;
      }
      if($shouldBePaid > $paid){
        return false;
      }

      foreach($this->items as $item){
        $quantityToSubtract = $item->quantity;
        $quantityAvailable = PointProduct::getAvailableAmount($item->product_id, $this->shop_id);
        if($quantityAvailable - $quantityToSubtract < 0){
          return false;
        }
      }
      return true;
    }

    public function hasEnoughPayment(){
      $shouldBePaid = $this->getTotalCost();
      $paid = 0;
      foreach($this->payments as $payment){
        $paid = $paid + $payment->amount;
      }
      if($shouldBePaid > $paid){
        return false;
      }
      return true;
    }
    public function hasEnoughItems(){
      foreach($this->items as $item){
        $quantityToSubtract = $item->quantity;
        $quantityAvailable = PointProduct::getAvailableAmount($item->product_id, $this->shop_id);
        if($quantityAvailable - $quantityToSubtract < 0){
          return false;
        }
      }
      return true;
    }
    
}
