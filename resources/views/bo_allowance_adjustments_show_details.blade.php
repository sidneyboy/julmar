<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">

    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <center>
                    <h2 class="page-header">
                        JULMAR COMMERCIAL. INC,
                    </h2>
                </center>
            </div>
            <!-- /.col -->
        </div><br />

        <div class="row">
            <div class="col-sm-12">
                <center>
                    <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
                    <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
                </center>
                <br />
                <center>
                    <span style="font-weight: bold;font-size:18px;">BO ALLOWANCE ADJUSTMENTS #:
                        ({{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }})
                    </span><br />
                </center>
                <br />
                @php
                    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                @endphp


                <center>
                    {!! $generator->getBarcode($bo_adjustments_details[0]->bo_allowance_adjustment->id, $generator::TYPE_CODE_128) !!}
                    <p>{{ $bo_adjustments_details[0]->bo_allowance_adjustment->id }}</p>
                </center>

            </div>
        </div>
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="10">Particulars:
                        {{ $bo_adjustments_details[0]->bo_allowance_adjustment->particulars }}</th>
                </tr>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>UOM</th>
                    <th>Quantity</th>
                    <th>FUC</th>
                    <th>Amount</th>
                    <th>Adjustment</th>
                    <th>BO Allowance</th>
                    <th>Adjusted Amount</th>
                    <th>Adjusted FUC</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bo_adjustments_details as $data)
                    <tr>
                        <td style="text-transform: uppercase;text-align: center;">{{ $data->sku->sku_code }}
                        </td>
                        <td style="text-transform: uppercase;text-align: center;">{{ $data->sku->description }}
                        </td>
                        <td style="text-transform: uppercase;text-align: center;">
                            {{ $data->sku->unit_of_measurement }}</td>
                        <td style="text-align: center;">{{ $data->quantity }}</td>
                        <td style="text-align: right;">
                            {{ number_format($data->unit_cost, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $amount = $data->quantity * $data->unit_cost;
                                echo number_format($amount, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right;">{{ number_format($data->adjusted_amount, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                if ($data->adjusted_amount > 0) {
                                    $total_amount = $data->adjusted_amount * $data->quantity * -1;
                                    $sum_total_amount[] = $total_amount;
                                } else {
                                    $total_amount = $data->adjusted_amount * $data->quantity * -1;
                                    $sum_total_amount[] = $total_amount;
                                }
                            @endphp
                            {{ number_format($total_amount, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $adjusted_amount = $amount + $total_amount;
                            @endphp
                            {{ number_format($adjusted_amount, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $difference = $adjusted_amount / $data->quantity;
                            @endphp
                            {{ number_format($difference, 2, '.', ',') }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="7" style="text-align: center;font-weight: bold;color:green;">GRAND TOTAL
                    </th>
                    <th style="font-weight: bold;text-align: right;color:green;">
                        {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}
                    </th>
                    <th></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-hover table-striped table-sm float-right" style="width:35%;">
            <tr>
                <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY:
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">BO ALLOWANCE</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                    @php
                        $bo_allowance_deduction = array_sum($sum_total_amount);
                    @endphp
                    {{ number_format($bo_allowance_deduction, 2, '.', ',') }}
                    <input type="hidden" name="bo_allowance_deduction" value="{{ $bo_allowance_deduction }}">
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">NET DEDUCTION</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                    @php
                        $vat_deduction = array_sum($sum_total_amount) * 0.12;
                    @endphp
                    <input type="hidden" name="vat_deduction" value="{{ $vat_deduction }}">
                    @php
                        $net_deduction = $bo_allowance_deduction;
                    @endphp
                    {{ number_format($net_deduction, 2, '.', ',') }}
                    <input type="hidden" name="net_deduction" value="{{ $net_deduction }}">
                </td>
            </tr>
        </table>
        @if ($net_deduction < 0)
            <table class="table table-bordered table-hover table-striped table-sm">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                        <th style="text-align: center;">DR</th>
                        <th style="text-align: center;">CR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">ACCOUNTS PAYABLE - {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($net_deduction * -1, 2, '.', ',') }}
                        </td>
                        <td></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">INVENTORY - {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($net_deduction * -1, 2, '.', ',') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <table class="table table-bordered table-hover table-striped table-sm">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                        <th style="text-align: center;">DR</th>
                        <th style="text-align: center;">CR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">INVENTORY - {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($net_deduction, 2, '.', ',') }}
                        </td>
                        <td></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE - {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($net_deduction, 2, '.', ',') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>

    {{-- <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-6 invoice-col">
        <span style="text-align: center;">
          Purchased By: <br />
          <u style="font-weight: bold;"></u>
        </span>
        </div>
        <div class="col-sm-6 invoice-col">
          <span style="text-align: center;">
            Prepared By:<br />
            <u style="font-weight: bold;"> {{ $prepared_by->name }}</u>
          </span>
        </div>
      </div>
      <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-12 invoice-col">
        <span style="text-align: center;">
          Date: <br />
          <u style="font-weight: bold;">
            {{ $date }}
          </u>
        </span>
        </div>
      </div> --}}
</body>

</html>
