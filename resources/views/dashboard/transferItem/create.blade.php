<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="card-body">
    <h5 class="font-weight-bold mb-3">Добавить товар</h5>
    <form action="{{ route('dashboard.transferItem.store') }}" method="POST">
        @csrf
        <input type="hidden" name="transfer_id" value="{{ $transfer->id }}">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-2">Продукт</div>
                <select name="product_id" class="form-control mb-3" id="product_id">
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
        <button class="btn btn-sm font-weight-bold btn-info px-4 mt-4">
            <i class="material-icons">check</i>
        </button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#product_id').select2();
    });
</script>

