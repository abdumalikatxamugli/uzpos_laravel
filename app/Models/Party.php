<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
   /**
     * Settings
     */
    protected $table = 'party';
    /**
    * Traits
    */
    use Fabricatable;
    /**
     * Properties
     */
    /**
     * events
     */
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->id = (string) Str::uuid();
        });       

        static::updating(function($party){
          if($party->status == 2 && $party->getOriginal('status')==1){
            PointProduct::addItemByParty($party);
          }
          if($party->status == 3 && $party->getOriginal('status')==2){
            PointProduct::removeItemByParty($party);
          }
        });
    }

    /**
     * Relations
     */
    public function items(){
      return $this->hasMany(Item::class,'party_id', 'id');
    }
    public function point(){
      return $this->belongsTo(Point::class, 'point_id', 'id');
    }

    /**
     * accessors
     * 
     */
    public function getStatusNameAttribute(){
      switch($this->status){
        case 1: return 'Черновек';
        case 2: return 'Завершен';
        default: return 'Не понятно';
      }
    }

    /**
     * custom
     */
    public function finishParty(){
      $this->status = 2;
      $this->save();
    }
    public function finishParty2(){
      PointProduct::addItemByParty($this, true);
    }
}

