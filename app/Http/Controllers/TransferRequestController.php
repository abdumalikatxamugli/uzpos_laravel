<?php

namespace App\Http\Controllers;

use App\Models\TransferRequest;
use App\Models\TransferRequestItem;
use Illuminate\Http\Request;

class TransferRequestController extends Controller
{
    public function createRequest(Request $request)
    {
        $transferRequest = new TransferRequest();
        $transferRequest->from_division_id = $request->input('from_division_id');
        $transferRequest->to_division_id = $request->input('to_division_id');
        $transferRequest->created_by_id = auth()->user()->id;
        $transferRequest->save();
        $transferRequestItem = new TransferRequestItem();
        $transferRequestItem->transfer_request_id = $transferRequest->id;
        $transferRequestItem->product_id = $request->input('product_id');
        $transferRequestItem->quantity = $request->input('quantity');
        $transferRequestItem->save();
        return view('dashboard.transferRequest.completeRequest');
    }
    public function list()
    {
        $requests = TransferRequest::where('from_division_id', auth()->user()->division_id)->paginate(10);
        return view('dashboard.transferRequest.list')->with('requests', $requests);
    }
}
