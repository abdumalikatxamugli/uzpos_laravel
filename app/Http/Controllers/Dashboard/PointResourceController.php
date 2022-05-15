<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Point\StoreRequest;
use App\Http\Requests\Point\UpdateRequest;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;

class PointResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points = Point::orderByDesc('created_at')->paginate(10);
        return view("dashboard.point.index")->with("points", $points);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.point.create");
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
        Point::createFromArrayWithUser($validated, $user);
        return redirect()->route("dashboard.point.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Point $point
     * @return \Illuminate\Http\Response
     */
    public function show(Point $point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Point $point
     * @return \Illuminate\Http\Response
     */
    public function edit(Point $point)
    {
        return view("dashboard.point.edit")->with("point", $point);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Point $point)
    {
        $point->updateFromArray($request->validated(), $point->id);
        return redirect()->route("dashboard.point.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        $point->delete();
        return redirect()->route("dashboard.point.index");
    }
}
