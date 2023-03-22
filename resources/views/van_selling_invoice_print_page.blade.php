<!DOCTYPE html>
<html>
<link rel="stylesheet" href="{{ asset('/adminLte/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('/adminLte/dist/css/adminlte.min.css') }}">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

<head>
    <style type="text/css">
        /* Styles go here */

        .page-header,
        .page-header-space {
            height: 280px;
        }

        .page-footer,
        .page-footer-space {
            height: 170px;

        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid black;
            /* for demo */
            background: yellow;
            /* for demo */
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            border-bottom: 1px solid black;
            /* for demo */
            background: yellow;
            /* for demo */
        }

        .page {
            page-break-after: always;
        }

        @page {
            margin: 20mm
        }

        @media print {
            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            button {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body onload="myFunction()">

    <div class="page-header">
        <center>
            <h4 style="font-weight: bold;">JULMAR COMMERCIAL INC.</h4>
            <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
            <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
        </center>
        <br />
        <h5 style="text-align: center;font-weight: bold;">Delivery Receipt</h5>
        <table class="table table-borderless" style="border:none;"> {{-- class='table table-borderless' --}}
            <thead>
                <tr>
                    <th style="width:20%;line-height:0px"><span class="float-right">Bill To:</span></th>
                    <th style="width:30%;line-height:0px;text-transform: uppercase;">
                        {{ $van_selling->customer->store_name }}</th>
                    <th style="width:20%;line-height:0px"><span class="float-right">Dr Number:</span></th>
                    <th style="width:30%;line-height:0px">{{ $van_selling->delivery_receipt }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="line-height:0px;"><span class="float-right">Store Code:</span></td>
                    <td style="line-height:0px;">{{ $customer_principal_code->store_code }}</td>
                    <td style="line-height:0px;"><span class="float-right">DR Date :</span></td>
                    <td style="line-height:0px;">{{ $van_selling->date }}</td>
                </tr>
                <tr>
                    <td style="line-height:0px;"><span class="float-right">Area:</span></td>
                    <td style="line-height:0px;">{{ $van_selling->customer->location->location }}</td>
                    <td style="line-height:0px;"><span class="float-right">CUSTOMER PO NO::</span></td>
                    <td style="line-height:0px;">N/a</td>
                </tr>
            </tbody>
        </table>
    </div>



    <table style="width:100%;">
        <thead>
            <tr>
                <td colspan="2">
                    <div class="page-header-space"></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Desc</th>
                <th>Sku Type</th>
                <th style="text-align: right">Quantity</th>
                <th style="text-align: right">U/P</th>
                <th style="text-align: right">Sub-Total</th>
            </tr>
            @foreach ($van_selling->vs_withdrawal_details as $data)
                <tr>
                    <td><span style="color:green;font-weight:bold;">{{ $data->sku->sku_code }}</span> -
                        {{ $data->sku->description }}</td>
                    <td>{{ $data->sku->sku_type }}</td>
                    <td style="text-align:right">{{ $data->quantity }}</td>
                    <td style="text-align:right">{{ number_format($data->unit_price, 2, '.', ',') }}</td>
                    <td style="text-align: right;">
                        @php
                            $total = $data->quantity * $data->unit_price;
                            $sum_quantity[] = $data->quantity;
                            $sum_total[] = $total;
                            echo number_format($total, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            @endforeach
            <tr>
                <th>Total</th>
                <th></th>
                <th style="text-align:right">{{ array_sum($sum_quantity) }}</th>
                <th></th>
                <th style="text-align:right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <div class="page-footer-space"></div>
                </td>
            </tr>
        </tfoot>
    </table>




    <div class="page-footer">
        <div class="container float-left" style="width:50%;">
            RECEIVED FROM JULMAR COMMERCIAL, INC. (<b>{{ $van_selling->principal->principal }}</b>)<br />
            THE FOLLOWING MERCHANDISE AS ORDERED ABOVE IN GOOD ORDER<br />
            AND MERCHANTIBLE CONDITION
        </div><br /><br />
        <table class="table table-borderless table-sm">
            <thead>
                <tr>
                    <td colspan="9">&nbsp;</td>
                </tr>
                <tr>
                    <th>Prepared By:</th>
                    <th style="text-transform: uppercase;">{{ $employee_name->name }}</th>
                    <th>Released By:</th>
                    <th>_______________</th>
                    <th>Delivered By:</th>
                    <th>_______________</th>
                    <th>Received By/Customer:</th>
                    <th>_______________</th>
                </tr>
            </thead>
        </table>
    </div>


    <form>
        <input type="hidden" id="van_selling_id" value="{{ $van_selling->id }}">
    </form>


    <script src="{{ asset('adminLte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        function myFunction() {
            window.print();

        }
        window.onafterprint = function(event) {
            window.location.href = 'van_selling_invoice'
        };
    </script>
