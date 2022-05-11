<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Telegram\Telegram;
use App\Models\Chat;
use App\Models\User;

class TelegramController extends Controller
{
    public function __invoke(Request $request){
        $message = [
            'chat_id'=>979219375,
            'text'=>$request->botname."\n".json_encode($request->all(), JSON_PRETTY_PRINT)
        ];
        Telegram::rawSend($message, Telegram::CLIENT_BOT_TOKEN);

        switch($request->botname){
            case Telegram::CLIENT:
                return $this->clientIndex($request);
            default:
                return [];
        }
    }
    public function clientIndex(Request $request){
        $step = Telegram::getStep($request);
        $telegram = new Telegram();
        $telegram->token = Telegram::CLIENT_BOT_TOKEN;
        $telegram->chatId = Telegram::getChatId($request);
        $telegram->data = $request->all();
                

        if($step == Telegram::STEP_START){
            $telegram->start();            
        }
        if($step == Telegram::STEP_AUTH && $telegram->isOwnPhone()){
            Chat::login($telegram->getPhone(), Chat::CLIENT);            
        }
    } 
}
