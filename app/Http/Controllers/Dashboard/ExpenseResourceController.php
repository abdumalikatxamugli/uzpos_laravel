<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreRequest;
use App\Http\Requests\Expense\UpdateRequest;
use App\Models\Expense;
use App\Models\User;


class ExpenseResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        switch(auth()->user()->user_role){
            case User::roles['ADMIN'] : 
                $expenses = Expense::orderBy('id')->paginate(10);
                break;
            default:
                $expenses = Expense::where('division_id', auth()->user()->division_id)->orderBy('id')->paginate(10);        
        }
        return view("dashboard.expense.index")->with("expenses", $expenses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.expense.create");
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
        $validated['division_id'] = auth()->user()->division_id;
        Expense::createFromArrayWithUser($validated, $user);
        return redirect()->route("dashboard.expense.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        return view("dashboard.expense.edit")->with("expense", $expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Expense $expense)
    {
        $expense->updateFromArray($request->validated(), $expense->id);
        return redirect()->route("dashboard.expense.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route("dashboard.expense.index");
    }
}
        