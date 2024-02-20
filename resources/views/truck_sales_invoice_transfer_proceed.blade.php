{{-- <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <th colspan="6">DELIVERY RECEIPT: {{ $sales_invoice->delivery_receipt }}</th>
            </tr>
            <tr>
                <th class="text-center">CODE</th>
                <th class="text-center">DESCRIPTION</th>
                <th class="text-center">QUANTITY</th>
                <th class="text-center">U/P</th>
                <th class="text-center">DISCOUNT</th>
                <th class="text-center">SUB-TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_invoice->sales_invoice_details as $details)
                <tr>
                    <td>{{ $details->sku->sku_code }}</td>
                    <td>{{ $details->sku->description }}</td>
                    <td style="text-align: right">{{ $details->quantity }}
                        @php
                            $total_quantity[] = $details->quantity;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($details->total_discount_per_sku, 2, '.', ',') }}
                    </td>
                    <td style="text-align: right">
                        {{ number_format($details->total_amount_per_sku, 2, '.', ',') }}
                        @php
                            $total_sum[] = $details->total_amount_per_sku;
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right">{{ array_sum($total_quantity) }}</td>
                <td></td>
                <td></td>
                <td style="text-align: right">{{ number_format(array_sum($total_sum), 2, '.', ',') }}</td>
            </tr>
        </tfoot>
    </table> --}}
{{-- <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <th>Sales</th>
            </tr>
        </thead>
    </table> --}}

<div class="row">
    <div class="col-md-6">
        <div class="table table-responsive">
            <table class="table table-bordered table-striped table-sm table-hover" style="width:100%;" id="example1">
                <thead>
                    <tr>
                        <th colspan="6" class="text-center">ORIGINAL LOAD SHEET CONTROL</th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-center">LOAD SHEET -
                            {{ $logistics_invoice_original[0]->logistics_id }}</th>
                    </tr>
                    <tr>
                        <th class="text-center">INVOICE</th>
                        <th class="text-center">CASE</th>
                        <th class="text-center">BUTAL</th>
                        <th class="text-center">CONVERSION</th>
                        <th class="text-center">AMOUNT</th>
                        <th class="text-center">TRANSACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logistics_invoice_original as $details)
                        <tr>
                            <td>{{ $details->sales_invoice->delivery_receipt }}</td>
                            <td style="text-align: right">{{ $details->case }}</td>
                            <td style="text-align: right">{{ $details->butal }}</td>
                            <td style="text-align: right">{{ number_format($details->conversion, 2, '.', ',') }}</td>
                            <td style="text-align: right">{{ number_format($details->amount, 2, '.', ',') }}</td>
                            <td>{{ $details->sales_invoice->customer->mode_of_transaction }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table table-responsive">
            <table class="table table-bordered table-striped table-sm table-hover" style="width:100%;" id="example1">
                <thead>
                    <tr>
                        <th colspan="6" class="text-center">NEW LOAD SHEET CONTROL</th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-center">LOAD SHEET -
                            {{ $logistics_invoice_original[0]->logistics_id }}</th>
                    </tr>
                    <tr>
                        <th class="text-center">INVOICE</th>
                        <th class="text-center">CASE</th>
                        <th class="text-center">BUTAL</th>
                        <th class="text-center">CONVERSION</th>
                        <th class="text-center">AMOUNT</th>
                        <th class="text-center">TRANSACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logistics_invoice_new as $details)
                        <tr>
                            <td>{{ $details->sales_invoice->delivery_receipt }}</td>
                            <td style="text-align: right">{{ $details->case }}
                                @php
                                    $new_total_case[$details->principal_id][] = $details->case;
                                    $new_sum_total_case[] = $details->case;
                                @endphp
                            </td>
                            <td style="text-align: right">{{ $details->butal }}
                                @php
                                    $new_total_butal[$details->principal_id][] = $details->butal;
                                @endphp
                            </td>
                            <td style="text-align: right">{{ number_format($details->conversion, 2, '.', ',') }}
                                @php
                                    $new_total_conversion[$details->principal_id][] = $details->conversion;
                                    $new_sum_total_conversion[] = $details->conversion;
                                @endphp
                            </td>
                            <td style="text-align: right">{{ number_format($details->amount, 2, '.', ',') }}
                                @php
                                    $new_total_amount[$details->principal_id][] = $details->amount;
                                @endphp
                            </td>
                            <td>{{ $details->sales_invoice->customer->mode_of_transaction }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <div class="table table-responsive">
            {{-- @php
                var_export($new_total_case);
                echo array_sum($new_total_case[2]);
            @endphp --}}
            <table class="table table-sm table-striped table-bordered table-hover" style="width:100%;">
                <thead>
                    <tr style="background: orange">
                        <th style="text-align: center;">PRINCIPAL</th>
                        <th style="text-align: center;">CASE</th>
                        <th style="text-align: center;">BUTAL</th>
                        <th style="text-align: center;">CONVERSION</th>
                        <th style="text-align: center;">AMOUNT</th>
                        <th style="text-align: center;">WEIGHT</th>
                        <th style="text-align: center;">PERCENTAGE</th>
                        <th style="text-align: center;">EQUIVALENT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logistics->logistics_details as $data)
                        <tr>
                            <td style="text-align: center;">{{ $data->principal->principal }}</td>
                            <td>{{ array_sum($new_total_case[$data->principal_id]) }}</td>
                            <td>{{ array_sum($new_total_butal[$data->principal_id]) }}</td>
                            <td>{{ array_sum($new_total_conversion[$data->principal_id]) }}</td>
                            <td>{{ array_sum($new_total_amount[$data->principal_id]) }}</td>
                            <td></td>
                            <td>
                                @php
                                    $percentage = (array_sum($new_total_case[$data->principal_id]) + array_sum($new_total_conversion[$data->principal_id])) / (array_sum($new_sum_total_case) + array_sum($new_sum_total_conversion));

                                    echo $percentage;
                                @endphp
                            </td>
                            <td>
                                @php
                                    $equivalent = $logistics->total_expense_per_delivery * $percentage;
                                    echo number_format($equivalent, 2, '.', ',');
                                    $sum_equivalent[] = $equivalent;
                                @endphp
                            </td>
                            {{-- <td style="text-align: center;">{{ array_sum($new_total_case[$data->principal_id]) }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <th style="text-align: center;">TOTAL</th>
                        <td style="text-align: right">{{ array_sum($sum_case) }}</td>
                        <td style="text-align: right">{{ array_sum($sum_butal) }}</td>
                        <td style="text-align: right">{{ array_sum($sum_conversion) }}</td>
                        <td style="text-align: right">{{ array_sum($sum_amount) }}</td>
                        <td style="text-align: right">{{ array_sum($sum_weight) }}</td>
                        <td style="text-align: right">{{ array_sum($sum_percentage) }}</td>
                        <td style="text-align: right">{{ array_sum($sum_equivalent) }}</td>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
</div>


<form id="truck_sales_invoice_transfer_save">
    @csrf
    {{-- <input type="text" name="sales_invoice_id" value="{{ $sales_invoice->id }}"> --}}
    <button class="btn btn-sm float-right btn-success" type="submit">Transfer</button>
</form>

<script>
    $("#truck_sales_invoice_transfer_save").on('submit', (function(e) {
        e.preventDefault();
        // $('#loader').show();
        $.ajax({
            url: "truck_sales_invoice_transfer_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                location.reload();
                s
            },
            error: function(error) {
                $('#loader').hide();
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
