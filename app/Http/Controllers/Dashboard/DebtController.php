<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Debt\RepayRequest;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Repayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DebtController extends Controller
{
    public function index(Client $client){
        
        $debts =  DB::table("payments")
            ->leftJoin("repayments", function($join){
                $join->on("repayments.payment_id", "=", "payments.id");
            })
            ->selectRaw("payments.id, payments.payment_date, payments.order_id, payments.payed_amount,  payments.payed_amount_usd, payments.payed_currency_type, sum(repayments.amount) as total_repaid")
            ->whereIn("order_id", function($query) use ($client){
                $query->from("orders")
                ->select("id")
                ->where("client_id", "=", $client->id);
            })
            ->where("payment_type", "=", Payment::DEBT)
            ->groupBy('payments.payment_date', "payments.order_id", "payments.payed_amount", "payments.payed_amount_usd", "payments.payed_currency_type", "payments.id" )
            ->orderBy("payments.id","desc")
            ->get();
        
        return view('dashboard.client.debts')
                        ->with('debts', $debts)
                        ->with('client', $client);
    }
    public function repay(RepayRequest $request, Payment $payment){
        Repayment::repay($request->input('repayment_date'), $request->input('amount'), $payment);
        return redirect()->back();
    }
    public function repay_history(Payment $payment){
        return view('dashboard.client.debt_repays')
                ->with('payment', $payment);
    }
}
