<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    /**
     * Traits
     */
    use Fabricatable;
     /**
      * Properties
      */
    protected $table = 'divisions';
    
    /**
     * Relations
     */
    public function pointProducts(){
      return $this->hasMany(PointProduct::class, 'division_id', 'id');
    }
}
