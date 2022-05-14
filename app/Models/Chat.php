<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    const CLIENT = 'client';
    const STAFF = 'staff';

    const CLIENT_TYPE = 0;
    const STAFF_TYPE = 1;

    public static function login($phone, $type, $chatId){
        $phone = str_replace("+998", "", $phone);

        if($type == self::CLIENT_TYPE){
            $client = Client::where('phone_number', $phone)->first();
            if(!$client){
                return false;
            }
            $chat = self::where('clientId', $client->id)->first();
            if($chat){
                $chat->delete();
            }
          
            $chat = new Chat();
            $chat->clientId = $client->id;
            $chat->chatId = $chatId;
            $chat->chat_type=$type;
            $chat->save();
            
            return true;
        }

        if($type == self::STAFF_TYPE){
            $staff = User::where('phone', $phone)->first();
            if(!$staff){
                return false;
            }
            $chat = self::where('userId', $staff->id)->first();
            if($chat){
                $chat->delete();
            }
          
            $chat = new Chat();
            $chat->userId = $staff->id;
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
        return $type == self::CLIENT_TYPE ? $chat->clientId : $chat->userId;
    }
}
