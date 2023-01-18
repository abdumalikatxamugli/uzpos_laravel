<?php
namespace App\Http\Helpers;

use App\Models\Client;
use App\Models\Month;
use App\Models\Order;
use App\Models\Product;
use App\Models\Vozvrat;
use Illuminate\Support\Facades\DB;

class Report{
    const USER_FILTER = 'user_id';
    const FROM_FILTER = 'from';
    const TO_FILTER = 'to';
    const PRODUCT_FILTER = 'product_id';
    const CLIENT_FILTER = 'client_id';
    
    private $filterValues;
    
    public function setFilterValues($filters){
        foreach($filters as $filter){
            $this->filterValues[$filter] = isset( $_GET[$filter] )&&$_GET[$filter]!=-1?$_GET[$filter]:null;
        }
    }
    
    public function getFilterData(){
        return (object) $this->filterValues;
    }
    
    public function getOrderQuantityByUser(){
        $select = DB::table("users")
        ->leftJoin("orders", function($join){
            $join->on("users.id", "=", "orders.created_by_id");
        })
        ->selectRaw("count(orders.id) as order_count, users.name as uname, users.id as uid");
        
        if($this->filterValues[self::FROM_FILTER]){
            $select->where("orders.created_at", ">=", $this->filterValues[self::FROM_FILTER]);
        }
        
        if($this->filterValues[self::TO_FILTER]){
            $select->where("orders.created_at", "<=",$this->filterValues[self::TO_FILTER]);
        }
        
        if($this->filterValues[self::USER_FILTER]){
            $select->where("orders.created_by_id", "=",$this->filterValues[self::USER_FILTER]);
        }
        
        $dataset = $select->groupByRaw("users.id, users.name")->get();
        $result = $this->separateLabelsAndValues($dataset, 'uname', 'order_count');
        $result->dataset = $dataset;
        $result->bgColors = $this->getRandomBgColors(count($dataset));
        return $result;
    }
    public function getOrderItemByUser(){
        $select = DB::table("users")
        ->leftJoin("orders", function($join){
            $join->on("users.id", "=", "orders.created_by_id");
        })
        ->leftJoin("order_items", function($join){
            $join->on("orders.id", "=", "order_items.order_id");
        })
        ->selectRaw("sum(order_items.quantity) as order_count, users.name as uname, users.id as uid");
        
        if($this->filterValues[self::FROM_FILTER]){
            $select->where("orders.created_at", ">=", $this->filterValues[self::FROM_FILTER]);
        }
        
        if($this->filterValues[self::TO_FILTER]){
            $select->where("orders.created_at", "<=",$this->filterValues[self::TO_FILTER]);
        }
        
        if($this->filterValues[self::USER_FILTER]){
            $select->where("orders.created_by_id", "=",$this->filterValues[self::USER_FILTER]);
        }
        
        $dataset = $select->groupByRaw("users.id, users.name")->get();
        $result = $this->separateLabelsAndValues($dataset, 'uname', 'order_count');
        $result->dataset = $dataset;
        $result->bgColors = $this->getRandomBgColors(count($dataset));
        return $result;
    }
    public function getOrderCostByUser(){
        $select = DB::table("users")
        ->leftJoin("orders", function($join){
            $join->on("users.id", "=", "orders.created_by_id");
        })
        ->leftJoin("payments", function($join){
            $join->on("orders.id", "=", "payments.order_id");
        })
        ->selectRaw("sum(payments.amount) as order_count, users.name as uname, users.id as uid");
        
        if($this->filterValues[self::FROM_FILTER]){
            $select->where("orders.created_at", ">=", $this->filterValues[self::FROM_FILTER]);
        }
        
        if($this->filterValues[self::TO_FILTER]){
            $select->where("orders.created_at", "<=",$this->filterValues[self::TO_FILTER]);
        }
        
        if($this->filterValues[self::USER_FILTER]){
            $select->where("orders.created_by_id", "=",$this->filterValues[self::USER_FILTER]);
        }
        
        $dataset = $select->groupByRaw("users.id, users.name")->get();
        $result = $this->separateLabelsAndValues($dataset, 'uname', 'order_count');
        $result->dataset = $dataset;
        $result->bgColors = $this->getRandomBgColors(count($dataset));
        return $result;
    }
    
