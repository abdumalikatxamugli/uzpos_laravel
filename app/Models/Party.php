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
}

