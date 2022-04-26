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
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->id = (string) Str::uuid();
            PointProduct::transferItem($item);
        });
        static::deleting(function ($item) {
            PointProduct::revertTranferItem($item);
        });
    }
}
