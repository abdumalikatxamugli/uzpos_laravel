<?php
namespace App\Models;

use App\Traits\HasUuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class UuidModel extends Model{
    /**
     * Settings
     */
    public $incrementing = false;
    protected $keyType = 'string';
    /**
     *
     * Traits
     */
    use HasUuidPrimaryKey;
}
