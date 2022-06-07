<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Party\DeleteRequest;
use App\Http\Requests\Party\StoreRequest;
use App\Http\Requests\Party\UpdateRequest;
use App\Models\Item;
use App\Models\Party;
use App\Models\Point;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class PartyResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parties = Party::orderByDesc('created_at')->paginate(10);
        return view("dashboard.party.index")->with("parties", $parties);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.party.create");
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
        $party = Party::createFromArrayWithUser($validated, $user);
        return redirect()->route("dashboard.party.edit", $party);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $party)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Party $party
     * @return \Illuminate\Http\Response
     */
    public function edit(Party $party)
    {
        $points = Point::all();
        $products = Product::all();
        return view("dashboard.party.edit")->with("party", $party)
                                        ->with('products', $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Party $party)
    {
        $party->updateFromArray($request->validated(), $party->id);
        return redirect()->route("dashboard.party.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request, Party $party)
    {
        $party->delete();
        return redirect()->route("dashboard.party.index");
    }
    public function finish(Party $party){
        $party->finishParty();
        return redirect()->back();
    }
    public function finish2(Party $party){
        $party->finishParty2();
        return redirect()->back();
    }
}
        