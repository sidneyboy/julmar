<link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
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
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-12 invoice-col">
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
        <!-- /.row -->
        <br />
        <!-- Table row -->
        <div class="row">

            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th colspan="8">Particulars:
                                {{ $bo_adjustments_details[0]->bo_allowance_adjustment->particulars }}</th>
                        </tr>
                        <tr>
                            <th>Code</th>
                            <th>Description</th>
                            <th>UOM</th>
                            <th>Quantity Received</th>
                            <th>Unit Cost</th>
                            <th>BO Cost Adjustment</th>
                            <th>Adjusted Unit Cost</th>
                            <th>BO Allowance</th>
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
                                    {{ number_format($data->adjusted_amount, 2, '.', ',') }}
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        $difference = $data->unit_cost - $data->adjusted_amount;
                                    @endphp
                                    {{ number_format($difference, 2, '.', ',') }}
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        $total_amount = $data->adjusted_amount * $data->quantity;
                                        $sum_total_amount[] = $total_amount;
                                    @endphp
                                    {{ number_format($total_amount, 2, '.', ',') }}
                                    <input type="hidden" name="bo_allowance_per_sku[{{ $data }}]"
                                        value="{{ $total_amount }}">
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="7" style="text-align: center;font-weight: bold;color:green;">GRAND TOTAL
                            </td>
                            <td style="font-weight: bold;text-align: right;color:green;">
                                {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-hover table-sm float-right" style="width:35%;">
                    <tr>
                        <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY OF DEDUCTION:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">BO ALLOWANCE</td>
                        <td style="font-weight: bold; text-align: right;font-size: 15px;">

                            {{ number_format($bo_adjustments_details[0]->bo_allowance_adjustment->bo_allowance_deduction, 2, '.', ',') }}

                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">NET DEDUCTION</td>
                        <td
                            style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                            {{ number_format($bo_adjustments_details[0]->bo_allowance_adjustment->net_deduction, 2, '.', ',') }}
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered table-hovered table-sm">
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                            <th style="text-align: center;">DR</th>
                            <th style="text-align: center;">CR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">ACCOUNTS PAYABLE -
                                {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($bo_adjustments_details[0]->bo_allowance_adjustment->net_deduction, 2, '.', ',') }}
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center;">INVENTORY -
                                {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($bo_adjustments_details[0]->bo_allowance_adjustment->net_deduction, 2, '.', ',') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- /.col -->
        </div>
        <!-- /.row -->
        <br /><br />

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

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">
    //window.addEventListener("load", window.print());
</script>
