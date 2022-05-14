<?php
namespace App\Http\Telegram;

use App\Models\CollectionRequest;
use App\Models\DeliveryRequest;
use App\Models\Order;

/**
 * Telegram bot
 */
class Telegram{
    const DELIVERY_BOT_TOKEN = "5293459791:AAEIhRM-Uxeb2EkaFA9tBExHOUaBL2BSxNk";
    const COLLECTOR_BOT_TOKEN = "5275506918:AAEX-n1upwQ7jKOTpaUFHJOR3dmYKw-cLc0";
    const CLIENT_BOT_TOKEN  = "5128636617:AAH_2sxJx1sZcxYPO1oaOHAs1drlvfAjRfk";

    const CLIENT = 'client';
    const COLLECTOR = 'collector';
    const DELIVERY = 'delivery';

    const STEP_START = 0;
    const STEP_AUTH = 1;
    const STEP_ORDERS = 2;
    const STEP_ORDER_DETAIL = 3;
    const STEP_ORDERS_NEXT = 4;
    const STEP_GET_MY_TASKS = 5;
    const STEP_I_FINISH_COLLECTION = 6;
    const STEP_I_FINISH_DELIVERY = 7;

    public $data;
    public $chatId;
    public $token;

    public static function rawSend($data=[], $token, $method = "sendMessage"){

        $url = "https://api.telegram.org/bot{$token}/{$method}";
        $ch = curl_init($url);
        $payload = json_encode( $data );
        $headers =  [
            "Content-Type: application/json; charset=UTF-8"
        ];
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
    }
    private function sendMessage($data=[], $method = "sendMessage"){
        $token = $this->token;
        $url = "https://api.telegram.org/bot{$token}/{$method}";
        $ch = curl_init($url);
        $payload = json_encode( $data );
        $headers =  [
            "Content-Type: application/json; charset=UTF-8"
        ];
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
    }
    public static function getStep($request){
        $data = $request->all();
        if(isset($data['message']['text']) && $data['message']['text']=='/start'){
            return self::STEP_START;
        }
        if(isset($data['message']['contact'])){
            return self::STEP_AUTH;
        }
        if(isset($data['message']['text']) && $data['message']['text']=='мои заказы'){
            return self::STEP_ORDERS;
        }
        if(isset($data['callback_query']) && isset($data['callback_query']['data'])){
            if(json_decode($data['callback_query']['data'])->type == 'paginateOrder'){
                return self::STEP_ORDERS_NEXT;
            }
            if(json_decode($data['callback_query']['data'])->type == 'selOrd'){
                return self::STEP_ORDER_DETAIL;
            }
            if(json_decode($data['callback_query']['data'])->type == 'finishOrderCollector'){
                return self::STEP_I_FINISH_COLLECTION;
            }
            if(json_decode($data['callback_query']['data'])->type == 'finishOrderDelivery'){
                return self::STEP_I_FINISH_DELIVERY;
            }
        }
        if(isset($data['message']['text']) && $data['message']['text']=='мои задачи'){
            return self::STEP_GET_MY_TASKS;
        }
    }
    public static function getChatId($request){
        $data = $request->all();
        if(isset($data['message'])){
            return $data['message']['chat']['id']; 
        }
        if(isset($data['callback_query'])){
            return $data['callback_query']['message']['chat']['id']; 
        }
        
    }
    public function start(){
        $message = [
            'text'=>"Здравствуйте, авторизируйтесь пожалуйста",
            'chat_id'=>$this->chatId,
            "reply_markup"=>[
                "resize_keyboard"=>true,
                "keyboard"=>[
                    [
                        [
                            "text"=>"авторизоваться",
                            "request_contact"=>true
                        ]
                    ]
                ]
            ]
        ];
        $this->rawSend($message, $this->token);
    }
    public function getPhone(){
        return $this->data['message']['contact']['phone_number'];
    }
    public function isOwnPhone(){
        if($this->data['message']['chat']['id'] != $this->data['message']['contact']['user_id']){
            $message = [
                'text'=>"Авторизация не удалась. Поделитесь, пожалуйста, своим номером.",
                'chat_id'=>$this->chatId
            ];
            $this->sendMessage($message);
            return false;
        }
        return true;
    }
    public function unauthorized_error(){
         $message = [
            'text'=>"Вы не авторизованы.",
            'chat_id'=>$this->chatId,
            "reply_markup"=>[
                "resize_keyboard"=>true,
                "keyboard"=>[
                    [
                        [
                            "text"=>"authorize",
                            "request_contact"=>true
                        ]
                    ]
                ]
            ]
        ];
        $this->rawSend($message, $this->token);
    }
    public function send_orders_step(){
        $message = [
            'text'=>"Авторизация прошла успешно.",
            'chat_id'=>$this->chatId,
            "reply_markup"=>[
                "resize_keyboard"=>true,
                "keyboard"=>[
                    [
                        [
                            "text"=>"мои заказы"
                        ]
                    ]
                ]
            ]
        ];
        $this->rawSend($message, $this->token);
    }
    public function send_orders(){
        $pageNum = 1;
        if($this->step == self::STEP_ORDERS_NEXT){
            $pageNum = json_decode($this->data['callback_query']['data'])->page;
        }
        $orders = Order::getClientOrders($this->clientId, $pageNum);
        $message = [
            'text'=>$orders->text,
            'chat_id'=>$this->chatId,
            'reply_markup'=>[
                'inline_keyboard'=>[
                    $orders->links
                ]
            ]
        ];
        $this->sendMessage($message); 
        $this->answerCallbackQuery();
    }
    public function send_order_details(){
        $orderId = json_decode($this->data['callback_query']['data'])->id;
        $order = Order::where('id', $orderId)->first();
        $text = $order->getClientOrderDetail();
        $message = [
            'text'=>$text,
            'chat_id'=>$this->chatId
        ];
        $this->sendMessage($message); 
    }
    public function answerCallbackQuery(){
        if(isset($this->data['callback_query'])){
            $message = [
                'callback_query_id'=>$this->data['callback_query']['id']
            ];
            $this->sendMessage($message, 'answerCallbackQuery');
        }
        
    }


