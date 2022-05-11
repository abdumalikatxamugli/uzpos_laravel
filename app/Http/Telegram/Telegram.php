<?php
namespace App\Http\Telegram;

/**
 * Telegram bot
 */
class Telegram{
    const DELIVERY_BOT_TOKEN = "5293459791:AAEIhRM-Uxeb2EkaFA9tBExHOUaBL2BSxNk";
    const COLLECTOR_BOT_TOKEN = "5275506918:AAEX-n1upwQ7jKOTpaUFHJOR3dmYKw-cLc0";
    const CLIENT_BOT_TOKEN  = "5128636617:AAH_2sxJx1sZcxYPO1oaOHAs1drlvfAjRfk";


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

        curl_close($ch);
    }

}