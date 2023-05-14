<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TransferRequest extends Model
{
    protected $table = "transfer_requests";

    public function from_division()
    {
        return $this->belongsTo(Point::class, 'from_division_id', 'id');
    }
    public function to_division()
    {
        return $this->belongsTo(Point::class, 'to_division_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(TransferRequestItem::class, 'transfer_request_id', 'id');
    }

}
