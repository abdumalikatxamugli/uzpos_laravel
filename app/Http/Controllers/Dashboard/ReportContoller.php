<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Point;
use Illuminate\Http\Request;

class ReportContoller extends Controller
{
    public function goodsReport(Request $request){
        $pointId = $request->query('pointId');
        $point = new Point();
        if($pointId){
            $point = Point::where('id', $pointId)->first();
        }
        return view('dashboard.reports.goodsReport')->with('current_point', $point);
    }
}
