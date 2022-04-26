<?php

namespace App\Models;

use App\Traits\Fabricatable;

class Party extends UuidModel
{
    /**
    * Traits
    */
    use Fabricatable;
    /**
     * Properties
     */
    protected $table = 'uzpos_core_party';

    /**
     * Relations
     */
    public function items(){
      return $this->hasMany(Item::class,'party_id', 'id');
    }
    public function point(){
      return $this->belongsTo(Point::class, 'point_id', 'id');
    }

}

