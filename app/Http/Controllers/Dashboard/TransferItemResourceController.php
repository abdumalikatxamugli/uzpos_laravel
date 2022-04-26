<?php

namespace App\Http\Controllers\Dashboard;

use App\Exceptions\WarehouseOutOfProductException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferItem\DeleteRequest;
use App\Http\Requests\TransferItem\StoreRequest;
use App\Http\Requests\TransferItem\UpdateRequest;
use App\Models\TransferItem;
use App\Models\User;
use Illuminate\Http\Request;

class TransferItemResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transferItems = TransferItem::paginate(10);
        return view("dashboard.transferItem.index")->with("transferItems", $transferItems);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.transferItem.create");
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
        TransferItem::createFromArrayWithUser($validated, $user);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransferItem $transferItem
     * @return \Illuminate\Http\Response
     */
    public function show(TransferItem $transferItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransferItem $transferItem
     * @return \Illuminate\Http\Response
     */
    public function edit(TransferItem $transferItem)
    {
        return view("dashboard.transferItem.edit")->with("transferItem", $transferItem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\TransferItem  $transferItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, TransferItem $transferItem)
    {
        $transferItem->updateFromArray($request->validated(), $transferItem->id);
        return redirect()->route("dashboard.transferItem.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransferItem  $transferItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request, TransferItem $transferItem)
    {
        $transferItem->delete();
        return redirect()->back();
    }
}
        