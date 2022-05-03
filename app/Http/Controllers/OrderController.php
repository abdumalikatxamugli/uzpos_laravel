<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItem\BulkStoreRequest;
use App\Http\Requests\Payment\StoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use PDO;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(10);
        return view('dashboard.order.index')->with('orders', $orders);
    }
    /**
     * create new emplty order
     */
    public function new(){
        $order = new Order();
        $order->order_type = 1;
        $order->shop_id = auth()->user()->point_id;
        $last_order = Order::latest()->first();
        if($last_order){
            $order_no = $last_order->order_no + 1;
        }else{
            $order_no = 1;
        }
        $order->order_no = $order_no; 
        $order->save();
        return redirect()->route('dashboard.orders.edit', $order->id);
    }
    /**
     * Save order items
     */
    public function saveItems(BulkStoreRequest $request){
        $items = $request->validated()['items'];
        foreach($items as $item){
            OrderItem::createFromArray($item);
        }
        return redirect()->back();
    }
    /**
     * 
     * Delete order item
     */
    public function deleteItem(OrderItem $orderItem){
        $orderItem->delete();
        return redirect()->back();
    }
    /**
     * Create and Append payment
     */
    public function addPayment(StoreRequest $request){
        $data = $request->validated();
        $payment = Payment::createFromArray($data);
        return redirect()->back();
    }
    /**
     * Delete payment
     */
    public function deletePayment(Payment $payment){
        $payment->delete();
        return redirect()->back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {   
        return view('dashboard.order.edit')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
