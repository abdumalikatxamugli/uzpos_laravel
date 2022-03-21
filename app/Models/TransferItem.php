<?php

namespace App\Models;

use App\Traits\Fabricatable;

class TransferItem extends UuidModel
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'uzpos_core_transferitem';
}
