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
        Telegram::rawSend($message, Telegram::COLLECTOR_BOT_TOKEN);

        switch($request->botname){
            case Telegram::CLIENT:
                return $this->clientIndex($request);
            case Telegram::COLLECTOR:
                return $this->collectorIndex($request);
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
        $telegram->step = $step;
       
       

        if($step == Telegram::STEP_START){
            $telegram->start();  
            return;          
        }
        if($step == Telegram::STEP_AUTH && $telegram->isOwnPhone()){
            if(Chat::login($telegram->getPhone(), Chat::CLIENT_TYPE, $telegram->chatId)){
                $telegram->send_orders_step();
            }else{
                $telegram->unauthorized_error();
            }  
            return;         
        }
        $telegram->clientId = Chat::auth($telegram->chatId, Chat::CLIENT_TYPE);
        if(!$telegram->clientId){
            $telegram->unauthorized_error();
            return;
        }
        if($step == Telegram::STEP_ORDERS){
            $telegram->send_orders();
            return;
        }
        if($step == Telegram::STEP_ORDERS_NEXT){
            $telegram->send_orders();
            return;
        }
        if($step == Telegram::STEP_ORDER_DETAIL){
            $telegram->send_order_details();
            return;
        }
    } 
    public function collectorIndex(Request $request){
        $step = Telegram::getStep($request);
        $telegram = new Telegram();
        $telegram->token = Telegram::COLLECTOR_BOT_TOKEN;
        $telegram->chatId = Telegram::getChatId($request);
        $telegram->data = $request->all();
        $telegram->step = $step;

        if($step == Telegram::STEP_START){
            $telegram->start();  
            return;          
        }
        if($step == Telegram::STEP_AUTH && $telegram->isOwnPhone()){
            if(Chat::login($telegram->getPhone(), Chat::STAFF_TYPE, $telegram->chatId)){
                $telegram->send_get_my_tasks();
            }else{
                $telegram->unauthorized_error();
            }  
            return;         
        }
    }
}
