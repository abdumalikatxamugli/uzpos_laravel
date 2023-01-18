<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{
    public function main(){
        return view("dashboard.main");
        // return redirect()->route('dashboard.orders.index', 2);
    }
}
