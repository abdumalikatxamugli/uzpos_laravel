@include('partials.validation_errors')

<div class="card-body">
    <form action="{{ route('dashboard.transferItem.store') }}" method="POST">
        @csrf
        <input type="hidden" name="transfer_id" value="{{ $transfer->id }}">
        <div class="row">
            <div class="col-md-6">
                <div>Продукт</div>
                <select name="product_id" class="form-control mb-3">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <div>Количество</div>
                <input type="number" name="quantity" class="form-control mb-3">
            </div>
        </div>
        <button class="btn btn-sm font-weight-bold btn-info">Добавить</button>
    </form>
</div>


