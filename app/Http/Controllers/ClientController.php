<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;

class ClientController extends Controller
{
    /**
     * Append client to order
     * 
     */
    public function appendToOrder(Order $order, Client $client){
        $order->client_id = $client->id;
        $order->save();
        return view('dashboard.client.finishAppend');
    }
}
