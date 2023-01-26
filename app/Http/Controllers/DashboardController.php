<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function main(){
        $sql = "select p.name, sum(oi.quantity)  as q
        from uzpos_core_product p 
        join uzpos_sales_orderitem oi on oi.product_id = p.id
        join uzpos_sales_order o on o.id = oi.order_id
        
        where o.status=2
        group by p.name
        order by sum(oi.quantity)  desc
        limit 1;";
        $most_sold = DB::select($sql);
        $most_sold_product_name = "-";
        $most_sold_product_count = "-";
        if(count($most_sold) == 1)
        {
            $most_sold_product_name = $most_sold[0]->name;
            $most_sold_product_count = $most_sold[0]->q;
        }
        return view("dashboard.main")->with('most_sold_product_name', $most_sold_product_name)
                                     ->with('most_sold_product_count', $most_sold_product_count);
    }
}
