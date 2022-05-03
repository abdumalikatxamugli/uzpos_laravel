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
}
