@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h4 class="d-flex justify-content-between mb-5">
            <span>Список долгов клиентов</span>
        </h4>
        <table class="table text-center" style="font-size:12px">
            <thead>
                <tr>
                    <td>Клиент</td>
                    <td>Долг</td>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $index=>$result)
                <tr>
                    <td>{{ $result->client_type == 0 ? $result->lname.' '.$result->fname : $result->company_name }}</td>
                    <td>{{ $result->debt }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
