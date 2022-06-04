<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Metric;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $current_product_id = $request->query('product_id');
        $current_category_id = $request->query('category_id');
        $current_brand_id = $request->query('brand_id');
        $run = $request->query('run');

        $products = Product::whereNotNull('id');

        if($run){
            if(isset($current_product_id) && $current_product_id != 0){
                $products = $products->where('id', $current_product_id);
            }
            if ($current_category_id!=0) {
                $products = $products->where("category_id", "=", $current_category_id);
            }
            if ($current_brand_id!=0) {
                $products = $products->where("brand_id", "=", $current_brand_id);
            }
        }

        $products= $products->orderBy('created_at', 'desc')->paginate(10);

        return view("dashboard.product.index")->with("products", $products)
                                        ->with('current_product_id', $current_product_id)
                                        ->with('current_category_id', $current_category_id)
                                        ->with('current_brand_id', $current_brand_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $metrics = Metric::all();
        return view("dashboard.product.create")
                    ->with('categories', $categories)
                    ->with('brands', $brands)
                    ->with('metrics', $metrics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, User $user)
    {
        $validated = $request->validated();
        if(!$validated['bar_code']){
            $barcode = Product::genBarcode();
            $validated['bar_code'] = $barcode;
        }
        Product::createFromArrayWithUser($validated, $user);
        return redirect()->route("dashboard.product.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $metrics = Metric::all();
        return view("dashboard.product.edit")
                    ->with("product", $product)
                    ->with('categories', $categories)
                    ->with('brands', $brands)
                    ->with('metrics', $metrics);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $product->updateFromArray($request->validated(), $product->id);
        return redirect()->route("dashboard.product.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route("dashboard.product.index");
    }
}
        