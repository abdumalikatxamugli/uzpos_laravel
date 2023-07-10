<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    const CLIENT = 'client';
    const COLLECTOR = 'collector';
    const DELIVER = 'deliver';

    const CLIENT_TYPE = 0;
    const COLLECTOR_TYPE = 1;
    const DELIVER_TYPE = 2;

    public static function login($phone, $type, $chatId){
        if(strlen($phone)==12){
            $phone = substr($phone, 3);
        }
        $phone = str_replace("+998", "", $phone);

        if($type == self::CLIENT_TYPE){
            $client = Client::where('phone_number', $phone)->first();
            if(!$client){
                return false;
            }
            $chat = self::where('client_id', $client->id)->first();
            if($chat){
                $chat->delete();
            }
          
            $chat = new Chat();
            $chat->client_id = $client->id;
            $chat->chatId = $chatId;
            $chat->chat_type=$type;
            $chat->save();
            
            return true;
        }

        if($type == self::COLLECTOR_TYPE){
            $staff = User::where('phone', $phone)->where('user_role', User::roles['COLLECTOR'])->first();
            if(!$staff){
                return false;
            }
            $chat = self::where('user_id', $staff->id)->first();
            if($chat){
                $chat->delete();
            }
          
            $chat = new Chat();
            $chat->user_id = $staff->id;
            $chat->chatId = $chatId;
            $chat->chat_type=$type;
            $chat->save();
            
            return true;
        }
        if($type == self::DELIVER_TYPE){
            $staff = User::where('phone', $phone)->where('user_role', User::roles['DELIVERY'])->first();
            if(!$staff){
                return false;
            }
            $chat = self::where('user_id', $staff->id)->first();
            if($chat){
                $chat->delete();
            }
          
            $chat = new Chat();
            $chat->user_id = $staff->id;
            $chat->chatId = $chatId;
            $chat->chat_type=$type;
            $chat->save();
            
            return true;
        }

        return false;
    }
    public static function auth($chatId, $type){
        $chat = self::where(['chatId'=>$chatId, 'chat_type'=>$type])->first();
        if(!$chat){
            return false;
        }
        return $type == self::CLIENT_TYPE ? $chat->client_id : $chat->user_id;
    }
}
