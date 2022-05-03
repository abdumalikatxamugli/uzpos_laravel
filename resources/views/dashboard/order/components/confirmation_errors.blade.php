@if(count($order->items) == 0)
    <div class="alert alert-danger">Нелзя оформить пустой заказ</div>
@else

    @if(!$order->hasEnoughPayment())
        <div class="alert alert-danger">У заказа недостаточно оплаты</div>
    @endif

    @if(!$order->hasEnoughItems())
        <div class="alert alert-danger">В хранилище недостаточно товара для оформления заказа</div>
    @endif
    
    @if(!$order->client)
        <div class="alert alert-danger">Заказу не привязан клиент</div>
    @endif

@endif