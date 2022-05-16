<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\DeleteRequest;
use App\Http\Requests\Transfer\FinishRequest;
use App\Http\Requests\Transfer\StoreRequest;
use App\Http\Requests\Transfer\UpdateRequest;
use App\Models\Point;
use App\Models\Product;
use App\Models\Transfer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class TransferResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers = Transfer::orderByDesc('created_at')->paginate(10);
        return view("dashboard.transfer.index")->with("transfers", $transfers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $products = Product::all();
        return view("dashboard.transfer.create")
                                        ->with('products', $products);
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
        $transfer = Transfer::createFromArrayWithUser($validated, $user);
        return redirect()->route("dashboard.transfer.edit", $transfer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transfer $transfer
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transfer $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        $orders = [];
        if(str_contains("Для заказа", $transfer->reason)){
            $orders = Order::where('id', str_replace('Для заказа ', '', $transfer->reason))->get();
        }
        return view("dashboard.transfer.edit")->with("transfer", $transfer)->with('orders', $orders);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Transfer $transfer)
    {
        $transfer->updateFromArray($request->validated(), $transfer->id);
        return redirect()->route("dashboard.transfer.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request,Transfer $transfer)
    {
        $transfer->delete();
        return redirect()->route("dashboard.transfer.index");
    }
    /**
     * finish the transfer and actually move products
     *  
     */
     public function finish(FinishRequest $request, Transfer $transfer){
        $transfer->finishTransfer();
        return redirect()->back();
    }
}
        