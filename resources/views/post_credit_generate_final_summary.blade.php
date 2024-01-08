@if ($si_id == 'unidentified')
    @if ($transaction == 'RGS')
        <form id="post_credit_memo_save">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-sm table-striped" style="font-size:13px;">
                    <thead>
                        <tr>
                            <td>Verified By:</td>
                            <th style="text-align: center;">
                                @if ($cm_data->verified_by != null)
                                    {{ $cm_data->verified_by }}
                                @else
                                    {{ $cm_data->verified_by_name }}
                                @endif
                            </th>
                            <td>Verified Date:</td>
                            <th style="text-align: center;">{{ $cm_data->verified_date }}</th>
                            <td>Returned By:</td>
                            <th style="text-align: center;">{{ $cm_data->returned_by }}</th>
                            <td>PCM Number:</td>
                            <th colspan="4" style="text-align: center;">{{ $cm_data->pcm_number }}</th>

                        </tr>
                        <tr>
                            <td>PCM Type:</td>
                            <th style="text-align: center;">
                                @if ($transaction == 'RGS')
                                    Return Good Stock
                                @elseif($transaction == 'BO')
                                    Bad Order
                                @endif
                            </th>
                            <td>Customer:</td>
                            <th style="text-align: center;">{{ $cm_data->customer->store_name }}
                            </th>
                            <td>Principal:</td>
                            <th style="text-align: center;">{{ $cm_data->principal->principal }}
                            </th>
                            <td>Delivery Receipt:</td>
                            <th style="text-align: center;">
                                {{ Str::ucfirst($si_id) }}
                            </th>
                            <td>Sku Type:</td>
                            <th style="text-align: center;">{{ $cm_data->sku_type }}</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="table table-responsive">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover table-sm table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Code</th>
                                <th style="text-align: center;">Description</th>
                                <th style="text-align: center;">Quantity</th>
                                <th style="text-align: center;">Unit Price</th>
                                <th style="text-align: center;">Sub-Total</th>
                                <th style="text-align: center;">Avg Cost</th>
                                <th style="text-align: center;">Sub-Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cm_data->return_good_stock_details as $data)
                                <tr>
                                    <td>{{ $data->sku->sku_code }}</td>
                                    <td>{{ $data->sku->description }}</td>
                                    <td style="text-align: right">{{ $data->confirmed_quantity }}</td>
                                    <td style="text-align: right">
                                        {{ number_format($unit_price[$data->sku_id], 2, '.', ',') }}</td>
                                    <td style="text-align: right">
                                        @php
                                            $sub_total = $data->confirmed_quantity * $unit_price[$data->sku_id];
                                            $sum_total[] = $sub_total;
                                            echo number_format($sub_total, 2, '.', ',');
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        @php
                                            echo number_format($average_cost[$data->sku_id], 2, '.', ',');
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        @php
                                            $sum_average_cost[] = $average_cost[$data->sku_id] * $data->confirmed_quantity;
                                            echo number_format($average_cost[$data->sku_id] * $data->confirmed_quantity, 2, '.', ',');
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th style="text-align: right;text-decoration: overline">{{ number_format(array_sum($sum_total), 2, '.', ',') }}
                                    <input type="hidden" value="{{ array_sum($sum_total) }}" name="total_amount">
                                </th>
                                <th></th>
                                <th style="text-align: right;text-decoration: overline">
                                    {{ number_format(array_sum($sum_average_cost), 2, '.', ',') }}
                                    <input type="hidden" value="{{ array_sum($sum_average_cost) }}"
                                        name="final_average_cost_total">
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <input type="hidden" name="customer_id" value="{{ $cm_data->customer_id }}">
            <input type="hidden" name="principal_id" value="{{ $cm_data->principal_id }}">
            <input type="hidden" name="cm_id" value="{{ $cm_data->id }}">
            <input type="hidden" name="transaction" value="{{ $transaction }}">
            <input type="text" name="si_id" value="unidentified">

            <button class="btn btn-sm btn-success float-right" type="submit">Submit</button>
        </form>
    @else
        <form id="post_credit_memo_save">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-sm table-striped" style="font-size:13px;">
                    <thead>
                        <tr>
                            <td>Verified By:</td>
                            <th style="text-align: center;">
                                @if ($cm_data->verified_by != null)
                                    {{ $cm_data->verified_by }}
                                @else
                                    {{ $cm_data->verified_by_name }}
                                @endif
                            </th>
                            <td>Verified Date:</td>
                            <th style="text-align: center;">{{ $cm_data->verified_date }}</th>
                            <td>Returned By:</td>
                            <th style="text-align: center;">{{ $cm_data->returned_by }}</th>
                            <td>PCM Number:</td>
                            <th colspan="4" style="text-align: center;">{{ $cm_data->pcm_number }}</th>

                        </tr>
                        <tr>
                            <td>PCM Type:</td>
                            <th style="text-align: center;">
                                @if ($transaction == 'RGS')
                                    Return Good Stock
                                @elseif($transaction == 'BO')
                                    Bad Order
                                @endif
                            </th>
                            <td>Customer:</td>
                            <th style="text-align: center;">{{ $cm_data->customer->store_name }}
                            </th>
                            <td>Principal:</td>
                            <th style="text-align: center;">{{ $cm_data->principal->principal }}
                            </th>
                            <td>Delivery Receipt:</td>
                            <th style="text-align: center;">
                                {{ Str::ucfirst($si_id) }}
                            </th>
                            <td>Sku Type:</td>
                            <th style="text-align: center;">{{ $cm_data->sku_type }}</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="table table-responsive">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover table-sm table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Code</th>
                                <th style="text-align: center;">Description</th>
                                <th style="text-align: center;">Quantity</th>
                                <th style="text-align: center;">Unit Price</th>
                                <th style="text-align: center;">Sub-Total</th>
                                <th style="text-align: center;">Average Cost</th>
                                <th style="text-align: center;">Sub-Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cm_data->bad_order_details as $data)
                                <tr>
                                    <td>{{ $data->sku->sku_code }}</td>
                                    <td>{{ $data->sku->description }}</td>
                                    <td style="text-align: right">{{ $data->confirmed_quantity }}</td>
                                    <td style="text-align: right">
                                        {{ number_format($unit_price[$data->sku_id], 2, '.', ',') }}</td>
                                    <td style="text-align: right">
                                        @php
                                            $sub_total = $data->confirmed_quantity * $unit_price[$data->sku_id];
                                            $sum_total[] = $sub_total;
                                            echo number_format($sub_total, 2, '.', ',');
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        @php
                                            echo number_format($average_cost[$data->sku_id], 2, '.', ',');
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        @php
                                            $sum_average_cost[] = $average_cost[$data->sku_id] * $data->confirmed_quantity;
                                            echo number_format($average_cost[$data->sku_id] * $data->confirmed_quantity, 2, '.', ',');
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th style="text-align: right">
                                    {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                                    <input type="hidden" value="{{ array_sum($sum_total) }}" name="total_amount">
                                </th>
                                <th></th>
                                <th>
                                    {{ number_format(array_sum($sum_average_cost), 2, '.', ',') }}
                                    <input type="hidden" value="{{ array_sum($sum_average_cost) }}"
                                        name="final_average_cost_total">
                                </th>
                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <input type="hidden" name="customer_id" value="{{ $cm_data->customer_id }}">
            <input type="hidden" name="principal_id" value="{{ $cm_data->principal_id }}">
            <input type="hidden" name="cm_id" value="{{ $cm_data->id }}">
            <input type="hidden" name="transaction" value="{{ $transaction }}">
            <input type="hidden" name="si_id" value="unidentified">

            <button class="btn btn-sm btn-success float-right" type="submit">Submit</button>
        </form>
    @endif
@else
    @if ($transaction == 'RGS')
        <form id="post_credit_memo_save">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-sm table-striped" style="font-size:13px;">
                    <thead>
                        <tr>
                            <td>Verified By:</td>
                            <th style="text-align: center;">
                                @if ($cm_data->verified_by != null)
                                    {{ $cm_data->verified_by }}
                                @else
                                    {{ $cm_data->verified_by_name }}
                                @endif
                            </th>
                            <td>Verified Date:</td>
                            <th style="text-align: center;">{{ $cm_data->verified_date }}</th>
                            <td>Returned By:</td>
                            <th style="text-align: center;">{{ $cm_data->returned_by }}</th>
                            <td>PCM Number:</td>
                            <th colspan="4" style="text-align: center;">{{ $cm_data->pcm_number }}</th>

                        </tr>
                        <tr>
                            <td>PCM Type:</td>
                            <th style="text-align: center;">
                                @if ($transaction == 'RGS')
                                    Return Good Stock
                                @elseif($transaction == 'BO')
                                    Bad Order
                                @endif
                            </th>
                            <td>Customer:</td>
                            <th style="text-align: center;">{{ $cm_data->customer->store_name }}
                            </th>
                            <td>Principal:</td>
                            <th style="text-align: center;">{{ $cm_data->principal->principal }}
                            </th>
                            <td>Delivery Receipt:</td>
                            <th style="text-align: center;">
                                {{ $sales_invoice->delivery_receipt }}
                            </th>
                            <td>Sku Type:</td>
                            <th style="text-align: center;">{{ $cm_data->sku_type }}</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="table table-responsive">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover table-sm table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Code</th>
                                <th style="text-align: center;">Description</th>
                                <th style="text-align: center;">Quantity</th>
                                <th style="text-align: center;">Unit Price</th>
                                <th style="text-align: center;">Sub-Total</th>
                                <th style="text-align: center;">Avg Cost</th>
                                <th style="text-align: center;">Sub-Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cm_data->return_good_stock_details as $data)
                                <tr>
                                    <td>{{ $data->sku->sku_code }}</td>
                                    <td>{{ $data->sku->description }}</td>
                                    <td style="text-align: right">{{ $data->confirmed_quantity }}</td>
                                    <td style="text-align: right">
                                        {{ number_format($unit_price[$data->sku_id], 2, '.', ',') }}</td>
                                    <td style="text-align: right">
                                        @php
                                            $sub_total = $data->confirmed_quantity * $unit_price[$data->sku_id];
                                            $sum_total[] = $sub_total;
                                            echo number_format($sub_total, 2, '.', ',');
                                        @endphp
                                        <input type="hidden" name="quantity_returned[{{ $data->sku_id }}]"
                                            value="{{ $data->confirmed_quantity }}">
                                        <input type="hidden" name="unit_price[{{ $data->sku_id }}]"
                                            value="{{ $unit_price[$data->sku_id] }}">
                                    </td>
                                    <td style="text-align: right">
                                        @php
                                            echo number_format($average_cost[$data->sku_id], 2, '.', ',');
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        @php
                                            $sum_average_cost[] = $average_cost[$data->sku_id] * $data->confirmed_quantity;
                                            echo number_format($average_cost[$data->sku_id] * $data->confirmed_quantity, 2, '.', ',');
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @if ($customer_discount == 0)
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: right">
                                        {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                                        <input type="hidden" value="{{ array_sum($sum_total) }}" name="total_amount">
                                        <input type="hidden" name="customer_discount[]" value="0">
                                    </th>
                                </tr>
                            @else
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: right">
                                        {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @php
                                    $total = array_sum($sum_total);
                                    $discount_holder = [];
                                    $discount_value_holder = $total;
                                @endphp
                                @foreach ($customer_discount as $data_discount)
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right">Less - {{ $data_discount }}%</th>
                                        <th style="text-align: right">
                                            @php
                                                $discount_value_holder_dummy = $discount_value_holder;
                                                $less_percentage_by = $data_discount / 100;

                                                $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                                                $discount_amount = $discount_value_holder_dummy * $less_percentage_by;
                                                $discount_holder[] = $discount_value_holder;
                                                echo number_format($discount_amount, 2, '.', ',');
                                            @endphp
                                            <input type="hidden" value="{{ $data_discount }}"
                                                name="customer_discount[]">
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="4" style="text-align: right">Final Total</th>
                                    <th style="text-align: right;text-decoration: overline">
                                        {{ number_format(end($discount_holder), 2, '.', ',') }}
                                        @php
                                            $final_total = end($discount_holder);
                                        @endphp
                                        <input type="hidden" value="{{ $final_total }}" name="total_amount">
                                    </th>
                                    <th></th>
                                    <th style="text-align: right;text-decoration: overline">
                                        {{ number_format(array_sum($sum_average_cost), 2, '.', ',') }}
                                        <input type="hidden" value="{{ array_sum($sum_average_cost) }}"
                                            name="final_average_cost_total">
                                    </th>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>

            <input type="hidden" name="customer_id" value="{{ $cm_data->customer_id }}">
            <input type="hidden" name="principal_id" value="{{ $cm_data->principal_id }}">
            <input type="hidden" name="cm_id" value="{{ $cm_data->id }}">
            <input type="hidden" name="transaction" value="{{ $transaction }}">

            <input type="hidden" name="si_id" value="{{ $sales_invoice->id }}">

            @if ($total_invoice_amount > $final_total)
                <button class="btn btn-sm btn-success float-right" type="submit">Submit</button>
            @else
                <center>
                    <h3 style="color:red;">Cannot Proceed. Total CM amount is greater than the selected invoice</h6>
                </center>
            @endif
        </form>
    @else
        <form id="post_credit_memo_save">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-sm table-striped" style="font-size:13px;">
                    <thead>
                        <tr>
                            <td>Verified By:</td>
                            <th style="text-align: center;">
                                @if ($cm_data->verified_by != null)
                                    {{ $cm_data->verified_by }}
                                @else
                                    {{ $cm_data->verified_by_name }}
                                @endif
                            </th>
                            <td>Verified Date:</td>
                            <th style="text-align: center;">{{ $cm_data->verified_date }}</th>
                            <td>Returned By:</td>
                            <th style="text-align: center;">{{ $cm_data->returned_by }}</th>
                            <td>PCM Number:</td>
                            <th colspan="4" style="text-align: center;">{{ $cm_data->pcm_number }}</th>

                        </tr>
                        <tr>
                            <td>PCM Type:</td>
                            <th style="text-align: center;">
                                @if ($transaction == 'RGS')
                                    Return Good Stock
                                @elseif($transaction == 'BO')
                                    Bad Order
                                @endif
                            </th>
                            <td>Customer:</td>
                            <th style="text-align: center;">{{ $cm_data->customer->store_name }}
                            </th>
                            <td>Principal:</td>
                            <th style="text-align: center;">{{ $cm_data->principal->principal }}
                            </th>
                            <td>Delivery Receipt:</td>
                            <th style="text-align: center;">
                                {{ $sales_invoice->delivery_receipt }}
                            </th>
                            <td>Sku Type:</td>
                            <th style="text-align: center;">{{ $cm_data->sku_type }}</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="table table-responsive">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover table-sm table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Code</th>
                                <th style="text-align: center;">Description</th>
                                <th style="text-align: center;">Quantity</th>
                                <th style="text-align: center;">Unit Price</th>
                                <th style="text-align: center;">Sub-Total</th>
                                <th style="text-align: center;">Avg Cost</th>
                                <th style="text-align: center;">Sub-Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cm_data->bad_order_details as $data)
                                <tr>
                                    <td>{{ $data->sku->sku_code }}</td>
                                    <td>{{ $data->sku->description }}</td>
                                    <td style="text-align: right">{{ $data->confirmed_quantity }}</td>
                                    <td style="text-align: right">
                                        {{ number_format($unit_price[$data->sku_id], 2, '.', ',') }}</td>
                                    <td style="text-align: right">
                                        @php
                                            $sub_total = $data->confirmed_quantity * $unit_price[$data->sku_id];
                                            $sum_total[] = $sub_total;
                                            echo number_format($sub_total, 2, '.', ',');
                                        @endphp
                                        <input type="hidden" name="quantity_returned[{{ $data->sku_id }}]"
                                            value="{{ $data->confirmed_quantity }}">
                                        <input type="hidden" name="unit_price[{{ $data->sku_id }}]"
                                            value="{{ $unit_price[$data->sku_id] }}">
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($average_cost[$data->sku_id], 2, '.', ',') }}</td>
                                    <td style="text-align: right">
                                        @php
                                            $sum_average_cost[] = $average_cost[$data->sku_id] * $data->confirmed_quantity;
                                            echo number_format($average_cost[$data->sku_id] * $data->confirmed_quantity, 2, '.', ',');
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @if ($customer_discount == 0)
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: right">
                                        {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                                    </th>
                                    <input type="hidden" value="{{ array_sum($sum_total) }}" name="total_amount">
                                </tr>
                                <input type="hidden" name="customer_discount[]" value="0">
                            @else
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: right">
                                        {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @php
                                    $total = array_sum($sum_total);
                                    $discount_holder = [];
                                    $discount_value_holder = $total;
                                @endphp
                                @foreach ($customer_discount as $data_discount)
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right">Less - {{ $data_discount }}%</th>
                                        <th style="text-align: right">
                                            @php
                                                $discount_value_holder_dummy = $discount_value_holder;
                                                $less_percentage_by = $data_discount / 100;

                                                $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                                                $discount_amount = $discount_value_holder_dummy * $less_percentage_by;
                                                $discount_holder[] = $discount_value_holder;
                                                echo number_format($discount_amount, 2, '.', ',');
                                            @endphp
                                            <input type="hidden" value="{{ $data_discount }}"
                                                name="customer_discount[]">
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="4" style="text-align: right">Final Total</th>
                                    <th style="text-align: right;text-decoration: overline">
                                        {{ number_format(end($discount_holder), 2, '.', ',') }}
                                        @php
                                            $final_total = end($discount_holder);
                                        @endphp
                                        <input type="hidden" value="{{ $final_total }}" name="total_amount">
                                    </th>
                                    <th></th>
                                    <th style="text-align: right;text-decoration: overline">
                                        {{ number_format(array_sum($sum_average_cost), 2, '.', ',') }}
                                        <input type="hidden" value="{{ array_sum($sum_average_cost) }}"
                                            name="final_average_cost_total">
                                    </th>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
            <input type="hidden" name="customer_id" value="{{ $cm_data->customer_id }}">
            <input type="hidden" name="principal_id" value="{{ $cm_data->principal_id }}">
            <input type="hidden" name="cm_id" value="{{ $cm_data->id }}">
            <input type="hidden" name="transaction" value="{{ $transaction }}">

            <input type="hidden" name="si_id" value="{{ $sales_invoice->id }}">

            @if ($total_invoice_amount > $final_total)
                <button class="btn btn-sm btn-success float-right" type="submit">Submit</button>
            @else
                <center>
                    <h3 style="color:red;">Cannot Proceed. Total CM amount is greater than the selected invoice</h6>
                </center>
            @endif
        </form>
    @endif
@endif

<script>
    $("#post_credit_memo_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "post_credit_memo_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                if (data == 'exceed') {
                    Swal.fire(
                        'Cannot Proceed',
                        'Amount Exceed AR Balance',
                        'error'
                    )
                } else {
                    // Swal.fire({
                    //     position: 'top-end',
                    //     icon: 'success',
                    //     title: 'Your work has been saved',
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // });

                    // location.reload();
                }
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