    public function getSalesDistributionByProduct(){
        $select = DB::table("products")
        ->leftJoin("order_items", function($join){
            $join->on("products.id", "=", "order_items.product_id");
        })
        ->leftJoin("orders", function($join){
            $join->on("order_items.order_id", "=", "orders.id");
        })
        ->selectRaw("sum(order_items.quantity) as magnitude, products.name as name, products.id as pk");
        
        if($this->filterValues[self::FROM_FILTER]){
            $select->where("orders.created_at", ">=", $this->filterValues[self::FROM_FILTER]);
        }
        
        if($this->filterValues[self::TO_FILTER]){
            $select->where("orders.created_at", "<=",$this->filterValues[self::TO_FILTER]);
        }
        
        if($this->filterValues[self::PRODUCT_FILTER]){
            $select->where("products.id", "=",$this->filterValues[self::PRODUCT_FILTER]);
        }
        $select->groupByRaw("products.id, products.name");
        $dataset = $select->orderBy('magnitude', 'desc')->get();
        $result = $this->separateLabelsAndValues($dataset, 'name', 'magnitude');
        $result->dataset = $dataset;
        $result->bgColors = $this->getRandomBgColors(count($dataset));
        return $result;
    }
    public function getRandomBgColors($nums){
        $bg_colors = [];
        for($i=0; $i<$nums; $i++){
            $color = rand(0,255);
            array_push($bg_colors, 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).','.rand(0,255).')');
        }
        return $bg_colors;
    }
    public function getSalesDynamicsByProduct(){
        $productDynamics = [];
        if($this->filterValues[self::PRODUCT_FILTER]){
            $product = Product::where('id', $this->filterValues[self::PRODUCT_FILTER])->first();
            array_push( $productDynamics, $this->getSalesDynamicsBySingleProduct($this->filterValues[self::PRODUCT_FILTER], $product->name) );
        }else{
            $products = Product::orderBy('id')->get();
            foreach($products as $product){
                array_push( $productDynamics, $this->getSalesDynamicsBySingleProduct($product->id, $product->name) );
            }
        }
        return $productDynamics;
        
    }
    
    private function getSalesDynamicsBySingleProduct($product_id, $product_name){
        $select = DB::table("products")
        ->leftJoin("order_items", function($join){
            $join->on("products.id", "=", "order_items.product_id");
        })
        ->leftJoin("orders", function($join){
            $join->on("order_items.order_id", "=", "orders.id");
        })
        ->selectRaw("sum(order_items.quantity) as magnitude, products.name as name, products.id as pk, date(orders.created_at) as d");
        
        if($this->filterValues[self::FROM_FILTER]){
            $select->where("orders.created_at", ">=", $this->filterValues[self::FROM_FILTER]);
        }
        
        if($this->filterValues[self::TO_FILTER]){
            $select->where("orders.created_at", "<=",$this->filterValues[self::TO_FILTER]);
        }
        
        $select->where("products.id", "=", $product_id);
        
        $dataset = $select->groupByRaw("date(orders.created_at), products.id, products.name")->get();
        $result = $this->separateLabelsAndValues($dataset, 'd', 'magnitude');
        $result->dataset = $dataset;
        $result->product_name = $product_name;
        return $result;
    }
    
    private function separateLabelsAndValues($dataset, $label, $value){
        $labels = [];
        $values = [];
        foreach($dataset as $data){
            array_push($labels, $data->{$label});
            if(!$data->{$value}){
                array_push($values, 0);
            }else{
                array_push($values, $data->{$value});
            }
        }
        return (object) ['labels'=>$labels, 'values'=>$values];
    }
    
    public function getSalesDistributionByClient(){
        $select = DB::table("clients")
        ->leftJoin("orders", function($join){
            $join->on("orders.client_id", "=", "clients.id");
        })
        ->leftJoin("order_items", function($join){
            $join->on("orders.id", "=", "order_items.order_id");
        })
        ->selectRaw("clients.id, sum(order_items.quantity) as magnitude, 
        case clients.client_type
        when 0 then concat(clients.lname, ' ', clients.fname)
        else clients.company_name
        end as name, 
        clients.id as pk");
        
        if($this->filterValues[self::FROM_FILTER]){
            $select->where("orders.created_at", ">=", $this->filterValues[self::FROM_FILTER]);
        }
        
        if($this->filterValues[self::TO_FILTER]){
            $select->where("orders.created_at", "<=",$this->filterValues[self::TO_FILTER]);
        }
        if($this->filterValues[self::CLIENT_FILTER]){
            $select->where("clients.id", "=",$this->filterValues[self::CLIENT_FILTER]);
        }
        $select->groupByRaw("clients.id, clients.lname, clients.fname, clients.company_name, clients.client_type");
        $dataset = $select->orderBy('clients.id', 'asc')->get();
        $result = $this->separateLabelsAndValues($dataset, 'name', 'magnitude');
        $result->dataset = $dataset;
        $result->bgColors = $this->getRandomBgColors(count($dataset));
        return $result;
    }
    
    public function getSalesPriceDistributionByClient(){
        $select = DB::table("clients")
        ->leftJoin("orders", function($join){
            $join->on("orders.client_id", "=", "clients.id");
        })
        ->leftJoin("order_items", function($join){
            $join->on("orders.id", "=", "order_items.order_id");
        })
        ->selectRaw("sum(order_items.quantity*order_items.price) as magnitude, 
        case clients.client_type
        when 0 then concat(clients.lname, ' ', clients.fname)
        else clients.company_name
        end as name, 
        clients.id as pk");
        
        if($this->filterValues[self::FROM_FILTER]){
            $select->where("orders.created_at", ">=", $this->filterValues[self::FROM_FILTER]);
        }
        
        if($this->filterValues[self::TO_FILTER]){
            $select->where("orders.created_at", "<=",$this->filterValues[self::TO_FILTER]);
        }
        
        if($this->filterValues[self::CLIENT_FILTER]){
            $select->where("clients.id", "=",$this->filterValues[self::CLIENT_FILTER]);
        }
        $select->groupByRaw("clients.id, clients.lname, clients.fname, clients.company_name, clients.client_type");
        $dataset = $select->orderBy('clients.id', 'asc')->get();
        $result = $this->separateLabelsAndValues($dataset, 'name', 'magnitude');
        $result->dataset = $dataset;
        $result->bgColors = $this->getRandomBgColors(count($dataset));
        return $result;
    }
    
    public function getSalesDynamicsByClient(){
        $productDynamics = [];
        if($this->filterValues[self::CLIENT_FILTER]){
            $client = Client::where('id', $this->filterValues[self::CLIENT_FILTER])->first();
            array_push( $productDynamics, $this->getSalesDynamicsBySingleClient($this->filterValues[self::CLIENT_FILTER], "{$client->lname} {$client->fname}") );
        }else{
            $clients = Client::orderBy('id')->get();
            foreach($clients as $client){
                array_push( $productDynamics, $this->getSalesDynamicsBySingleClient($client->id, "{$client->lname} {$client->fname}") );
            }
        }
        return $productDynamics;
        
    }
    
    private function getSalesDynamicsBySingleClient($product_id, $product_name){
        $select = DB::table("clients")
        ->leftJoin("orders", function($join){
            $join->on("orders.client_id", "=", "clients.id");
        })
        ->leftJoin("order_items", function($join){
            $join->on("orders.id", "=", "order_items.order_id");
        })
        
        ->selectRaw("sum(order_items.quantity) as magnitude, 
        case clients.client_type
        when 0 then concat(clients.lname, ' ', clients.fname)
        else clients.company_name
        end as name,
        clients.id as pk, date(orders.created_at) as d");
        
        if($this->filterValues[self::FROM_FILTER]){
            $select->where("orders.created_at", ">=", $this->filterValues[self::FROM_FILTER]);
        }
        
        if($this->filterValues[self::TO_FILTER]){
            $select->where("orders.created_at", "<=",$this->filterValues[self::TO_FILTER]);
        }
        
        $select->where("clients.id", "=", $product_id);
        
        $dataset = $select->groupByRaw("date(orders.created_at), clients.id, clients.client_type, clients.company_name, clients.lname, clients.fname")->get();
        $result = $this->separateLabelsAndValues($dataset, 'd', 'magnitude');
        $result->dataset = $dataset;
        $result->client_name = $product_name;
        return $result;
    }
    public function getSalesVsVozvrats(){
        $dataset = DB::select("
        select 
        p.id as pid,
        p.name as product_name,
        concat(m.`month`, '.', m.`year`) as time,
        (	
            select COALESCE(sum(oi.quantity), 0) from order_items oi 
            join orders o on o.id = oi.order_id
            where oi.product_id=p.id
            and MONTH(o.created_at) = m.`month` 
            and YEAR(o.created_at) = m.`year`  												
            ) as sell_total,
            (	
                select COALESCE(sum(v.amount), 0) from product_returns v
                join order_items oi2 on oi2.id = v.item_id
                where oi2.product_id=p.id
                and MONTH(v.created_at) = m.`month` 
                and YEAR(v.created_at) = m.`year`  												
            ) as return_total
            from products p cross join months m 

            where (	
                select COALESCE(sum(oi.quantity), 0) from order_items oi 
                join orders o on o.id = oi.order_id
                where oi.product_id=p.id
                and MONTH(o.created_at) = m.`month` 
                and YEAR(o.created_at) = m.`year`  												
            )>0
            or 
            (	
                select COALESCE(sum(v.amount), 0) from product_returns v
                join order_items oi2
                where oi2.product_id=p.id
                and MONTH(v.created_at) = m.`month` 
                and YEAR(v.created_at) = m.`year`  												
                ) >0"
            );
        
        
        $productsDataset = $this->seperateProducts($dataset);
        return $productsDataset;
    }
    private function seperateProducts(array $dataset){
        $productSets = [];
        foreach($dataset as $data){
            if(array_key_exists($data->pid, $productSets)){
                $productSets[$data->pid]->return_dataset[] = $data->return_total;
                $productSets[$data->pid]->sell_dataset[] = $data->sell_total;
                $productSets[$data->pid]->labels[] = $data->time;
                $productSets[$data->pid]->joint_dataset['joint_dataset'][]=[
                                                            'sell'=>$data->sell_total,
                                                            'return'=>$data->return_total,
                                                            'month'=>$data->time
                                                        ];
            }else{
                $productSets[$data->pid] = (object)[
                    'return_dataset'=>[$data->return_total],
                    'sell_dataset'=>[$data->sell_total],
                    'joint_dataset'=>[
                            [
                            'sell'=>$data->sell_total,
                            'return'=>$data->return_total,
                            'month'=>$data->time
                        ]
                    ],
                    'labels'=>[$data->time],
                    'sell_total'=>$data->sell_total,
                    'return_total'=>$data->return_total,
                    'product_name'=>$data->product_name
                ];
            }
        }
        return $productSets;
    }
    public function getRevenueReportData(){
        $sql = "select 
        sum(case when r.revenue_type = 0 then r.sales_sum else 0 end) as china_sales,
        sum(case when r.revenue_type = 1 then r.sales_sum else 0 end) as plan_sales, 
        r.m,
        r.y
       from (
           (
               select 
               month(o.created_at) as m,
               year(o.created_at) as y,
               sum(oi.price*oi.quantity) as sales_sum,
               p.revenue_type 
               from orders o 
               join order_items oi on oi.order_id  = o.id 
               join products p on p.id = oi.product_id 
               group by p.revenue_type, month(o.created_at), year(o.created_at)
           ) 
       union all
           (
               select 
                   month(o.created_at) as m,
                   year(o.created_at) as y,
                   sum(oi.price*oi.quantity) as sales_sum,
                   p.revenue_type 
                   from orders o 
                   join order_items oi on oi.order_id  = o.id 
                   join products p on p.id = oi.product_id
                   group by p.revenue_type, month(o.created_at), year(o.created_at)
           ) 
       ) r
       group by r.y, r.m
       order by r.y, r.m       
       ";
       $dataset = DB::select($sql);
       return $dataset;
    }
    public function userFundsReportData(){
        $transactionWhere = [];
        $expensesWhere = [];
        $bindings = [];
        if($this->filterValues[self::FROM_FILTER]){
            $transactionWhere[]=" t.created_at >=? ";
            $bindings[] = $this->filterValues[self::FROM_FILTER];
            $bindings[] = $this->filterValues[self::FROM_FILTER];
            $bindings[] = $this->filterValues[self::FROM_FILTER];
            $bindings[] = $this->filterValues[self::FROM_FILTER];
            $expensesWhere[]=" e.created_at >=? ";
            $bindings[] = $this->filterValues[self::FROM_FILTER];
            $bindings[] = $this->filterValues[self::FROM_FILTER];
            $bindings[] = $this->filterValues[self::FROM_FILTER];
        }
        if($this->filterValues[self::TO_FILTER]){
            $transactionWhere[]=" t.created_at <=? ";            
            $bindings[] = $this->filterValues[self::TO_FILTER];
            $bindings[] = $this->filterValues[self::TO_FILTER];
            $bindings[] = $this->filterValues[self::TO_FILTER];
            $bindings[] = $this->filterValues[self::TO_FILTER];
            $expensesWhere[]=" e.created_at <=? ";            
            $bindings[] = $this->filterValues[self::TO_FILTER];
            $bindings[] = $this->filterValues[self::TO_FILTER];
            $bindings[] = $this->filterValues[self::TO_FILTER];
        }
        $transactionWhere = join("and", $transactionWhere);
        $expensesWhere = join("and", $expensesWhere);
        if(strlen($transactionWhere)>0){
            $transactionWhere="and ".$transactionWhere;
        }
        if(strlen($expensesWhere)>0){
            $expensesWhere="and ".$expensesWhere;
        }
        $sql = "select
            u.id as user_id, 
            u.name as user_full_name,
            u.funds_uzs,
            u.funds_usd,
            coalesce((select sum(t.amount) from transactions t where t.from_user=u.id and t.currency=1 {$transactionWhere}), 0) as total_given_usd,
            coalesce((select sum(t.amount) from transactions t where t.from_user=u.id and t.currency=2 {$transactionWhere}), 0) as total_given_uzs,
            coalesce((select sum(t.amount) from transactions t where t.to_user=u.id and t.currency=1 {$transactionWhere}), 0) as total_income_usd,
            coalesce((select sum(t.amount) from transactions t where t.to_user=u.id and t.currency=2 {$transactionWhere}), 0) as total_income_uzs,
            coalesce((select sum(e.amount) from expenses e join salary_expenses s on s.expense_id = e.id where e.created_by_id = u.id $expensesWhere),0) total_expense_salary,
            coalesce((select sum(e.amount) from expenses e join common_expenses s on s.expense_id = e.id where e.created_by_id = u.id and e.currency=1 $expensesWhere),0) total_expense_common_usd,
            coalesce((select sum(e.amount) from expenses e join common_expenses s on s.expense_id = e.id where e.created_by_id = u.id and e.currency=2 $expensesWhere),0) total_expense_common_uzs
        from users u";
        $dataset = DB::select($sql, $bindings);
        return $dataset;
    }
}
                