    /**
     * 
     * Collector and Delivery
     */
    public function send_get_my_tasks(){
        $message = [
            'text'=>"Авторизация прошла успешно.",
            'chat_id'=>$this->chatId,
            "reply_markup"=>[
                "resize_keyboard"=>true,
                "keyboard"=>[
                    [
                        [
                            "text"=>"мои задачи"
                        ]
                    ]
                ]
            ]
        ];
        $this->rawSend($message, $this->token);
    }
    public function send_my_tasks(){
        $order = Order::getTasksOrder($this->staffId);
        if($order->links){
            $message = [
                'text'=>$order->text,
                'chat_id'=>$this->chatId,
                'reply_markup'=>[
                    'inline_keyboard'=>[
                        $order->links
                    ]
                ]
            ];
        }else{
            $message = [
                'text'=>$order->text,
                'chat_id'=>$this->chatId
            ];
        }
        // dd($message);
        $this->rawSend($message, $this->token);
    }
    public function finishCollection(){
        $collectionRequestId = json_decode($this->data['callback_query']['data'])->cNo;
        $collectionRequest = CollectionRequest::where('id', $collectionRequestId)->first();
        $collectionRequest->finish();
        $message = [
            'text'=>'Хорошо',
            'chat_id'=>$this->chatId
        ];
        $this->sendMessage($message); 
        $this->answerCallbackQuery();
    }
    public function finishDelivery(){
        $deliveryRequestId = json_decode($this->data['callback_query']['data'])->dNo;
        $deliveryRequest = DeliveryRequest::where('id', $deliveryRequestId)->first();
        $deliveryRequest->finish();
        $message = [
            'text'=>'Хорошо',
            'chat_id'=>$this->chatId
        ];
        $this->sendMessage($message); 
        $this->answerCallbackQuery();
    }    
}