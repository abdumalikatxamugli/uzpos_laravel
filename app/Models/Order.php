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
      $hasEnoughPayment = $this->hasEnoughPayment();
      $hasEnoughItems = $this->hasEnoughItems();
      return $hasEnoughPayment && $hasEnoughItems;
    }

    public function hasEnoughPayment(){
      $shouldBePaid = $this->getTotalCost();
      $paid = 0;
      foreach($this->payments as $payment){
        $paid = $paid + $payment->amount_real;
      }
      
      if((string) $shouldBePaid == (string) $paid){
        return true;
      }
      return false;
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
    public function getShortages(){
      $shortages = [];
      foreach($this->items as $item){
        $quantityToSubtract = $item->quantity;
        $quantityAvailable = PointProduct::getAvailableAmount($item->product_id, $this->shop_id);
        if($quantityAvailable - $quantityToSubtract < 0){
          array_push($shortages, $item);
        }
      }
      return $shortages;
    }    
    public static function getClientOrders($clientId, $pageNum=1){
      $paginator = self::where('client_id', $clientId)->orderByDesc('id')->paginate(
        $perPage = 1, $columns = ['*'], $pageName = 'orders', $pageNum
      );
      $links = [];
      if($pageNum!=1){
        array_push($links, [
          "text"=>"<<",
          "callback_data"=>json_encode(['type'=>'paginateOrder', 'page'=>$pageNum-1])
        ]);
      }
      $orders = $paginator->items();
      $response = "";
      
      foreach($orders as $index=>$order){
        $index = $index + 1;
        $title = "{$index}. Заказ № {$order->order_no} от {$order->created_at} \nСтатус: {$order->status_name} \n\n";
        $response = $response.$title; 
        array_push($links, [
          "text"=>"{$index}",
          "callback_data"=>json_encode(['type'=>'selOrd', 'id'=>$order->id])
        ]);             
      }
      if($paginator->hasMorePages()){
        array_push($links, [
          "text"=>">>",
          "callback_data"=>json_encode(['type'=>'paginateOrder', 'page'=>$pageNum+1])
        ]);
      }
      return (object) ['text'=>$response, 'links'=>$links];
    }
    public  function getClientOrderDetail(){
      $response = "";
      $title = "Заказ № {$this->order_no} от {$this->created_at} \nСтатус: {$this->status_name} \n\n";
      $body = "Список: \n";
      $overall_total = 0;
      foreach($this->items as $index=>$item){
        $index = $index + 1;
        $body = $body."{$index}. {$item->product->name} \n";
        $body = $body."По цене: {$item->price} \n";
        $body = $body."Количество: {$item->quantity} \n";
        $total = $item->price * $item->quantity;
        $overall_total = $overall_total + $total;
        $body = $body."Цена: {$total} \n\n";
      }
      $itog = "Итого: {$overall_total} \n\n";
      $payment_info = "Оплата:\n";
      foreach($this->payments as $index=>$payment){
        $index = $index + 1;
        $payment_type = Payment::PAYMENT_TYPES_REVERT[$payment->payment_type];
        $payment_info = $payment_info."{$index}. {$payment_type} - {$payment->amount_real} \n";
      }
      $border = "\n---------------------\n";
      $response = $response.$title.$body.$itog.$border.$payment_info; 
      
      return $response;
    }
}
// $body = "Список: \n";
        // $overall_total = 0;
        // foreach($order->items as $index=>$item){
        //   $index = $index + 1;
        //   $body = $body."{$index}. {$item->product->name} \n";
        //   $body = $body."По цене: {$item->price} \n";
        //   $body = $body."Количество: {$item->quantity} \n";
        //   $total = $item->price * $item->quantity;
        //   $overall_total = $overall_total + $total;
        //   $body = $body."Цена: {$total} \n\n";
        // }
        // $itog = "Итого: {$overall_total} \n\n";
        // $payment_info = "Оплата:\n";
        // foreach($order->payments as $index=>$payment){
        //   $index = $index + 1;
        //   $payment_type = Payment::PAYMENT_TYPES_REVERT[$payment->payment_type];
        //   $payment_info = $payment_info."{$index}. {$payment_type} - {$payment->amount_real} \n";
        // }
        // $border = " - - - - - - ";
        // $response = $response.$title.$body.$itog.$payment_info.$border; 