<?php

namespace App\Exports;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class goodReportExport implements FromCollection, WithHeadings
{
    protected $id;
    public function __construct($point_id, $category_id, $brand_id, $exists)
    {
        $this->point_id = $point_id;
        $this->category_id = $category_id;
        $this->brand_id = $brand_id;
        $this->exists = $exists;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $point_id = $this->point_id;
        $category_id = $this->category_id;
        $brand_id = $this->brand_id;
        $exists = $this->exists;

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
        
        return $result;
    }
    public function headings(): array
    {
        return ["Филиал", "Продукт", "Количество", "Категория", "Бренд"];
    }
}
