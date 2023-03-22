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
    protected $table = 'orders';

   /**
    * events 
    */
    protected static function booted()
    {
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
    public function collectionRequest(){
      return $this->hasOne(CollectionRequest::class, 'order_id', 'id');
    }    
    public function deliveryRequest(){
      return $this->hasOne(DeliveryRequest::class, 'order_id', 'id');
    }
    public function division(){
      return $this->belongsTo(Point::class, 'shop_id', 'id');
    }
    public function from_point(){
      return $this->belongsTo(Point::class, 'from_point_id', 'id');
    }
    /**
     * 
     * constants
     */

    const DRAFT = 1;
    const CONFIRMED = 2;
    const BROKEN = 3;

    const BULKY_TYPE = 1;
    const RETAIL_TYPE = 2;

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
     
     public function getOrderTypeNameAttribute(){
       return $this->order_type == self::RETAIL_TYPE ? 'Розничный' : 'Оптовый';
     }
    /**
     * custom functions
     */
    public static function getStatusText($status){
      switch($status){
       case 1:
         return 'ЧЕРНОВЕК';
       case 2:
         return 'ПОДВЕРЖДЕН';
       case 3:
         return 'БРАК';
      }
    }
    public function getClientFullName(){
      if($this->client){
        return $this->client->fullName;
      }else{
        return '';
      }
    }
    public function getTotalItemCount(){
      $quantity = $this->items->sum('quantity');
      return $quantity;
    }
    public function getTotalCost(){
      $cost = $this->items->sum(function($t){
        return $t->price * $t->quantity;
      });
      return $cost;
    }
    public function getTotalPaid(){
      $paid = $this->payments->sum('amount_real');
      return $paid;
    }

    public function getTotalPaidByCurrencyType($type){
      $paid = $this->payments->where('currency', $type)->sum('amount_real');
      return $paid;
    }
    public function getTotalPaidBySoums($type){
      $paid = $this->payments->where('currency', $type)->sum('amount');
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
      $paid = $this->getTotalPaid();
      
      if((string) $shouldBePaid <= (string) $paid){
        return true;
      }
      return false;
    }
    public function hasEnoughItems(){
      foreach($this->items as $item){
        $quantityToSubtract = $item->quantity;
        $quantityAvailable = PointProduct::getAvailableAmount($item->product_id, $this->from_point_id);
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
        $perPage = 5, $columns = ['*'], $pageName = 'orders', $pageNum
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

    public  function getCollectorOrderDetail(){
      $response = "";
      $title = "Заказ № {$this->order_no} от {$this->created_at} \nСтатус: {$this->status_name} \n\n";
      $body = "Список: \n";
      foreach($this->items as $index=>$item){
        $index = $index + 1;
        $body = $body."{$index}. {$item->product->name} \n";
        $body = $body."Количество: {$item->quantity} \n";
      }
      $response = $response.$title.$body; 
      
      return $response;
    }

    public  function getDeliveryOrderDetail(){
      $response = "";
      $title = "Заказ № {$this->order_no} от {$this->created_at} \nСтатус: {$this->status_name} \n\n";
      $body = "Список: \n";
      foreach($this->items as $index=>$item){
        $index = $index + 1;
        $body = $body."{$index}. {$item->product->name} \n";
        $body = $body."Количество: {$item->quantity} \n";
      }
      $address = "";
      if($this->deliveryRequest){
        $address = "\nАдрес: {$this->deliveryRequest->to_address} \n";
      }
      $phone = "";
      if($this->client){
        $phone = "Телефон: {$this->client->phone_number} \n";
      }
      
      $response = $response.$title.$body.$address.$phone; 
      
      return $response;
    }

    public static function getTasksOrder($staff_id){
      $staff = User::where('id', $staff_id)->first();
      if($staff->user_role == User::roles['COLLECTOR']){
        $task = CollectionRequest::where('assigned_id', $staff_id)->where('status', 1)->first();
        if(!$task){
          return (object) ['text'=>'У вас пока нету задач', 'links'=>null];
        }
        $links = [
          [
            "text"=>"Я закончил",
            "callback_data"=>json_encode(['type'=>'finishOrderCollector', 'cNo'=>$task->id])
          ]
        ];
        return (object) ['text'=>$task->order->getCollectorOrderDetail(), 'links'=>$links];
      }
      if($staff->user_role == User::roles['DELIVERY']){
        $task = DeliveryRequest::where('assigned_id', $staff_id)->where('status', 1)->first();
        if(!$task){
          return (object) ['text'=>'У вас пока нету задач', 'links'=>null];
        }
        $links = [
          [
            "text"=>"Я закончил",
            "callback_data"=>json_encode(['type'=>'finishOrderDelivery', 'dNo'=>$task->id])
          ]
        ];
        return (object) ['text'=>$task->order->getDeliveryOrderDetail(), 'links'=>$links];
      }

      
    }
}
