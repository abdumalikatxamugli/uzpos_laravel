<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use App\Models\PointProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\goodReportExport;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isNull;

class ReportContoller extends Controller
{
    public function report_2_1()
    {
        $sql = "select up.name as point_name, date(uo.created_at) as created_date, sum(ui.price*ui.quantity) as total_cost,
                        (select sum(e.amount) from expenses e where e.division_id = uo.from_point_id) as total_expense,
                        sum(case p.currency when 0 then p.amount else 0 end) as uzs_payment,
                        sum(case p.currency when 1 then p.amount else 0 end) as usd_payment
                        from uzpos_core_point up 
                        join uzpos_sales_order uo on uo.from_point_id = up.id and uo.status=2
                        join uzpos_sales_orderitem ui on ui.order_id = uo.id 
                        join uzpos_sales_payment p on p.order_id = uo.id                    
                        group by up.name, date(uo.created_at), total_expense;";
        $result = DB::select($sql);
        return view('dashboard.reports.report2_1')->with('result',$result);
    }
    public function report_2_2()
    {
        $sql = "select uo.esf_no,
                         up.name as point_name, 
                         date(uo.created_at) as created_date, 
                         c.id as client_id,
                         (Select sum(ui.price*ui.quantity) from uzpos_sales_orderitem ui where ui.order_id = uo.id) as total_sum,
                            case c.client_type when 0 then
                                concat(c.fname, c.lname, c.mname) 
                                else
                                c.company_name end
                            as client_name,
                            c.region
                            
                        from uzpos_sales_order uo  
                        join uzpos_sales_client c on uo.client_id = c.id
                        join uzpos_core_point up on uo.from_point_id = up.id and uo.status=2
                        join uzpos_sales_payment p on p.order_id = uo.id;";
        $result = DB::select($sql);
        return view('dashboard.reports.report2_2')->with('result',$result);
    }
}
