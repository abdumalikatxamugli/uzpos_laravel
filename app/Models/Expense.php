<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * traits
     */
    use Fabricatable;
    /**
     * props
     */
    protected $table = 'expenses';

    /**
     * relations
     */
    public function staff(){
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }
    public function division(){
        return $this->belongsTo(Point::class, 'division_id', 'id');
    }
}
