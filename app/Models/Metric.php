<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
     /**
     * Traits
     */
    use Fabricatable;
     /**
      * Properties
      */
    protected $table = 'metrics';
}
