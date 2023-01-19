@if(count($order->items) == 0)
    <div class="alert text-danger">Нелзя оформить пустой заказ</div>
@else

    @if(!$order->hasEnoughPayment())
        <div class="alert text-danger ">У заказа недостаточно оплаты</div>
    @endif

    @if(!$order->hasEnoughItems())
        <div class="alert text-danger border border-danger p-3 text-lg d-flex justify-content-between align-items-center">
            <span>
                В хранилище недостаточно товара для оформления заказа
            </span>
            @if( $order->from_point_id == $order->shop_id )
                <button class="btn btn-primary btn-sm mb-0" onclick="searchPointProduct()">Поискать у других складов и магазинов</button>
            @endif
        </div>
    @endif
    
    @if(!$order->client)
        <div class="alert text-danger border border-danger ">
            Заказу не привязан клиент
        </div>
    @endif

@endif

<script>
    function searchPointProduct(){
        window.open(`{{ route('order.searchAvailableItems', $order->id) }}`, 'name' + Math.random(), 'width=1200,height=800');
    }
</script>