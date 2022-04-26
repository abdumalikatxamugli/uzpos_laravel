<?php

namespace App\Models;

use App\Traits\Fabricatable;

class Transfer extends UuidModel
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'uzpos_core_transfer';

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
