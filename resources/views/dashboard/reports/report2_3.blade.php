@extends('layouts.app')

@section('content')

    <div class="card-header-primary">
        Отчеты по продажам - по рознице ( 2.3 ) 
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
            						

                <tr class="text-secondary ">
                    <th>
                        <small>
                        ТОЧКА
                        </small>
                    </th>
                    <th>
                        <small>
                        НАИМЕНОВАНИЕ
                        </small>
                    </th>
                    <th>
                        <small>
                         ШТ
                        </small>
                    </th>
                    <th>
                        <small>
                        ШТРИХ-КОД
                        </small>
                    </th>
                    <th>
                        <small>   
                        СУММА
                        </small>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $r)
                <tr>
                    <td>{{$r->point_name}}</td>
                    <td>{{$r->product_name}}</td>
                    <td>{{$r->total_quantity}}</td>
                    <td>{{$r->bar_code}}</td>
                    <td>{{$r->total_price}}</td>              
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection