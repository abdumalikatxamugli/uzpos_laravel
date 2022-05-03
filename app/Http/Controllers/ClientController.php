<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreRequest;
use App\Models\Client;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * list clients
     */
    public function select(Request $request, Order $order){
        if(!empty( $request->query('attribute')) ){
            $clients = Client::where($request->query('attribute'), 'like', '%'.$request->query('value').'%')->paginate(5);
        }else{
            $clients = Client::paginate(5);
        }
        return view('dashboard.clients.select')
                    ->with('clients', $clients)
                    ->with('order', $order);
    }
    /**
     * Append client to order
     * 
     */
    public function appendToOrder(Order $order, Client $client){
        try{
            $order->client_id = $client->id;
            $order->save();
            return ['error'=>0];
        }catch(Exception $e){
            dd($e);
            return ['error'=>-1];
        }
    }
    /**
     * Create client and append to order
     */
    public function createAndAppendtoOrder(StoreRequest $request, Order $order){
        try{
            $clientData = $request->validated();
            $clientData['client_no'] = Client::getClientNumber();
            $client = Client::createFromArrayWithUser($clientData, auth()->user());
            $order->client_id = $client->id;
            $order->save();
            return ['error'=>0];
        }catch(Exception $e){
            return ['error'=>-1];
        }
    }
}
