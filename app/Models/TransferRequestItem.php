<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferRequestItem extends Model
{
    protected $table = "transfer_request_items";

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
