<form id="sales_order_draft_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th style="text-align: center">Agent</th>
                    <th style="text-align: center">Customer</th>
                    <th style="text-align: center">Customer Code</th>
                    <th style="text-align: center">Price Level</th>
                    <th style="text-align: center">Principal</th>
                    <th style="text-align: center">Sku Type</th>
                    <th style="text-align: center">Mode of Transaction</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">{{ $sales_order_draft->agent->full_name }}</td>
                    <td style="text-align: center;">{{ $sales_order_draft->customer->store_name }}</td>
                    <td style="text-align: center;">{{ $customer_principal_code }}</td>
                    <td style="text-transform:uppercase;text-align:center;">{{ $customer_principal_price }}</td>
                    <td style="text-align: center;">{{ $sales_order_draft->principal->principal }}</td>
                    <td style="text-align: center;">{{ $sales_order_draft->sku_type }}</td>
                    <td style="text-align: center;">
                        {{ $sales_order_draft->mode_of_transaction }}
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="7">DR: {{ $delivery_receipt }}</th>
                </tr>
                <tr>
                    <th>Code</th>
                    <th>Desc</th>
                    <th>UOM</th>
                    <th>KG</th>
                    <th>Qty</th>
                    <th>U/P</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_order_draft->sales_order_draft_details as $details)
                    <tr>
                        <td>{{ $details->sku->sku_code }}</td>
                        <td>{{ $details->sku->description }}</td>
                        <td>{{ $details->sku->unit_of_measurement }}</td>
                        <td style="text-align: right">{{ $details->sku->kilograms }}
                            @php
                                $sum_kg[] = $details->sku->kilograms;
                            @endphp
                        </td>
                        <td style="text-align: right">{{ $final_quantity[$details->sku_id] }}
                            @php
                                $sum_quantity[] = $final_quantity[$details->sku_id];
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ $unit_price[$details->sku_id] }}

                        </td>
                        <td style="text-align: right">
                            @php
                                echo $sub_total = $final_quantity[$details->sku_id] * $unit_price[$details->sku_id];
                                $sum_total[] = $sub_total;
                                
                                $unit_cost_sub_total = $details->sku->sku_price_details_one->unit_cost * $final_quantity[$details->sku_id];
                                $sum_unit_cost_sub_total[] = $unit_cost_sub_total;
                            @endphp
                            <input type="hidden" name="sku_id[]" value="{{ $details->sku_id }}">
                            <input type="hidden" name="unit_price[{{ $details->sku_id }}]"
                                value="{{ $unit_price[$details->sku_id] }}">
                            <input type="hidden" name="final_quantity[{{ $details->sku_id }}]"
                                value="{{ $final_quantity[$details->sku_id] }}">
                            <input type="hidden" name="kilograms[{{ $details->sku_id }}]"
                                value="{{ $details->sku->kilograms }}">
                            <input type="hidden" name="total_amount_per_sku[{{ $details->sku_id }}]"
                                value="{{ $sub_total }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if ($customer_discount != 0)
                    <tr>
                        <th colspan="3" style="text-align: center">GROSS</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                    </tr>
                    @php
                        $total = array_sum($sum_total);
                        $discount_holder = [];
                        $discount_value_holder = $total;
                    @endphp
                    @foreach ($customer_discount as $data_discount)
                        <tr>

                            <th style="text-align: center" colspan="3">LESS - {{ $data_discount }}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right">
                                @php
                                    $discount_value_holder_dummy = $discount_value_holder;
                                    $less_percentage_by = $data_discount / 100;
                                    
                                    $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                    $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                                    $customer_discount_holder[] = $discount_value_holder_dummy * $less_percentage_by;
                                    $discount_holder[] = $discount_value_holder;
                                    echo number_format($discount_value_holder, 2, '.', ',');
                                @endphp
                                <input type="hidden" name="discount_rate[]" value="{{ $data_discount }}">
                            </th>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" style="text-align: center">TOTAL</th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_kg), 2, '.', ',') }}
                        </th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_quantity), 2, '.', ',') }}
                        </th>
                        <th></th>
                        <th style="text-align: right;text-decoration: overline">
                            {{ number_format(end($discount_holder), 2, '.', ',') }}
                            @php
                                $final_total = end($discount_holder);
                            @endphp
                            <input type="hidden" value="{{ $final_total }}" name="final_total">
                            <input type="hidden" value="{{ array_sum($customer_discount_holder) }}"
                                name="customer_discount">
                        </th>
                    </tr>
                @else
                    <tr>
                        <th colspan="3" style="text-align: center">TOTAL</th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_kg), 2, '.', ',') }}
                        </th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_quantity), 2, '.', ',') }}
                        </th>
                        <th></th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                            <input type="hidden" value="{{ array_sum($sum_total) }}" name="final_total">
                            <input type="hidden" value="{{ 0 }}" name="customer_discount">
                        </th>
                    </tr>
                @endif
            </tfoot>
        </table>

        @if ($customer_discount != 0)
            <table class="table table-bordered table-hover table-sm table-striped">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>

                        <th style="text-align: center;">DR</th>
                        <th style="text-align: center;">CR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">ACCOUNTS RECEIVABLE -
                            {{ $sales_order_draft->customer->store_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($final_total, 2, '.', ',') }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">SALES - {{ $sales_order_draft->principal->principal }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($final_total, 2, '.', ',') }}
                            <input type="hidden" name="final_gross_amount_jer" value="{{ $final_total }}">
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">COST OF SALES -
                            {{ $sales_order_draft->principal->principal }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">INVENTORY - {{ $sales_order_draft->principal->principal }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                            <input type="hidden" name="final_unit_cost_amount_jer" value="{{ array_sum($sum_unit_cost_sub_total) }}">
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <table class="table table-bordered table-hover table-sm table-striped">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                        <th style="text-align: center;">DR</th>
                        <th style="text-align: center;">CR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">ACCOUNTS RECEIVABLE -
                            {{ $sales_order_draft->customer->store_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">SALES - {{ $sales_order_draft->principal->principal }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                            <input type="hidden" name="final_gross_amount_jer" value="{{ array_sum($sum_total) }}">
                        </td>
                    </tr>


                    <tr>
                        <td style="text-align: center;">COST OF SALES -
                            {{ $sales_order_draft->principal->principal }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">INVENTORY - {{ $sales_order_draft->principal->principal }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                            <input type="hidden" name="final_unit_cost_amount_jer" value="{{ array_sum($sum_unit_cost_sub_total) }}">
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif


    </div>
    <div class="row">
        <div class="col-md-12">
            <br />
            <input type="hidden" value="{{ $customer_id }}" name="customer_id">
            <input type="hidden" value="{{ $mode_of_transaction }}" name="mode_of_transaction">
            <input type="hidden" value="{{ $sku_type }}" name="sku_type">
            <input type="hidden" value="{{ $agent_id }}" name="agent_id">
            <input type="hidden" value="{{ $delivery_receipt }}" name="delivery_receipt">
            <input type="hidden" value="{{ $principal_id }}" name="principal_id">
            <input type="hidden" value="{{ $sales_order_draft->sales_order_number }}" name="sales_order_number">
            <input type="hidden" value="{{ $sales_order_draft->id }}" name="sales_order_draft_id">
            <button type="submit" class="btn btn-success btn-sm float-right">Submit</button>
        </div>
    </div>
</form>


<script>
    $("#sales_order_draft_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "sales_order_draft_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                Swal.fire(
                    'Transaction Saved',
                    '',
                    'success'
                )
                location.reload();
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
