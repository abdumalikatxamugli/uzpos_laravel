<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use App\Models\PointProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportContoller extends Controller
{
    public function goodsReport(Request $request){
        $point_id = $request->query('point_id');
        $category_id = $request->query('category_id');
        $brand_id = $request->query('brand_id');
        $exists = 1;
        $run = $request->query('run');
        
        if ($run == 1) {
            $result = DB::table("uzpos_core_pointproduct AS pp")
            ->join("uzpos_core_point AS point", function ($join) {
                $join->on("pp.point_id", "=", "point.id");
            })
            ->join("uzpos_core_product AS product", function ($join) {
                $join->on("product.id", "=", "pp.product_id");
            })
            ->leftJoin("uzpos_core_category AS category", function ($join) {
                $join->on("category.id", "=", "product.category_id");
            })
            ->leftJoin("uzpos_core_brand AS brand", function ($join) {
                $join->on("brand.id", "=", "product.brand_id");
            })
            ->select("point.name as point_name", "product.name as product_name", "pp.quantity as quantity", "category.name as category_name", "brand.name as brand_name");
            
            if ($point_id!=0) {
                $result = $result->where("pp.point_id", "=", $point_id);
            }
            if ($category_id!=0) {
                $result = $result->where("product.category_id", "=", $category_id);
            }
            if ($brand_id!=0) {
                $result = $result->where("product.brand_id", "=", $brand_id);
            }
            if ($exists!=0) {
                $result = $result->where("pp.quantity", "<>", 0);
            } else {
                $result = $result->where("pp.quantity", "=", 0);
            }
            $result = $result->orderBy("pp.point_id", "desc")->get();
        }else{
            $result = [];
        }

        $is_admin = auth()->user()->user_role == User::roles['ADMIN'];
        return view('dashboard.reports.goods')->with('result', $result)
                                            ->with('current_point_id', $point_id)
                                            ->with('current_category_id', $category_id)
                                            ->with('current_brand_id', $brand_id)
                                            ->with('exists', $exists)
                                            ->with('is_admin', $is_admin);
    }
    public function runout(Request $request){
        $point_id = $request->query('point_id');
        $category_id = $request->query('category_id');
        $brand_id = $request->query('brand_id');
        $exists = 0;
        $run = $request->query('run');
        
        if ($run == 1) {
            $result = DB::table("uzpos_core_pointproduct AS pp")
            ->join("uzpos_core_point AS point", function ($join) {
                $join->on("pp.point_id", "=", "point.id");
            })
            ->join("uzpos_core_product AS product", function ($join) {
                $join->on("product.id", "=", "pp.product_id");
            })
            ->leftJoin("uzpos_core_category AS category", function ($join) {
                $join->on("category.id", "=", "product.category_id");
            })
            ->leftJoin("uzpos_core_brand AS brand", function ($join) {
                $join->on("brand.id", "=", "product.brand_id");
            })
            ->select("point.name as point_name", "product.name as product_name", "pp.quantity as quantity", "category.name as category_name", "brand.name as brand_name");
            
            if ($point_id!=0) {
                $result = $result->where("pp.point_id", "=", $point_id);
            }
            if ($category_id!=0) {
                $result = $result->where("product.category_id", "=", $category_id);
            }
            if ($brand_id!=0) {
                $result = $result->where("product.brand_id", "=", $brand_id);
            }
            if ($exists!=0) {
                $result = $result->where("pp.quantity", "<>", 0);
            } else {
                $result = $result->where("pp.quantity", "=", 0);
            }
            $result = $result->orderBy("pp.point_id", "desc")->get();
        }else{
            $result = [];
        }

        $is_admin = auth()->user()->user_role == User::roles['ADMIN'];
        return view('dashboard.reports.runout')->with('result', $result)
                                            ->with('current_point_id', $point_id)
                                            ->with('current_category_id', $category_id)
                                            ->with('current_brand_id', $brand_id)
                                            ->with('exists', $exists)
                                            ->with('is_admin', $is_admin);
    }
    public function goodsByDivision(Request $request){
        $point_id = $request->query('point_id');
        $category_id = $request->query('category_id');
        $brand_id = $request->query('brand_id');
        $exists = 1;
        $run = $request->query('run');
        
        if ($run == 1) {
            $result = DB::table("uzpos_core_pointproduct AS pp")
            ->join("uzpos_core_point AS point", function ($join) {
                $join->on("pp.point_id", "=", "point.id");
            })
            ->join("uzpos_core_product AS product", function ($join) {
                $join->on("product.id", "=", "pp.product_id");
            })
            ->leftJoin("uzpos_core_category AS category", function ($join) {
                $join->on("category.id", "=", "product.category_id");
            })
            ->leftJoin("uzpos_core_brand AS brand", function ($join) {
                $join->on("brand.id", "=", "product.brand_id");
            })
            ->select("point.name as point_name", "product.name as product_name", "pp.quantity as quantity", "category.name as category_name", "brand.name as brand_name");
            
            if ($point_id!=0) {
                $result = $result->where("pp.point_id", "=", $point_id);
            }
            if ($category_id!=0) {
                $result = $result->where("product.category_id", "=", $category_id);
            }
            if ($brand_id!=0) {
                $result = $result->where("product.brand_id", "=", $brand_id);
            }
            if ($exists!=0) {
                $result = $result->where("pp.quantity", "<>", 0);
            } else {
                $result = $result->where("pp.quantity", "=", 0);
            }
            $result = $result->orderBy("pp.point_id", "desc")->get();
        }else{
            $result = [];
        }

        $is_admin = auth()->user()->user_role == User::roles['ADMIN'];
        return view('dashboard.reports.goodsByDivision')->with('result', $result)
                                            ->with('current_point_id', $point_id)
                                            ->with('current_category_id', $category_id)
                                            ->with('current_brand_id', $brand_id)
                                            ->with('exists', $exists)
                                            ->with('is_admin', $is_admin);
    }
    public function salesByProductAndOrderType(){
        
        $result = DB::table("uzpos_core_product AS p")
        ->join("uzpos_sales_orderitem AS oi", function($join){
            $join->on("oi.product_id", "=", "p.id");
        })
        ->join("uzpos_sales_order as o", function($join){
            $join->on("o.id", "=", "oi.order_id");
        })
        ->selectRaw("sum(oi.quantity) as quantity, p.name as product_name, o.order_type")
        ->where("o.status", "=", 2)
        ->groupBy("p.name")
        ->groupBy("o.order_type")
        ->get();

        return view('dashboard.reports.salesByProductAndOrderType')->with('result', $result);
    }
    public function expenses(Request $request){
        $from = $request->query('from');
        $to = $request->query('to');
        if($from && $to){
            $expenses = DB::table("expenses AS e")
            ->join("uzpos_core_point AS p", function($join){
                $join->on("p.id", "=", "e.division_id");
            })
            ->selectRaw("sum(e.amount) as all_amount, p.name as pname")
            ->where("e.created_at", ">", $from)
            ->where("e.created_at", "<", $to)
            ->groupBy("p.name")
            ->get();
        }else{
            $expenses = [];
        }
        return view('dashboard.reports.expenses')->with('expenses', $expenses);
    }
    public function esfByPeriod(Request $request){
        $from = $request->query('from');
        $to = $request->query('to');
        if($from && $to){
            $orders = Order::where('created_at', '>', $from)->where('created_at', '<', $to)->get();
        }else{
            $orders = [];
        }
        return view('dashboard.reports.esfByPeriod')->with('orders', $orders);
    }
    public function debts(){
        $results = DB::select('select c.client_type, c.fname, c.lname, c.company_name , p.amount_real - nvl( (select sum(r.amount) from repayments AS r where r.payment_id = p.id) , 0) as debt from uzpos_sales_payment AS p join uzpos_sales_order AS o on o.id = p.order_id join uzpos_sales_client AS c on c.id = o.client_id;');
        return view('dashboard.reports.debts')->with('results', $results);
    }
}
