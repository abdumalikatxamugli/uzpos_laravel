<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Support\Str;

class Item extends UuidModel
{
    /**
    * Traits
    */
    use Fabricatable;
    /**
    * Properties
    */
    protected $table = 'uzpos_core_item';

    public function product(){
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
    public function party(){
        return $this->belongsTo(Party::class,'party_id', 'id');
    }
    protected static function booted()
    {
        static::creating(function ($object) {
            $object->id = (string) Str::uuid();
        });
        static::created(function ($item) {
            PointProduct::addItem($item);
        });
        static::deleting(function ($item) {
            PointProduct::removeItem($item);
        });
    }
}
