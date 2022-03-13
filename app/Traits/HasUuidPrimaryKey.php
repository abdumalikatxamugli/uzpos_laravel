<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuidPrimaryKey{
    protected static function booted()
    {
        static::creating(function ($object) {
            $object->id = (string) Str::uuid();
        });
    }
}
