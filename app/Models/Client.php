<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
      /**
    * Traits
    */
   use Fabricatable;
   use HasFactory;
   /**
    * Properties
    */
   protected $table = 'clients';

   /**
    * constants
    */
    const FIZ = 0;
    const YUR = 1;

    const regionDict = [
      0=>'ТОШКЕНТ ШАХРИ',
      1=>'ТОШКЕНТ ВИЛОЯТИ',
      2=>'СИРДАРЁ ВИЛОЯТИ',
      3=>'ЖИЗЗАХ ВИЛОЯТИ',
      4=>'САМАРКАНД ВИЛОЯТИ',
      5=>'ФАРГОНА ВИЛОЯТИ',
      6=>'НАМАНГАН ВИЛОЯТИ',
      7=>'АНДИЖОН ВИЛОЯТИ',
      8=>'КАШКАДАРЁ ВИЛОЯТИ',
      9=>'СУРХОНДАРЁ ВИЛОЯТИ',
      10=>'БУХОРО ВИЛОЯТИ',
      11=>'НАВОИЙ ВИЛОЯТИ',
      12=>'ХОРАЗМ ВИЛОЯТИ',
      13=>'КОРАКАЛПОГИСТОН РЕСПУБЛИКАСИ'
    ];

  /**
   * Relations
   * 
   */
  public function orders(){
    return $this->hasMany(Order::class, 'client_id', 'id');
  }
  public function chat(){
    return $this->hasOne(Chat::class, 'client_id', 'id');
  }

   /**accessors */

   public function getFullNameAttribute(){
     if($this->client_type == self::FIZ){
       return "{$this->last_name} {$this->first_name} {$this->middle_name}";
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
  /**
   * custom function 
   */
  public function get_region_name(){
    if(isset($this->region)){
      return "( ".self::regionDict[$this->region]." )";
    }
    return '';
  }
}
