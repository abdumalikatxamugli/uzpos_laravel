@extends('layouts.appWithoutSidebar')

@section('content')
    <div class="card-body" x-data="start()">
        <h4 class="d-flex justify-content-between">
            <span>Выбрать клиента</span>
            <button x-bind:class="formOpen?'btn btn-sm mb-0 btn-danger':'btn btn-sm mb-0 btn-info'" x-on:click="formOpen = !formOpen" x-text="formOpen?'Назад':'Добавить'">
            </button>
        </h4>
        <hr/>
        <template x-if="formOpen">  
            <div class="mb-5" >
                <div class="row">
                    <div class="col-md-6">
                        <input type="radio" value="1" id="client_type_yur" x-model = "client.client_type" name="client_type">
                        <label for="client_type_yur">Юридическое лицо</label>
                    </div>
                    <div class="col-md-6">
                        <input type="radio" value="0"  id="client_type_fiz" x-model = "client.client_type" name="client_type">
                        <label for="client_type_fiz">Физическое лицо</label>
                    </div>
                </div>
                <template x-if="client.client_type == 0">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="client_pinfl">ПИНФЛ</label>
                            <input type="text" class="form-control" id="client_pinfl" x-model="client.pinfl" maxlength="14">
                        </div>
                        <div class="col-md-2">
                            <label for="client_psery">Паспорт серия</label>
                            <input type="text" class="form-control" id="client_psery" x-model="client.psery" maxlength="2">
                        </div>
                        <div class="col-md-3">
                            <label for="client_pnumber">Паспорт номер</label>
                            <input type="text" class="form-control" id="client_pnumber" x-model="client.pnumber" maxlength="7">
                        </div>
                        <div class="col-md-3">
                            <label for="client_occupation">Профессия</label>
                            <input type="text" class="form-control" id="client_occupation" x-model="client.occupation">
                        </div>
                        <div class="col-md-4">
                            <label for="client_fname">Имя</label>
                            <input type="text" class="form-control" id="client_fname" x-model="client.fname">
                        </div>
                        <div class="col-md-4">
                            <label for="client_lname">Фамилия</label>
                            <input type="text" class="form-control" id="client_lname" x-model="client.lname">
                        </div>
                        <div class="col-md-4">
                            <label for="client_mname">Отчество</label>
                            <input type="text" class="form-control" id="client_mname" x-model="client.mname">
                        </div>
                        <div class="col-md-4">
                            <label for="client_dbirth">Дата рождения</label>
                            <input type="date" class="form-control" id="client_dbirth" x-model="client.dbirth">
                        </div>
                    </div>
                </template>
                <template  x-if="client.client_type == 1">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="client_inn">ИНН</label>
                            <input type="text" class="form-control" id="client_inn" x-model="client.inn" maxlength="9">
                        </div>
                        <div class="col-md-6">
                            <label for="client_company_name">Название</label>
                            <input type="text" class="form-control" id="client_company_name" x-model="client.company_name">
                        </div>
                    </div>
                </template>
                <div class="row">
                    <div class="col-md-6">
                        <label for="client_phone_number">Телефон</label>
                        <input type="text" class="form-control" id="client_phone_number" x-model="client.phone_number" maxlength="9">
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button class="btn btn-warning btn-sm mb-0 w-100" x-on:click="saveClient">Сохранить и прикрепит к заказу</button>
                    </div>
                </div>
            </div>
        </template>
        <template x-if="!formOpen">
            <div>
                <form class="row mb-5">
                    <div class="col-md-4">
                        <select name="attribute" class="form-control">
                            <option value="phone_number">Телефон</option>
                            <option value="client_no">Номер клиента</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="value" class="form-control">
                    </div>
                    <div class="col-md-4 d-flex align-items-center" style="gap:5px">
                        <button class="btn btn-danger btn-sm w-50 mb-0">Поиск</button>
                        <a href="{{ route('dashboard.order.client.select', $order) }}" class="btn btn-danger btn-sm w-50 mb-0">Показать все</a>
                    </div>
                </form>
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>Выбрать</td>
                            <td>Номер клиента</td>
                            <td>Телефон</td>
                            <td>Тип</td>
                            <td>ФИО/Название</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="appendOrder('{{ $client->id }}')">Выбрать</button>
                            </td>
                            <td>{{ $client->client_no }}</td>
                            <td>{{ $client->phone_number }}</td>
                            <td>{{ $client->client_type_name }}</td>
                            <td>{{ $client->fullName }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $clients->links() }}
                </div>
            </div>
        </template>
        <script>
            function appendOrder(client){
                const url = `/dashboard/client/append/{{$order->id}}/${client}`;
                fetch(url).then(json=>json.json())
                          .then(response=>{
                              if(response.error===0){
                                  window.opener.triggerRefresh();
                                  window.close();
                              }
                          })
                          .catch(err=>console.log(err))
            }
            function start(){
                return {
                    formOpen:false,
                    client:{
                        client_type: 0,
                        psery: null,
                        pnumber: null,
                        pinfl: null,
                        fname: null,
                        lname: null,
                        mname: null,
                        inn: null,
                        company_name: null,
                        occupation: null,
                        phone_number: null
                    },
                    saveClient: function(){
                        const data = this.client
                        const url = `/dashboard/client/append/{{$order->id}}`;
                        fetch(url, {
                            method: 'POST', 
                            mode: 'cors', 
                            cache: 'no-cache', 
                            credentials: 'same-origin', 
                            headers: {
                              'Content-Type': 'application/json'
                            },
                            redirect: 'follow', 
                            referrerPolicy: 'no-referrer', 
                            body: JSON.stringify(data)
                        }).then(json=>json.json())
                          .then(response=>{
                              if(response.error===0){
                                  window.opener.triggerRefresh();
                                  window.close();
                              }
                              if(response.error == -1 && response.messages){
                                  alert("Ошибки возникли:"+JSON.stringify(response.messages));
                              }
                              if(response.error == -1 && !response.messages){
                                  alert("Возникла непредвиденная ошибка");
                              }
                          })
                          .catch(err=>alert(err))
                    }    
                }
            }
        </script>
    </div>
@endsection
