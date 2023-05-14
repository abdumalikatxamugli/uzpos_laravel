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
    const STOREHOUSE = 1;
    const SHOP = 2;
    public function getDivisionTypeAttribute()
    {
      switch($this->point_type)
      {
        case self::STOREHOUSE:
          return 'Склад';
        case self::SHOP:
          return 'Магазин';
      }
    }
    /**
     * Relations
     */
    public function pointProducts(){
      return $this->hasMany(PointProduct::class, 'division_id', 'id');
    }
}
