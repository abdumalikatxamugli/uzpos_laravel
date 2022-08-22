<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;

class CollectionRequest extends Model
{
    use Fabricatable;

    protected $table = "uzpos_collectionrequest";

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
        return "{$status} : {$this->assigned_full_name}";
    }
    public function getAssignedFullNameAttribute(){
        return $this->assigned?$this->assigned_full_name:'';
    }

    /**
     * 
     * custom function
     */

     public function finish(){
         $this->status = 0;
         $this->save();
         $collector = $this->assigned;
         $collector->busy = 0;
         $collector->save();
     }
    
}
