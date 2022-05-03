<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div x-data="start()" x-init="init()">
    @if(count($order->items) > 0)
        <table class="table text-center table-bordered mb-5" >
            <thead>
                <tr>
                    <th width="2%">#</th>
                    <th class="fs-6 text-success" width="30%">Название</th>
                    <th class="fs-6 text-success" width="10%">Количество</th>
                    <th class="fs-6 text-success">Цена</th>
                    <th class="fs-6 text-success">Общая цена</th>
                    <th class="fs-6 text-success">Убрать</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index=>$item)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->quantity*$item->price}}</td>
                        <td>
                            <form action="{{ route('dashboard.order.item.delete', $item->id) }}">
                                <button class="btn btn-danger btn-sm mb-0">Убрать</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr/>
    @endif
    @include('partials.validation_errors')
    <form action="{{ route('dashboard.order.items.save') }}" method="POST">
        @csrf
        <table class="table text-center table-bordered" >
            <thead>
                <tr>
                    <th width="2%">#</th>
                    <th class="fs-6 text-info" width="30%">Название</th>
                    <th class="fs-6 text-info" width="10%">Количество</th>
                    <th class="fs-6 text-info">Цена</th>
                    <th class="fs-6 text-info">Общая цена</th>
                    <th class="fs-6 text-info">Убрать</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, index) in items">   
                    <tr>
                        <td x-text="index+1"></td>
                        <td>
                            <input type="hidden" x-bind:name="'items['+index+'][order_id]'" value="{{ $order->id }}">
                            <select x-bind:name="'items['+index+'][product_id]'" id="" class="form-control" x-model="item.product_id" x-init="init_row($el, index)">
                                <option></option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input  x-bind:name="'items['+index+'][quantity]'"  type="number" class="form-control" x-model="item.quantity">
                        </td>
                        <td>
                            <input type="hidden" x-bind:name="'items['+index+'][price]'" x-model="item.cost">
                            <span x-text="item.cost"   ></span>
                        </td>
                        <td>
                            <span x-text="new Intl.NumberFormat().format(item.quantity * item.cost)" ></span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm mb-0" x-on:click="removeItem(index)">Убрать</button>
                        </td>
                    </tr>
                </template>
                
                <tr>
                    <td></td>
                    <td class="text-secondary">Итого</td>
                    <td x-text="calcTotalQuantity"></td>
                    <td></td>
                    <td x-text="calcTotalCost"></td>
                </tr>
            </tbody>
        </table>
    
        <div class="d-flex align-items-center justify-content-center">
            <button type="button" class="btn btn-info p-3" x-on:click="addItem">
                ещё
            </button>
        </div>
        <hr/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-lg">Сохранить</button>       
        </div>
    </form>
</div>
<script>
    function start() {
        
        return {
            items: [{product_id:null, quantity:null, cost:null},{product_id:null, quantity:null, cost:null}],
            init : function(){
                this.products = JSON.parse(`{!! json_encode($products) !!}`);
            },
            init_row: function(el, index){
               const app = this
               $(el).select2({placeholder:'Выберите продукт', allowClear:true})
                                        .on("change", changeEventHandler.bind(app, index))

               function changeEventHandler(index, event){
                    if(event.target.value){
                        const product_id = event.target.value
                        this.items[index].cost = this.products[product_id].bulk_price;
                    }else{
                        this.items[index].cost = 0;
                    }
               }
            },
            calcTotalQuantity: function(){
                var totalQuantity = 0;
                for(let i=0; i<this.items.length; i++){
                    totalQuantity += Number(this.items[i].quantity);
                }
                return new Intl.NumberFormat().format(totalQuantity);
            },
            calcTotalCost: function(){
                var totalCost = 0;
                for(let i=0; i<this.items.length; i++){
                    totalCost += Number(this.items[i].cost*this.items[i].quantity);
                }
                return new Intl.NumberFormat().format(totalCost);
            },
            addItem: function(){
                let defaultItem = {product_id:null, quantity:null, cost:null}
                this.items.push(defaultItem)
            },
            removeItem: function(index){
                this.items.splice(index, 1);
            }
        }   
    }
</script>
