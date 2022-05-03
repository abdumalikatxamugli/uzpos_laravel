<?php

namespace App\Models;

use App\Traits\Fabricatable;

class Order extends UuidModel
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'uzpos_sales_order';

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
}
