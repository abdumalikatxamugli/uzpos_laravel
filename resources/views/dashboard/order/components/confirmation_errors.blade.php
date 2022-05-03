@if(count($order->items) == 0)
    <div class="alert text-danger">Нелзя оформить пустой заказ</div>
@else

    @if(!$order->hasEnoughPayment())
        <div class="alert text-danger">У заказа недостаточно оплаты</div>
    @endif

    @if(!$order->hasEnoughItems())
        <div class="alert text-danger">
            В хранилище недостаточно товара для оформления заказа
            <button class="btn btn-primary btn-sm mb-0" onclick="searchPointProduct()">Поискать у других складов и магазинов</button>
        </div>
    @endif
    
    @if(!$order->client)
        <div class="alert text-danger">Заказу не привязан клиент</div>
    @endif

@endif

<script>
    function searchPointProduct(){
        window.open(`{{ route('order.searchAvailableItems', $order->id) }}`, 'name' + Math.random(), 'width=1200,height=800');
    }
</script>