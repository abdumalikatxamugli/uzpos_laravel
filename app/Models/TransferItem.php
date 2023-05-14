<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;


class TransferItem extends Model
{
    /**
    * Traits
    */
    use Fabricatable;
    /**
     * Properties
     */
    
    protected $table = 'transferitems';
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
            'division_id'=> $this->transfer->from_division_id
        ])->first();
            
        if(!$fromPointProduct || $fromPointProduct->quantity < $this->quantity){
            $fail('У подразделения недостаточно товаров для выполнения этой операции.');
        }
    }
    public function validateDelete($fail){
        $toPointProduct = PointProduct::where([
            'product_id'=> $this->product_id,        
            'division_id'=> $this->transfer->to_point_id
        ])->first();
    
        if($toPointProduct->quantity < $this->quantity){
            $fail('Warehouse or shop does not have enough items to cancel the record');   
        }        
    }
}
