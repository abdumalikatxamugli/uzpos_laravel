<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transfer extends Model
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'uzpos_core_transfer';

   /**
    * events
    */

    protected static function booted()
    {
        // static::creating(function ($item) {
        //     $item->id = (string) Str::uuid();
        //     PointProduct::transferItem($item);
        // });
        // static::deleting(function ($item) {
        //     PointProduct::revertTranferItem($item);
        // });

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
    return $this->belongsTo(Point::class, 'from_point_id', 'id');
  }
  
  public function to_point(){
    return $this->belongsTo(Point::class, 'to_point_id', 'id');
  }
}
