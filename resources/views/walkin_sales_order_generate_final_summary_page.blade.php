<form id="walkin_sales_order_save">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>U/P</th>
                    <th>Amount</th>
                    @if (array_sum($line_discount_rate_1) != 0)
                        <th style="text-align: center;">Disc</th>
                    @endif
                    <th style="text-align: center;">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sku as $data)
                    <tr>
                        <td>{{ $sku_code[$data] }} - {{ $description[$data] }}</td>
                        <td style="text-align: right">
                            @php
                                $sum_quantity[] = $quantity[$data];
                                echo $quantity[$data];
                            @endphp
                        </td>
                        <td style="text-align: right">{{ number_format($unit_price[$data], 2, '.', ',') }}</td>
                        <td style="text-align: right">
                            @php
                                $amount = $quantity[$data] * $unit_price[$data];
                                $sum_amount[] = $amount;
                                echo number_format($amount, 2, '.', ',');
                            @endphp
                        </td>
                        @if (array_sum($line_discount_rate_1) != 0)
                            <td style="text-align: right;">
                                @php
                                    $line_discount_1 = $line_discount_rate_1[$data];
                                    $sum_line_discount_1[] = $line_discount_1;
                                    echo number_format($line_discount_1, 2, '.', ',');
                                @endphp
                            </td>
                        @else
                            @php
                                $line_discount_1 = 0;
                                $sum_line_discount_1[] = $line_discount_1;
                            @endphp
                        @endif
                        <td style="text-align: right">
                            @php
                                $total_amount_per_sku = $amount - $line_discount_1;
                                $sum_total_amount_per_sku[] = $total_amount_per_sku;
                                echo number_format($total_amount_per_sku, 2, '.', ',');
                            @endphp
                            <input type="hidden" value="{{ $data }}" name="sku_id[]">
                            <input type="hidden" value="{{ $quantity[$data] }}" name="quantity[{{ $data }}]">
                            <input type="hidden" value="{{ $unit_price[$data] }}" name="unit_price[{{ $data }}]">
                            <input type="hidden" value="{{ $line_discount_rate_1[$data] }}" name="line_discount[{{ $data }}]">
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td style="text-align: center;font-weight: bold">SUB TOTAL</td>
                    <td style="text-align: right;font-weight: bold">{{ array_sum($sum_quantity) }}</td>
                    <td></td>
                    <td style="text-align: right;font-weight: bold;">
                        {{ number_format(array_sum($sum_amount), 2, '.', ',') }}
                    </td>
                    @if (array_sum($line_discount_rate_1) != 0)
                        <td style="text-align: right;font-weight: bold">
                            {{ number_format(array_sum($sum_line_discount_1), 2, '.', ',') }}</td>
                    @endif
                    <td style="text-align: right;font-weight: bold">
                        {{ number_format(array_sum($sum_total_amount_per_sku), 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-hover float-right table-sm" style="width:35%;">
            <tr>
                @if (array_sum($line_discount_rate_1) != 0)
                    <td style="text-align: center;font-weight:bold">Other Discount</td>
                    <th style="text-align: right">{{ number_format($total_other_discount, 2, '.', ',') }}</th>
                @else
                    <td style="text-align: center;font-weight:bold">Other Discount</td>
                    <th style="text-align: right">{{ number_format($total_other_discount, 2, '.', ',') }}</th>
                @endif
            </tr>
            <tr>
                <td style="text-align: center;font-weight:bold">Net Payable</td>
                <th style="text-align: right">
                    @php
                        $total_payable = array_sum($sum_total_amount_per_sku) - $total_other_discount;
                        echo number_format($total_payable, 2, '.', ',');
                    @endphp
                </th>
            </tr>
        </table>
    </div>
    <br />
    <input type="hidden" value="{{ $delivery_receipt }}" name="delivery_receipt">
    <input type="hidden" value="{{ $mode_of_transaction }}" name="mode_of_transaction">
    <input type="hidden" value="{{ $sku_type }}" name="sku_type">
    <input type="hidden" value="{{ $customer_id }}" name="customer_id">
    <input type="hidden" value="{{ $agent }}" name="agent">
    <input type="hidden" value="{{ $total_other_discount }}" name="other_discount">
    <input type="hidden" value="{{ $total_payable }}" name="total_amount">
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <button class="btn btn-success btn-sm float-right">Submit</button>
</form>


<script>
    $("#walkin_sales_order_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "walkin_sales_order_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                location.reload();
            },
            error: function(error) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
