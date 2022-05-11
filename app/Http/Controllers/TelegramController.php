<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Telegram\Telegram;

class TelegramController extends Controller
{
    public function __invoke(Request $request){
        Telegram::rawSend($request->all(), Telegram::CLIENT_BOT_TOKEN);
    }
}
