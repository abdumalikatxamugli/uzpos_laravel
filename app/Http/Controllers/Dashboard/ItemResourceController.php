<?php

namespace App\Http\Controllers\Dashboard;

use App\Exceptions\WarehouseOutOfProductException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ItemResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate(10);
        return view("dashboard.item.index")->with("items", $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.item.create");
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
        Item::createFromArrayWithUser($validated, $user);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view("dashboard.item.edit")->with("item", $item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Item $item)
    {
        $item->updateFromArray($request->validated(), $item->id);
        return redirect()->route("dashboard.item.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        try{
            $item->delete();
        }catch(WarehouseOutOfProductException $e){
            $message = [
                "messages"=>[
                    'Not enough products error' => 'Warehouse or Shop does not have enough items to delete this entity'
                ]
            ];
            session()->flash('partial_errors', (object) $message);
        }
        return redirect()->back();
    }
}
        