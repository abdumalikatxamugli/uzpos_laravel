@extends('layouts.appWithoutSidebar')

@section('content')
    <div class="card-body">
        <h4>FULL MATCH</h4>
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
                        <button class="btn btn-warning btn-sm mb-0">Отправить запрос</button>
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
                        <button class="btn btn-warning btn-sm mb-0">Отправить запрос</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection