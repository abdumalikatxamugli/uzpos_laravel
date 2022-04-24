<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * Traits
     */
    use Fabricatable;
    /**
    * Properties
    */
    protected $table = 'uzpos_core_brand';
}
