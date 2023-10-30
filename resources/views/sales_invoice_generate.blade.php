<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Sales Invoice Print DR!</title>

    <style type="text/css">
        .page-header,
        .page-header-space {
            height: 320px;
        }

        .page-footer,
        .page-footer-space {
            height: 400px;

        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;

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

<body onafterprint="myFunction()">

    <br />

    <div class="row">

        {{-- <div class="page-header">
            <div class="col-md-12">
                <table class="table table-borderless table-sm"
                    style="text-align: center; font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;">JULMAR COMMERCIAL INC.</th>
                        </tr>
                        <tr>
                            <th>St Ignatius St, Cagayan de Oro, Misamis Oriental</th>
                        </tr>
                        <tr>
                            <th>Tel No: 881-9973 / 09177058232</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-borderless table-sm"
                    style="text-align: left; font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;">
                    <thead>
                        <tr>
                            <th><span class="float-right">Bill To: </span></th>
                            <th>{{ $sales_invoice->customer->store_name }}</th>
                        </tr>
                        <tr>
                            <th><span class="float-right">Store Code: </span></th>
                            <th>{{ $customer_principal_code->store_code }}</th>
                        </tr>
                        <tr>
                            <th style="vertical-align: top"><span class="float-right">Address: </span></th>
                            <th style="width:50%">{{ $sales_invoice->customer->detailed_location }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-borderless table-sm"
                    style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;">
                    <thead>
                        <tr>
                            <th style="vertical-align: top"><span class="float-right">DR: </span></th>
                            <th style="text-align: left">{{ $sales_invoice->delivery_receipt }}</th>
                        </tr>
                        <tr>
                            <th style="vertical-align: top"><span class="float-right">Date: </span></th>
                            <th style="text-align: left">{{ $sales_invoice->created_at }}</th>
                        </tr>
                        <tr>
                            <th style="vertical-align: top"><span class="float-right">SO No.: </span></th>
                            <th style="width:50%;text-align:left">{{ $sales_invoice->sales_order->sales_order_number }}
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-borderless table-sm"
                    style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;">
                    <thead>
                        <tr>
                            <th style="vertical-align: top"><span class="float-right">Area: </span></th>
                            <th style="text-align: left">{{ $sales_invoice->customer->location->location }}</th>
                        </tr>
                        <tr>
                            <th><span class="float-right">Transaction: </span></th>
                            <th style="text-align: left">{{ $sales_invoice->mode_of_transaction }}</th>
                        </tr>
                        <tr>
                            <th style="vertical-align: top"><span class="float-right">Salesman: </span></th>
                            <th style="width:50%;text-align:left">{{ $sales_invoice->agent->full_name }}</th>
                        </tr>
                        <tr>
                            <th style="vertical-align: top"><span class="float-right">Terms: </span></th>
                            <th style="width:50%;text-align:left">{{ $sales_invoice->customer->credit_term }}</th>
                        </tr>
                        <tr>
                            <th style="vertical-align: top"><span class="float-right">Due Date: </span></th>
                            <th style="width:50%;text-align:left"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div> --}}

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
                            {{ $sales_invoice->customer->store_name }}</th>
                        <th style="width:20%;line-height:0px"><span class="float-right">Dr Number:</span></th>
                        <th style="width:30%;line-height:0px">{{ $sales_invoice->delivery_receipt }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="line-height:0px;"><span class="float-right">Store Code:</span></td>
                        <td style="line-height:0px;">{{ $customer_principal_code->store_code }}</td>
                        <td style="line-height:0px;"><span class="float-right">DR Date :</span></td>
                        <td style="line-height:0px;">{{ $sales_invoice->created_at }}</td>
                    </tr>
                    <tr>
                        <td style="line-height:0px;"><span class="float-right">Address:</span></td>
                        <td style="line-height:0px;">{{ $sales_invoice->customer->detailed_location }}</td>
                        <td style="line-height:0px;"><span class="float-right">SO No:</span></td>
                        <td style="line-height:0px;">{{ $sales_invoice->sales_order->sales_order_number }}</td>
                    </tr>
                    <tr>
                        <td style="line-height:0px;"><span class="float-right">Area:</span></td>
                        <td style="line-height:0px;">{{ $sales_invoice->customer->location->location }}</td>
                        <td style="line-height:0px;"><span class="float-right">CUSTOMER PO NO::</span></td>
                        <td style="line-height:0px;">N/a</td>
                    </tr>
                    <tr>
                        <td style="line-height:0px;"><span class="float-right">Transaction:</span></td>
                        <td style="line-height:0px;">{{ $sales_invoice->mode_of_transaction }}
                        </td>
                        <td style="line-height:0px;"><span class="float-right">Salesman:</span></td>
                        <td style="line-height:0px;">{{ $sales_invoice->agent->full_name }}</td>
                    </tr>
                    <tr>
                        <td style="line-height:0px;"></td>
                        <td style="line-height:0px;"></td>
                        <td style="line-height:0px;"><span class="float-right">Payment Terms:</span></td>
                        <td style="line-height:0px;">{{ $sales_invoice->customer->credit_term }}</td>
                    </tr>
                    <tr>
                        <td style="line-height:0px;"></td>
                        <td style="line-height:0px;"></td>
                        <td style="line-height:0px;"><span class="float-right">Due Date:</span></td>
                        {{-- <td style="line-height:0px;">{{ date('Y-m-d', strtotime($sales_invoice->date. ' + '. $sales_invoice->customer->credit_term)) }}</td> --}}
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-12">
            <table>
                <thead>
                    <tr>
                        <td colspan="2">
                            <!--place holder for the fixed-position header-->
                            <div class="page-header-space"></div>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="col-md-12">
            <br />
            <table class="table table-borderless table-sm"
                style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Desc</th>
                        <th>Uom</th>
                        <th style="text-align: right">Qty</th>
                        <th style="text-align: right">U/P</th>
                        <th style="text-align: right">Sub-Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales_invoice->sales_invoice_details as $details)
                        <tr>
                            <td>{{ $details->sku->sku_code }}</td>
                            <td>{{ $details->sku->description }}</td>
                            <td>{{ $details->sku->unit_of_measurement }}</td>
                            <td style="text-align: right">{{ $details->quantity }}</td>
                            <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                            <td style="text-align: right">
                                @php
                                    $sub_total = $details->quantity * $details->unit_price;
                                    echo number_format($sub_total, 2, '.', ',');
                                    $sum_total[] = $sub_total;
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>




        </div>
    </div>


    <div class="page-footer">

        <div class="container float-right" style="width:50%;">
            @if ($sales_invoice->discount_rate != 'none')
                <table class="table table-borderless table-sm float-right"
                    style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;width:50%;">
                    <tbody>
                        <tr>
                            <th style="text-align: right">GROSS</th>
                            <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                        </tr>
                        @php
                            $total = array_sum($sum_total);
                            $discount_holder = [];
                            $discount_value_holder = $total;
                        @endphp
                        @foreach (explode('-', $sales_invoice->discount_rate) as $data_discount)
                            <tr>
                                <th style="text-align: right">Less - {{ $data_discount }}</th>
                                <th style="text-align: right;width:50px;">
                                    @php
                                        $discount_value_holder_dummy = $discount_value_holder;
                                        $less_percentage_by = $data_discount / 100;

                                        $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                                        $discount_holder[] = $discount_value_holder;
                                        echo number_format($discount_value_holder, 2, '.', ',');
                                    @endphp
                                    <input type="hidden" name="discount_rate[]" value="{{ $data_discount }}">
                                </th>
                            </tr>
                        @endforeach
                        <tr>
                            <th style="text-align: right">Final Total</th>
                            <th style="text-align: right;text-decoration: overline">
                                {{ number_format(end($discount_holder), 2, '.', ',') }}
                                @php
                                    $final_total = end($discount_holder);
                                @endphp
                                <input type="hidden" value="{{ $final_total }}" name="final_total">
                            </th>
                        </tr>
                    </tbody>
                </table>
            @else
                <table class="table table-borderless table-sm float-right"
                    style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;width:50%;">
                    <tbody>
                        <tr>
                            <th style="text-align: right;">TOTAL</th>
                            <th style="text-align: right;width:50px">
                                {{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div><br /><br /><br /><br /><br />
        <br /><br /><br /><br />
        <hr style="border-top: 1px solid black;">
        <div class="container float-left" style="width:50%;">



            RECEIVED FROM JULMAR COMMERCIAL, INC. (<b>{{ $sales_invoice->principal->principal }}</b>)<br />
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
                    <th style="text-transform: uppercase;">{{ $sales_invoice->user->name }}</th>
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

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <script>
        window.print();

        function myFunction() {
            window.location.replace("sales_invoice");
        }
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
