<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Support\Str;


class TransferItem extends UuidModel
{
    /**
    * Traits
    */
    use Fabricatable;
    /**
     * Properties
     */
    
    protected $table = 'uzpos_core_transferitem';
    public function product(){
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
    public function transfer(){
        return $this->belongsTo(Transfer::class,'transfer_id', 'id');
    }

    /**
     * validation helpers
     */
    public function validateStore($fail){
        $fromPointProduct = PointProduct::where([
            'product_id'=> $this->product_id,        
            'point_id'=> $this->transfer->from_point_id
        ])->first();
            
        if(!$fromPointProduct || $fromPointProduct->quantity < $this->quantity){
            $fail('Warehouse or Shop does not have enough items to complete this operation');
        }
    }
    public function validateDelete($fail){
        $toPointProduct = PointProduct::where([
            'product_id'=> $this->product_id,        
            'point_id'=> $this->transfer->to_point_id
        ])->first();
    
        if($toPointProduct->quantity < $this->quantity){
            $fail('Warehouse or shop does not have enough items to cancel the record');   
        }        
    }
}
