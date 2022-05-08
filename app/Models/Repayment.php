<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    /**
     * custom functions
     */
    public static function repay($repayment_date, $repayment_amount, $payment){
        $repayment = new self();
        $repayment->repayment_date = $repayment_date;
        $repayment->amount = $repayment_amount;
        $repayment->payment_id = $payment->id;
        $repayment->created_by_id = auth()->user()->id;
        $repayment->save();
    }
}
