@extends('layouts.app')

@section('content')

    <div class="card-header-primary">
        Материальные отчёты - Остаток товаров (1.1)
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
            						

                <tr class="text-secondary ">
                    <th>
                        <small>
                        Филиал
                        </small>
                    </th>
                    <th>
                        <small>
                        Продукт
                        </small>
                    </th>
                    <th>
                        <small>
                        Количество
                        </small>
                    </th>
                    <th>
                        <small>
                        Категория
                        </small>
                    </th>
                    <th>
                        <small>
                        Бренд
                        </small>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $r)
                <tr>
                    <td>{{$r->point_name}}</td>
                    <td>{{$r->product_name}}</td>
                    <td>{{$r->total_count}}</td>
                    <td>{{$r->category_name ?? '-'}}</td>
                    <td>{{$r->brand_name ?? '-'}}</td>              
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection