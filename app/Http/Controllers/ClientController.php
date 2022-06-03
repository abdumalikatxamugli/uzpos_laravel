<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreRequest;
use App\Http\Validators\ClientAppendValidator;
use App\Models\Client;
use App\Models\Order;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
    public function createAndAppendtoOrder(Request $request, Order $order){
        try{
            try{
                $clientData = $this->validate_store($request);
            }catch(HttpResponseException $e){
               return $e->getResponse();
            }
            $clientData['client_no'] = Client::getClientNumber();
            $client = Client::createFromArrayWithUser($clientData, auth()->user());
            $order->client_id = $client->id;
            $order->save();
            return ['error'=>0];
        }catch(Exception $e){
            dd($e);
            return ['error'=>-1];
        }
    }
    public function __call($method, $args){
        $method = explode("_", $method)[1];
        return App::call([new ClientAppendValidator, $method]);
    }
}
