<html>
    <head>
        <title>Счет фактура</title>
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css" rel="stylesheet" />
        <style>
            body{
                font-size: 16px;
                background: rgb(204, 204, 204);
            }
            *{
                color: black !important;
            }
            div.page {
                background: white;
                display: block;
                font-family: sans-serif;
                margin: 0 auto;
                margin-bottom: 0.5cm;
                box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            }
            div.page[size="A4"] {
                width: 21cm;
                height: 29.7cm;
                
            }
            div.page[size="A4"][layout="landscape"] {
                width: 29.7cm;
                height: 21cm;
                padding: 15px;
            }
            @media print {
                @page {
                    size: landscape;
                }
                .not-printed {
                    display: none !important;
                }
                body,
                div.page {
                    margin: 0;
                    box-shadow: unset;
                }
                .container{
                    max-width: unset !important;
                    width: unset !important;
                }
                .row{
                    display: flex;
                    flex-direction: row;
                }
                .col-md-6{
                    flex-basis: 50%;
                }
            }
            table {
                margin-top: 15px;
                border-collapse: collapse;
                width: 100%;
                table-layout: fixed;
                overflow-wrap: break-word;
                font-size: 13px;
            }
            th, td {
                border: 1px solid black;
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <button onclick="window.print()" class="not-printed">
            Распечатать
        </button>
        <div class="page" size="A4" layout="landscape">
            <div class="container">
                <h4 class="mb-5 text-center">
                    Yuk xati/Накладная № {{ str_pad($order->esf_no, 4, '0', STR_PAD_LEFT ) }}
                </h4>
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div>Kimdan/От кого</div>
                        <div >
                            <h5>"PROTOOLS" mas’uliyati cheklangan jamiyati</h5> 
                            <b>ИНН:</b> 307132732 <br>
                            <b>Адресс:</b> Toshkent shahri, Olmazor tumani, QORA-QAMISH-2/1-MAVZESI, 16-UY, 4-XONA <br>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="text-align:right">Kimga/Кому</div>
                        <div  style="text-align:right">
                            <h5> {{ $order->client->full_name }} {{ $order->client->get_region_name() }} </h5> 
                            <b>Телефон: </b> {{ $order->client->phone_number }} <br>
                            @if($order->client->client_type==1)
                            <b>ИНН:</b> {{ $order->client->inn }} <br>
                            @endif
                        </div>
                    </div>
                </div>
                <table border="1">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Nomi <br> Название</th>
                            <th>Uchl.bir <br> Ед. изм.</th>
                            <th>Soni <br> Кол-во</th>
                            <th>Narxi <br> Цена</th>
                            <th>Summasi <br> Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index=>$item)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->product->metric?$item->product->metric->name:''}}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price}}</td>
                                <td>{{ $item->quantity * $item->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <h6>Berdim/Отдал __________</h6>
                    </div>
                    <div class="col-md-6">
                        <h6 style="text-align:right">Oldim/Получил __________</h6>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>