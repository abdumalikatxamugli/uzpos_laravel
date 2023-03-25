<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transfer extends Model
{
   /**
     * Settings
     */
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'transfers';

   /**
    * events
    */

    protected static function booted()
    {
        static::updating(function($transfer){
          if($transfer->status == 2 && $transfer->getOriginal('status')==1){
            PointProduct::transferItemBulk($transfer);
          }
          if($transfer->status == 3 && $transfer->getOriginal('status')==2){
            PointProduct::revertTranferItemBulk($transfer);
          }
        });
    }
  public function items(){
    return $this->hasMany(TransferItem::class,'transfer_id', 'id');
  }
  /**
   * 
   * Relations
   */
  public function from_point(){
    return $this->belongsTo(Point::class, 'from_division_id', 'id');
  }
  
  public function to_point(){
    return $this->belongsTo(Point::class, 'to_division_id', 'id');
  }
  /**
   * accessors
   * 
   */
  public function getStatusNameAttribute(){
    switch($this->status){
      case 1: return 'Черновек';
      case 2: return 'Завершен';
      default: return 'Не понятно';
    }
  }
  /**
   * custom functions
   */
  public function finishTransfer(){
    $this->status = 2;
    $this->save();
  }
  /**
   * create transfer from order for the fullmatch shop
   */
  public static function createFromOrder($order, $point){
    $transfer = new self();
    $transfer->transfer_date = date('Y-m-d');
    $transfer->status = 1;
    $transfer->from_point_id = $point->id;
    $transfer->to_point_id = $order->shop_id;
    $transfer->created_by_id = auth()->user()->id;
    $transfer->reason = "Для заказа {$order->order_no}";
    $transfer->save();
    foreach($order->items as $item){
      $transfer_item = new TransferItem();
      $transfer_item->quantity = $item->quantity;
      $transfer_item->product_id = $item->product_id;
      $transfer_item->transfer_id = $transfer->id;
      $transfer_item->created_by_id = auth()->user()->id;
      $transfer_item->save();
    }
  }
  public static function createFromOrderPartial($order, $point, $items){
    $transfer = new self();
    $transfer->transfer_date = date('Y-m-d');
    $transfer->status = 1;
    $transfer->from_point_id = $point->id;
    $transfer->to_point_id = $order->shop_id;
    $transfer->created_by_id = auth()->user()->id;
    $transfer->reason = "Для заказа {$order->order_no}";
    $transfer->save();
    foreach($items as $item){
      $transfer_item = new TransferItem();
      $transfer_item->quantity = $item->quantity;
      $transfer_item->product_id = $item->product_id;
      $transfer_item->transfer_id = $transfer->id;
      $transfer_item->created_by_id = auth()->user()->id;
      $transfer_item->save();
    }
  }
}
