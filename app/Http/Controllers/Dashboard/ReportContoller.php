<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
        $exists = $request->query('exists');
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
}
