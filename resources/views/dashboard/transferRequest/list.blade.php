@extends('layouts.app')

@section('content')
@include('partials.queryException')
<div class="card-header-primary mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">
            Запросы на перемешения
            
        </h3>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
    <table class="table text-center">
        <thead>
            <tr>
                <th class="small-text" width="10%">#</th>
                <th class="small-text">От</th>
                <th class="small-text">К</th>
                <th class="small-text">Запрос</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $number => $request)
                <tr>
                    <td>{{$number+1}}</td>
                    <td class="mb-0 text-sm">{{$request->from_division->name}}</td>
                    <td class="mb-0 text-sm">{{$request->to_division->name}}</td>
                    <td class="mb-0 text-sm">
                        @foreach($request->items as $item)
                            <ul style="list-style:none">
                                <li>
                                    {{$item->product->name}} 
                                    -
                                    {{$item->quantity}}
                                </li>
                            </ul>
                        @endforeach
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $requests->links() }}
</div>

@endsection
