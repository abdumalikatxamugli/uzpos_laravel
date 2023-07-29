<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use PDO;
use Shuchkin\SimpleXLSXGen;

use function PHPUnit\Framework\isNull;

class ReportContoller extends Controller
{
    public function report_2_1()
    {
        $sql = "select up.name as point_name, date(uo.created_at) as created_date, sum(ui.price*ui.quantity) as total_cost,
                        (select sum(e.amount) from expenses e where e.division_id = uo.supplying_division_id) as total_expense,
                        sum(case p.payed_currency_type when 0 then p.amount else 0 end) as uzs_payment,
                        sum(case p.payed_currency_type when 1 then p.amount else 0 end) as usd_payment
                        from divisions up 
                        join orders uo on uo.supplying_division_id = up.id and uo.status=2
                        join orderitems ui on ui.order_id = uo.id 
                        join payments p on p.order_id = uo.id                    
                        group by up.name, date(uo.created_at), total_expense;";
        $result = DB::select($sql);
        return view('dashboard.reports.report2_1')->with('result',$result);
    }
    public function report_2_1_download()
    {
        $sql = "select up.name as point_name, date(uo.created_at) as created_date, sum(ui.price*ui.quantity) as total_cost,
                        (select sum(e.amount) from expenses e where e.division_id = uo.supplying_division_id) as total_expense,
                        sum(case p.payed_currency_type when 0 then p.amount else 0 end) as uzs_payment,
                        sum(case p.payed_currency_type when 1 then p.amount else 0 end) as usd_payment
                        from divisions up 
                        join orders uo on uo.supplying_division_id = up.id and uo.status=2
                        join orderitems ui on ui.order_id = uo.id 
                        join payments p on p.order_id = uo.id                    
                        group by up.name, date(uo.created_at), total_expense;";
        $result = DB::select($sql);
        $headers = ["КАССА ТОЧКЕ", "ДАТА", "ОБШИЙ СУММА", "РАСХОД", "СУМ", "ДОЛЛАР"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }
    
    public function report_2_2()
    {
        $sql = "select uo.esf_no,
                         up.name as point_name, 
                         date(uo.created_at) as created_date, 
                         c.id as client_id,
                         (Select sum(ui.price*ui.quantity) from orderitems ui where ui.order_id = uo.id) as total_sum,
                            case c.client_type when 0 then
                                concat(c.first_name, c.last_name, c.middle_name) 
                                else
                                c.company_name end
                            as client_name,
                            c.region_id
                            
                        from orders uo  
                        join clients c on uo.client_id = c.id
                        join divisions up on uo.supplying_division_id = up.id and uo.status=2
                        join payments p on p.order_id = uo.id;";
        $result = DB::select($sql);
        return view('dashboard.reports.report2_2')->with('result',$result);
    }
    public function report_2_2_download()
    {
        $sql = "select uo.esf_no,
                         up.name as point_name, 
                         date(uo.created_at) as created_date, 
                         c.id as client_id,
                         (Select sum(ui.price*ui.quantity) from orderitems ui where ui.order_id = uo.id) as total_sum,
                            case c.client_type when 0 then
                                concat(c.first_name, c.last_name, c.middle_name) 
                                else
                                c.company_name end
                            as client_name,
                            c.region_id
                            
                        from orders uo  
                        join clients c on uo.client_id = c.id
                        join divisions up on uo.supplying_division_id = up.id and uo.status=2
                        join payments p on p.order_id = uo.id;";
        $result = DB::select($sql);
        
        $headers = ["Номер", "Сумма", "дата", "ID клиента", "Имя клиента", "Инфо", "Точка заказа"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }
    public function report_2_3()
    {
        $sql = "select up.name as point_name, p.name as product_name, 
                        sum(oi.quantity) as total_quantity, 
                        p.bar_code, 
                        sum(oi.quantity * oi.price) as total_price

                        from divisions up
                        join orders uo on uo.supplying_division_id = up.id
                        join orderitems oi on oi.order_id = uo.id
                        join products p on p.id = oi.product_id
                
                group by up.name, p.name, p.bar_code;";
        $result = DB::select($sql);
        return view('dashboard.reports.report2_3')->with('result',$result);
    }
    public function report_2_3_download()
    {
        $sql = "select up.name as point_name, p.name as product_name, 
                        sum(oi.quantity) as total_quantity, 
                        p.bar_code, 
                        sum(oi.quantity * oi.price) as total_price

                        from divisions up
                        join orders uo on uo.supplying_division_id = up.id
                        join orderitems oi on oi.order_id = uo.id
                        join products p on p.id = oi.product_id
                
                group by up.name, p.name, p.bar_code;";
        $result = DB::select($sql);
        $headers = ["ТОЧКА", "НАИМЕНОВАНИЕ", "ШТ", "ШТРИХ-КОД", "СУММА"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }
    public function report_2_4()
    {
        $sql = "select up.name as point_name, p.name as product_name, 
                                    sum(oi.quantity) as total_quantity, 
                                    p.bar_code, 
                                    sum(oi.quantity * oi.price) as total_price,
                                    date(uo.created_at) as order_day
                                    from divisions up
                                    join orders uo on uo.supplying_division_id = up.id
                                    join orderitems oi on oi.order_id = uo.id
                                    join products p on p.id = oi.product_id

                            group by up.name, p.name, p.bar_code, date(uo.created_at)";
        $result = DB::select($sql);
        return view('dashboard.reports.report2_4')->with('result',$result);
    }
    public function report_2_4_download()
    {
        $sql = "select up.name as point_name, p.name as product_name, 
                                    sum(oi.quantity) as total_quantity, 
                                    p.bar_code, 
                                    sum(oi.quantity * oi.price) as total_price,
                                    date(uo.created_at) as order_day
                                    from divisions up
                                    join orders uo on uo.supplying_division_id = up.id
                                    join orderitems oi on oi.order_id = uo.id
                                    join products p on p.id = oi.product_id

                            group by up.name, p.name, p.bar_code, date(uo.created_at)";
        $result = DB::select($sql);
        $headers = ["ТОЧКА", "НАИМЕНОВАНИЕ", "ШТ", "ШТРИХ-КОД", "СУММА"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }
    public function report_2_5()
    {
        $sql = "select up.name as point_name, date(e.created_at) as expense_day, sum(e.amount) as total_sum
                       from divisions up
                       join expenses e on e.division_id = up.id
                       group by up.name, date(e.created_at)
                       order by date(e.created_at) asc;";
        $result = DB::select($sql);
        return view('dashboard.reports.report2_5')->with('result',$result);
    }
    public function report_2_5_download()
    {
        $sql = "select up.name as point_name, date(e.created_at) as expense_day, sum(e.amount) as total_sum
                       from divisions up
                       join expenses e on e.division_id = up.id
                       group by up.name, date(e.created_at)
                       order by date(e.created_at) asc;";
        $result = DB::select($sql);
        $headers = ["КАССА", "СУММА", "ДАТА"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }

    /**
     * Material reports
     */
    public function report_1_1(Request $request)
    {
        $brand_id = $_GET['brand_id']??0;
        $category_id = $_GET['category_id']??0;
        $product_id = $_GET['product_id']??0;
        $division_id = $_GET['division_id']??0;
        
        $sql = "select  up.name as point_name,
                        p.name as product_name,
                        sum(upp.quantity) as total_count,
                        c.name as category_name,
                        b.name as brand_name
                                from divisions up
                                join pointproducts upp on upp.division_id = up.id
                                join products p on p.id = upp.product_id
                                left join category c on c.id = p.category_id
                                left join brands b on b.id = p.brand_id
                                where (:v_brand_id= 0 or :v_brand_id2 = b.id)
                                and (:v_category_id= 0 or :v_category_id2 = c.id)
                                and (:v_product_id = 0 or :v_product_id2 = p.id)
                                and (:v_division_id = 0 or :v_division_id2 = up.id)
                                group by up.name,  p.name, c.name, b.name
                                order by p.name asc;";
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':v_brand_id' => $brand_id ,':v_brand_id2' => $brand_id,
            ':v_category_id' => $category_id ,':v_category_id2' => $category_id,
            ':v_product_id' => $product_id ,':v_product_id2' => $product_id,
            ':v_division_id' => $division_id ,':v_division_id2' => $division_id        
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return view('dashboard.reports.report1_1')->with('result',$result)
                                                  ->with('brand_id',$brand_id)
                                                  ->with('category_id',$category_id)
                                                  ->with('product_id', $product_id)
                                                  ->with('division_id', $division_id);
    }
    public function report_1_1_download()
    {
        $sql = "select  up.name as point_name,
                        p.name as product_name,
                        sum(upp.quantity) as total_count,
                        c.name as category_name,
                        b.name as brand_name
                                from divisions up
                                join pointproducts upp on upp.division_id = up.id
                                join products p on p.id = upp.product_id
                                left join category c on c.id = p.category_id
                                left join brands b on b.id = p.brand_id
                                
                                group by up.name,  p.name, c.name, b.name
                                order by p.name asc;";
        $result = DB::select($sql);
        $headers = ["Филиал", "Продукт", "Количество", "Категория", "Бренд"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }
    public function report_1_2()
    {
        $brand_id = $_GET['brand_id']??0;
        $category_id = $_GET['category_id']??0;
        $product_id = $_GET['product_id']??0;
        $division_id = $_GET['division_id']??0;
        $sql = "select  up.name as point_name,
                        p.name as product_name,
                        sum(upp.quantity) as total_count,
                        c.name as category_name,
                        b.name as brand_name
                                from divisions up
                                join pointproducts upp on upp.division_id = up.id
                                join products p on p.id = upp.product_id
                                left join category c on c.id = p.category_id
                                left join brands b on b.id = p.brand_id
                                where  (:v_brand_id= 0 or :v_brand_id2 = b.id)
                                and (:v_category_id= 0 or :v_category_id2 = c.id)
                                and (:v_product_id = 0 or :v_product_id2 = p.id)
                                and (:v_division_id = 0 or :v_division_id2 = up.id)
                                group by up.name,  p.name, c.name, b.name
                                having sum(upp.quantity) < 10
                                order by p.name asc;";
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':v_brand_id' => $brand_id ,':v_brand_id2' => $brand_id,
            ':v_category_id' => $category_id ,':v_category_id2' => $category_id,
            ':v_product_id' => $product_id ,':v_product_id2' => $product_id,
            ':v_division_id' => $division_id ,':v_division_id2' => $division_id        
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return view('dashboard.reports.report1_2')->with('result',$result)
                                                    ->with('brand_id',$brand_id)
                                                    ->with('category_id',$category_id)
                                                    ->with('product_id', $product_id)
                                                    ->with('division_id', $division_id);
    }
    public function report_1_2_download()
    {
        $sql = "select  up.name as point_name,
                        p.name as product_name,
                        sum(upp.quantity) as total_count,
                        c.name as category_name,
                        b.name as brand_name
                                from divisions up
                                join pointproducts upp on upp.division_id = up.id
                                join products p on p.id = upp.product_id
                                left join category c on c.id = p.category_id
                                left join brands b on b.id = p.brand_id
                                
                                group by up.name,  p.name, c.name, b.name
                                having sum(upp.quantity) < 10
                                order by p.name asc;";
        $result = DB::select($sql);
        $headers = ["Филиал", "Продукт", "Количество", "Категория", "Бренд"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }
    public function report_1_3()
    {
        $brand_id = $_GET['brand_id']??0;
        $category_id = $_GET['category_id']??0;
        $product_id = $_GET['product_id']??0;
        $division_id = $_GET['division_id']??0;
        $sql = "select  up.name as point_name,
                        p.name as product_name,
                        sum(upp.quantity) as total_count,
                        c.name as category_name,
                        b.name as brand_name
                                from divisions up
                                join pointproducts upp on upp.division_id = up.id
                                join products p on p.id = upp.product_id
                                left join category c on c.id = p.category_id
                                left join brands b on b.id = p.brand_id
                                where  (:v_brand_id= 0 or :v_brand_id2 = b.id)
                                and (:v_category_id= 0 or :v_category_id2 = c.id)
                                and (:v_product_id = 0 or :v_product_id2 = p.id)
                                and (:v_division_id = 0 or :v_division_id2 = up.id)
                                group by up.name,  p.name, c.name, b.name
                                having sum(upp.quantity) = 0
                                order by p.name asc;";
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':v_brand_id' => $brand_id ,':v_brand_id2' => $brand_id,
            ':v_category_id' => $category_id ,':v_category_id2' => $category_id,
            ':v_product_id' => $product_id ,':v_product_id2' => $product_id,
            ':v_division_id' => $division_id ,':v_division_id2' => $division_id        
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return view('dashboard.reports.report1_3')->with('result',$result)
                                                    ->with('brand_id',$brand_id)
                                                    ->with('category_id',$category_id)
                                                    ->with('product_id', $product_id)
                                                    ->with('division_id', $division_id);
    }
    public function report_1_3_download()
    {
        $sql = "select  up.name as point_name,
                        p.name as product_name,
                        sum(upp.quantity) as total_count,
                        c.name as category_name,
                        b.name as brand_name
                                from divisions up
                                join pointproducts upp on upp.division_id = up.id
                                join products p on p.id = upp.product_id
                                left join category c on c.id = p.category_id
                                left join brands b on b.id = p.brand_id
                                
                                group by up.name,  p.name, c.name, b.name
                                having sum(upp.quantity) = 0
                                order by p.name asc;";
        $result = DB::select($sql);
        $headers = ["Филиал", "Продукт", "Количество", "Категория", "Бренд"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }
    public function report_1_4()
    {
        $sql = "select up.name as point_name, p.name as product_name, 
                                    sum(oi.quantity) as total_quantity, 
                                    p.bar_code, 
                                    sum(oi.quantity * oi.price) as total_price,
                                    date(uo.created_at) as order_day
                                    from divisions up
                                    join orders uo on uo.supplying_division_id = up.id
                                    join orderitems oi on oi.order_id = uo.id
                                    join products p on p.id = oi.product_id

                            group by up.name, p.name, p.bar_code, date(uo.created_at)";
        $result = DB::select($sql);
        return view('dashboard.reports.report1_4')->with('result',$result);
    }
    public function report_1_4_download()
    {
        $sql = "select up.name as point_name, p.name as product_name, 
                                    sum(oi.quantity) as total_quantity, 
                                    p.bar_code, 
                                    sum(oi.quantity * oi.price) as total_price,
                                    date(uo.created_at) as order_day
                                    from divisions up
                                    join orders uo on uo.supplying_division_id = up.id
                                    join orderitems oi on oi.order_id = uo.id
                                    join products p on p.id = oi.product_id

                            group by up.name, p.name, p.bar_code, date(uo.created_at)";
        $result = DB::select($sql);
        $headers = ["Филиал", "Продукт", "Количество", "Категория", "Бренд"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }

   
    
    /**
     * Client report
     */
   
    public function report_3_1()
    {
        $sql = "select case c.client_type when 0 then concat(c.last_name, ' ', c.first_name, ' ', c.middle_name) else c.company_name end as client_name,
                            c.id,
                            c.region_id,
                            c.phone_number
                                from clients c 
                                order by client_name asc;";
        $result = DB::select($sql);
        return view('dashboard.reports.report3_1')->with('result',$result);
    }
    public function report_3_1_download()
    {
        $sql = "select case c.client_type when 0 then concat(c.last_name, ' ', c.first_name, ' ', c.middle_name) else c.company_name end as client_name,
                            c.id,
                            c.region_id,
                            c.phone_number
                                from clients c 
                                order by client_name asc;";
        $result = DB::select($sql);
        $headers = ["ИМЯ", "ID", "РЕГИОН", "КОНТАКТ"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }
    public function report_3_2()
    {
        $sql = "select case c.client_type when 0 then concat(c.last_name, ' ', c.first_name, ' ', c.middle_name) else c.company_name end as client_name,
                            c.id,
                            c.region_id,
                            c.phone_number,
                            p.amount,
                            date(o.created_at) as order_day,
                            up.name as point_name
                                from clients c 
                                join orders o on o.client_id = c.id
                                join divisions up on up.id =o.supplying_division_id 
                                join payments p on p.order_id = o.id and p.payment_type = 3
                                
                                order by client_name asc;";
        $result = DB::select($sql);
        return view('dashboard.reports.report3_2')->with('result',$result);
    }
    public function report_3_2_download()
    {
        $sql = "select case c.client_type when 0 then concat(c.last_name, ' ', c.first_name, ' ', c.middle_name) else c.company_name end as client_name,
                            c.id,
                            c.region_id,
                            c.phone_number,
                            p.amount,
                            date(o.created_at) as order_day,
                            up.name as point_name
                                from clients c 
                                join orders o on o.client_id = c.id
                                join divisions up on up.id =o.supplying_division_id 
                                join payments p on p.order_id = o.id and p.payment_type = 3
                                
                                order by client_name asc;";
        $result = DB::select($sql);
        $headers = ["ИМЯ", "ID", "РЕГИОН", "КОНТАКТ", "СУММА ДОЛГА", "ДАТА", "ТОЧКА ПРОДАЖ"];
        $data = [$headers];
        foreach($result as $row)
        {
            $data[] = array_values((array) $row);
        }
        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('report.xlsx');
    }
}
