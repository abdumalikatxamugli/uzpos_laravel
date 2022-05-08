<?php

namespace App\Http\Controllers;

use App\Http\Requests\Debt\RepayRequest;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Repayment;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    public function index(Client $client){
        
        $debts =  DB::table("uzpos_sales_payment")
            ->leftJoin("repayments", function($join){
                $join->on("repayments.payment_id", "=", "uzpos_sales_payment.id");
            })
            ->selectRaw("uzpos_sales_payment.id, uzpos_sales_payment.payment_date, uzpos_sales_payment.order_id, uzpos_sales_payment.amount, sum(repayments.amount) as total_repaid")
            ->whereIn("order_id", function($query) use ($client){
                $query->from("uzpos_sales_order")
                ->select("id")
                ->where("client_id", "=", $client->id);
            })
            ->where("payment_type", "=", Payment::DEBT)
            ->groupBy('uzpos_sales_payment.payment_date', "uzpos_sales_payment.order_id", "uzpos_sales_payment.amount", "uzpos_sales_payment.id" )
            ->orderBy("uzpos_sales_payment.id","desc")
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
