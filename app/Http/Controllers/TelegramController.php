<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Telegram\Telegram;

class TelegramController extends Controller
{
    public function __invoke(Request $request){
        $message = [
            'chat_id'=>979219375,
            'text'=>json_encode($request->all(), JSON_PRETTY_PRINT)
        ];
        Telegram::rawSend($message, Telegram::CLIENT_BOT_TOKEN);
    }
}
