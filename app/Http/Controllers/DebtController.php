<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    public function index(Client $client){
        $debts = DB::table("uzpos_sales_payment")
        ->select("*")
        ->whereIn("order_id", function($query) use ($client){
            $query->from("uzpos_sales_order")
            ->select("id")
            ->where("client_id", "=", $client->id);
        })
        ->where("payment_type", "=", Payment::DEBT)
        ->orderBy("id","desc")
        ->get();
        return view('dashboard.client.debts')
                        ->with('debts', $debts)
                        ->with('client', $client);
    }
}
