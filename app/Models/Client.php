<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Client extends UuidModel
{
      /**
    * Traits
    */
   use Fabricatable;
   use HasFactory;
   /**
    * Properties
    */
   protected $table = 'uzpos_sales_client';

   /**
    * constants
    */
    const FIZ = 0;
    const YUR = 1;

  /**
   * Relations
   * 
   */
  public function orders(){
    return $this->hasMany(Order::class, 'client_id', 'id');
  }

   /**accessors */

   public function getFullNameAttribute(){
     if($this->client_type == self::FIZ){
       return "{$this->lname} {$this->fname} {$this->mname}";
     }else{
       return "{$this->company_name}";
     }
   }
   public function getClientTypeNameAttribute(){
     if($this->client_type == self::FIZ){
       return 'Физическое лицо';
     }else{
       return 'Юридическое лицо';
     }
   }
   public function getClientCredentials(){
      if($this->client_type == self::FIZ){
        return view('partials.client.fizCredentials')->with('client', $this);
      }else{
        return view('partials.client.yurCredentials')->with('client', $this);
      }
   }
   public static function getClientNumber(){
    $last_client = self::latest()->first();
    if($last_client){
      return $last_client->client_no+1;
    }else{
      return 1;
    }
 }
}
