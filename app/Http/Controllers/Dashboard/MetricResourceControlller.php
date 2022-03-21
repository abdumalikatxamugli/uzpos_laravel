<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Metric\StoreRequest;
use App\Models\Metric;
use App\Models\User;
use Illuminate\Http\Request;

class MetricResourceControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metrics = Metric::paginate(10);
        return view('dashboard.metric.index')->with('metrics', $metrics);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.metric.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, User $user)
    {
        $validated = $request->validated();
        Metric::createFromArrayWithUser($validated, $user);
        return redirect()->route('dashboard.metric.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Metric  $metric
     * @return \Illuminate\Http\Response
     */
    public function show(Metric $metric)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Metric  $metric
     * @return \Illuminate\Http\Response
     */
    public function edit(Metric $metric)
    {
        return view('dashboard.metric.edit')->with('metric', $metric);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Metric  $metric
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Metric $metric)
    {
        $metric->updateFromArray($request->validated(), $metric->id);
        return redirect()->route('dashboard.metric.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Metric  $metric
     * @return \Illuminate\Http\Response
     */
    public function destroy(Metric $metric)
    {
        $metric->delete();
        return redirect()->route('dashboard.metric.index');
    }
}
