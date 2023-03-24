<h5 class="mb-5 d-flex justify-content-between">
    <b>Оплата</b>
</h5>
<table class="table table-bordered text-center mb-5">
    <thead>
        <tr>
            <td>Дата оплаты</td>
            <td>Тип оплаты</td>
            <td>Сумма</td>
            <td>Убрать</td>
        </tr>
    </thead>
    <tbody>
        @foreach($order->payments as $payment)
        <tr>
            <td>
                {{ $payment->payment_date }}
            </td>
            <td>
                {{ $payment->payment_type_name }}
            </td>
            
            <td>
                {{ $payment->amount }}
            </td>
            <td>
                @if($order->status == 1 && $order->shop_id == auth()->user()->point_id)
                    <form action="{{route('order.payments.delete', $payment->id)}}">
                        @csrf
                        <button class="btn btn-danger btn-sm mb-0">
                            <i class="material-icons">close</i>
                        </button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<hr/>

@if($order->status == 1 && $order->division_id == auth()->user()->division_id && !$order->hasEnoughPayment())
    <form action="{{route('order.append.payments')}}" method="POST" x-data="paymentManager()">
        @csrf
        <div>
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="row">
                <div class="col-md-3">
                    <label>Сумма к оплате</label>
                    <input type="text" readonly name="amount" class="form-control px-2" value="{{round( $order->getTotalCost() - $order->getTotalPaid() )}}">
                </div>
                <div class="col-md-3">
                    <label>Дата оплаты</label>
                    <input type="date" class="form-control px-2" name="payment_date" value="{{ date('Y-m-d') }}" readonly>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label>Тип оплаты</label>
                    <select class="form-control px-2" name="payment_type" >
                        @foreach($payment_types as $ptype)
                            <option value="{{ $ptype['code'] }}" {{ $ptype['code']==1?'selected':'' }} >{{ $ptype['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Оплачено</label>
                    <input type="text" class="form-control px-2" name="payed_amount" x-model="payedAmount">
                </div>
                <div class="col-md-2">
                    <label>На валюте</label>
                    <select class="form-control px-2" name="payed_currency_type">
                        @foreach($currencies as $ptype)
                            <option value="{{ $ptype['code'] }}" {{ $ptype['code'] == 1 ? 'selected':'' }}>{{ $ptype['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>По курсу</label>
                    <input type="text" class="form-control px-2" name="payed_currency_rate" x-model="payedCurrencyRate">
                </div>
                <div class="col-md-2">
                    <label>Пересчет в долларах</label>
                    <input type="text" class="form-control px-2" readonly x-bind:value="payedAmountUsd()">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label>Возврщено</label>
                    <input type="text" class="form-control px-2" name="change_amount" x-model="changeAmount">
                </div>
                <div class="col-md-3">
                    <label>На валюте</label>
                    <select class="form-control px-2" name="change_currency_type">
                        @foreach($currencies as $ptype)
                            <option value="{{ $ptype['code'] }}" {{ $ptype['code'] == 1 ? 'selected':'' }}>{{ $ptype['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>По курсу</label>
                    <input type="text" class="form-control px-2" name="change_currency_rate" x-model="changeCurrencyRate">
                </div>
                <div class="col-md-2">
                    <label>Пересчет в долларах</label>
                    <input type="text" class="form-control px-2" readonly x-bind:value="changeAmountUsd()">
                </div>
                <div class="col-md-2 d-flex align-items-end justify-content-end">
                    <button class="btn btn-info">
                        <i class="material-icons">check</i>
                    </button>
                </div>
            </div>
        </div>           
    </form> 
@endif
<hr>
<script>
    function paymentManager()
    {
        return {
            payedAmount:Number("{{round( $order->getTotalCost() - $order->getTotalPaid() )}}"),
            payedCurrencyRate:1,
            payedAmountUsd: function()
            {
                if(this.payedCurrencyRate === 0 )
                {
                    return 0;
                }
                return this.payedAmount / this.payedCurrencyRate;
            },
            changeAmount:0,
            changeCurrencyRate:1,
            changeAmountUsd:function()
            {
                if(this.changeCurrencyRate === 0)
                {
                    return 0;
                }
                return this.changeAmount / this.changeCurrencyRate;
            }
        }
    }
</script>