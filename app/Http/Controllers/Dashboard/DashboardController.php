<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function main(){
        $sql = "select count(*) as order_count from uzpos_sales_order o where date(o.created_at) = date(sysdate()) and o.status=2";
        $order_count_result = DB::select($sql);
        $order_count = $order_count_result[0]->order_count;
        
        $sql = "select sum(p.amount) as total_payment from uzpos_sales_order o
                                                      join uzpos_sales_payment p on p.order_id = o.id	
                                                      where date(o.created_at) = date(sysdate()) and o.status=2";
        $payment_total_result = DB::select($sql);
        $payment_total = $payment_total_result[0]->total_payment;

        $sql = "select sum(e.amount) as total_expense from expenses e where date(e.created_at) = date(sysdate())";
        $expense_result = DB::select($sql);
        $expense_total = $expense_result[0]->total_expense;

        $sql = "select sum(p.amount) as total_debt from uzpos_sales_order o
                                                      join uzpos_sales_payment p on p.order_id = o.id	
                                                      where date(o.created_at) = date(sysdate()) and o.status=2 and p.payment_type = 4";
        $debt_total_result = DB::select($sql);
        $debt_total = $debt_total_result[0]->total_debt;

        
        return view("dashboard.main")->with('order_count', $order_count)
                                     ->with('payment_total', $payment_total)
                                     ->with('expense_total', $expense_total)
                                     ->with('debt_total', $debt_total);
    }
}
