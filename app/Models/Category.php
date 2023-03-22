<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Traits
     * 
     */
    use Fabricatable;
    /**
    * Properties
    */
    protected $table = 'category';
}
