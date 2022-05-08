<?php

namespace App\Http\Controllers;

use App\Exceptions\WarehouseOutOfProductException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItem\BulkStoreRequest;
use App\Http\Requests\Payment\StoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Point;
use App\Models\PointProduct;
use App\Models\Transfer;
use Exception;
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
        $orders = Order::orderBy('order_no')->paginate(10);
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
    public function confirm(Order $order){
        try{
            $order->status = 2;
            $order->save();
        }catch(WarehouseOutOfProductException $e){
    
        }
        return redirect()->back();
    
    }
    public function break(Order $order){
        try{
            $order->status = 3;
            $order->save();
        }catch(Exception $e){
    
        }
        return redirect()->back();
    
    }
    /**
     * get list of shops that have enough items to satisfy the full or part of the order
     */
    public function searchAvailableItems(Order $order){
        $shortages = $order->getShortages();
        $matches = PointProduct::getMatches($shortages);
        $fullMatches = $matches['fullMatches'];
        $partialMatches = $matches['partialMatches'];
        return view('dashboard.order.matches')->with('fullMatches', $fullMatches)
                                    ->with('partialMatches', $partialMatches)
                                    ->with('order', $order);
    }
    /**
     * open transfer request from other shop 
     */
    public function openTransfer(Order $order, Point $point){
        Transfer::createFromOrder($order, $point);
        session()->flash('message', 'Запрос отправлен');
        return redirect()->back();
    }
    /**
     * open transfer request from other shop to satify the needed items partially
     */
    public function openTransferPartial(Request $request, Order $order, Point $point){
        $items = collect( json_decode( $request->input('items') ) );
        Transfer::createFromOrderPartial($order, $point, $items);
        session()->flash('message', 'Запрос отправлен');
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
