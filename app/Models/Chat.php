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

    public static function login($phone, $type){
        if($type == self::CLIENT){
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
            $chat->chat_type=self::CLIENT_TYPE;
            $chat->save();
            return true;
        }
    }
}
