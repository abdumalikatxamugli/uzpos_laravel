@extends('layouts.app')

@section('content')

    <div class="card-header-primary d-flex justify-content-between">
        Материальные отчёты - Остаток товаров (1.1)
        <a href="{{route('dashboard.report_1_1_download')}}" class="btn btn-primary bg-white text-primary">
            <i class="material-icons">download</i>
        </a>
    </div>
    <form class="card-body">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th>
                        <select name="division_id" id="" class="form-control">
                            @foreach($divisions as $division)
                                <option value="{{$division->id}}">{{$division->name}}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <select name="product_id" id="" class="form-control">
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        
                    </th>
                    <th>
                        <select name="category_id" id="" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <select name="brand_id" id="" class="form-control">
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <button class="btn btn-success">
                            <i class="material-icons">search</i>
                        </button>
                    </th>
                </tr>
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