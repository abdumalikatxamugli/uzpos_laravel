<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;

class DeliveryRequest extends Model
{
    use Fabricatable;

    protected $table = "uzpos_sales_deliveryrequest";

    /**
     * 
     * Relations
     */

     public function assigned(){
         return $this->belongsTo(User::class, 'assigned_id','id');
     }
     public function order(){
         return $this->belongsTo(Order::class, 'order_id', 'id');
     }

    /**
     * 
     * accessors
     */
    public function getStatusTextAttribute(){
        $status = $this->status == 1 ? 'Актив':'Завершен';
        return "{$status} : {$this->assigned->full_name}";
    }
}