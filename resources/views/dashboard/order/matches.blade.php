@extends('layouts.appWithoutSidebar')

@section('content')
    <div class="card-body">
        <h4>FULL MATCH</h4>
        @if(session('message'))
            <div class="p-3 alert alert-danger text-white">
                {{ session('message') }}
            </div>
        @endif
        <table class="table table-striped text-center mb-5">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Отправить запрос</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fullMatches as $fm)
                <tr>
                    <td>{{ $fm->name }}</td>
                    <td>
                        <form action="{{route('order.openTransfer', ['order'=>$order, 'point'=>$fm])}}">
                            <button class="btn btn-warning btn-sm mb-0">Отправить запрос</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr/>
        <h4>PARTIAL MATCH</h4>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Matching</th>
                    <th>Отправить запрос</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partialMatches as $pm)
                <tr>
                    <td>{{ $pm->get('shop')->name }}</td>
                    <td>
                        <ul>
                            @foreach($pm->get('items') as $item)
                                <li>
                                    {{$item->product->name}} - {{$item->quantity}}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <form action="{{ route('order.openTransferPartial', ['order'=>$order, 'point'=> $pm->get('shop')]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="items" value="{{ $pm->get('items')->toJson() }}">
                            <button class="btn btn-warning btn-sm mb-0">Отправить запрос</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection