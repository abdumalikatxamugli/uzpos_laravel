<?php

namespace App\Models;

use App\Traits\Fabricatable;

class Point extends UuidModel
{
    /**
     * Traits
     */
    use Fabricatable;
     /**
      * Properties
      */
    protected $table = 'uzpos_core_point';
    
    /**
     * Relations
     */
    public function pointProducts(){
      return $this->hasMany(PointProduct::class, 'point_id', 'id');
    }
}
