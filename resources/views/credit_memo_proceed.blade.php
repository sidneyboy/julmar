<form id="post_credit_memo_save">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
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
                    <th style="text-align: center;">{{ $cm_data->pcm_number }}</th>
                    <td>Amount:</td>
                    <th style="text-align: center;">{{ number_format($cm_data->total_amount, 2, '.', ',') }}</th>
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
                        @if ($cm_data->si_id != null)
                            {{ $cm_data->sales_invoice->delivery_receipt }}
                        @else
                            {{ $cm_data->delivery_receipt }}
                        @endif
                    </th>
                    <td>Sku Type:</td>
                    <th style="text-align: center;">{{ $cm_data->sku_type }}</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th style="text-align: center;">Code</th>
                    <th style="text-align: center;">Description</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: center;">Unit Price</th>
                    <th style="text-align: center;">Sub-Total</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if ($transaction == 'RGS')

                    @foreach ($cm_data->return_good_stock_details as $details)
                        <tr>
                            <td>{{ $details->sku->sku_code }}
                                <input type="hidden" name="si_id" value="{{ $cm_data->si_id }}">
                            </td>
                            <td>{{ $details->sku->description }}</td>
                            <td style="text-align: right">{{ $details->confirmed_quantity }}</td>
                            <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                            <td style="text-align: right">
                                @php
                                    $sub_total = $details->confirmed_quantity * $details->unit_price;
                                    $sum_total[] = $sub_total;
                                    $sum_quantity[] = $details->confirmed_quantity;
                                    echo number_format($sub_total, 2, '.', ',');
                                @endphp
                                <input type="hidden" name="quantity_returned[{{ $details->sku_id }}]"
                                    value="{{ $details->confirmed_quantity }}">
                            </td>
                            <td>
                                @if ($details->remarks != 'scanned')
                                    {{ $details->remarks }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                @endif
            </tbody>
            <tfoot>
                @if ($customer_discount == 0)
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                        <input type="hidden" value="{{ array_sum($sum_total) }}" name="total_amount">
                    </tr>
                    <input type="hidden" name="customer_discount[]" value="0">
                @else
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
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
                                <input type="hidden" value="{{ $data_discount }}" name="customer_discount[]">
                            </th>
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
                    </tr>
                @endif
            </tfoot>
        </table>
    </div>
    <input type="hidden" name="transaction" value="{{ $transaction }}">
    <input type="hidden" name="principal_id" value="{{ $cm_data->principal_id }}">
    <input type="hidden" name="customer_id" value="{{ $cm_data->customer_id }}">
    <input type="hidden" name="cm_id" value="{{ $cm_data->id }}">
    <button type="submit" class="btn btn-sm float-right btn-success">Post Credit Memo</button>
</form>

<script>
    $("#post_credit_memo_save").on('submit', (function(e) {
        e.preventDefault();
        //$('#loader').show();
        $.ajax({
            url: "post_credit_memo_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: 'Your work has been saved',
                //     showConfirmButton: false,
                //     timer: 1500
                // });

                // location.reload();
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
