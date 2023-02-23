<form id="invoice_out_saved">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Principal: {{ $invoice_draft->principal->principal }}</th>
                    <th>DR: {{ $invoice_draft->delivery_receipt }}</th>
                    <th>SKU Type: {{ $invoice_draft->sku_type }}</th>
                    <th colspan="4">Customer: {{ $invoice_draft->customer->store_name }}</th>
                </tr>
                <tr>
                    <th>Desc</th>
                    <th>UOM</th>
                    <th>Unit Price</th>
                    <th>Final Quantity</th>
                    <th>Amount</th>
                    <th>Line Discount</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice_draft_details as $details)
                    <tr>
                        <td>{{ $details->sku->sku_code }} - {{ $details->sku->description }}</td>
                        <td>{{ $details->sku->unit_of_measurement }}</td>
                        <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                        <td style="text-align: right">
                            @php
                                echo $final_quantity[$details->sku_id];
                                $sum_quantity[] = $final_quantity[$details->sku_id];
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $amount = $details->unit_price * $final_quantity[$details->sku_id];
                                $sum_amount[] = $amount;
                                echo number_format($amount, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $line_discount = $details->line_discount;
                                $sum_line_discount[] = $line_discount;
                                echo number_format($line_discount, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $sub_total = $amount - $line_discount;
                                $sum_sub_total[] = $sub_total;
                                echo number_format($sub_total, 2, '.', ',');
                            @endphp
                            <input type="hidden" name="sku_id[]" value="{{ $details->sku_id }}">
                            <input type="hidden" value="{{ $final_quantity[$details->sku_id] }}"
                                name="quantity[{{ $details->sku_id }}]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_quantity), 2, '.', ',') }}</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_amount), 2, '.', ',') }}</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_line_discount), 2, '.', ',') }}</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_sub_total), 2, '.', ',') }}</th>
                </tr>
                <tr>
                    <th colspan="3">Other Discount</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align: right">{{ number_format($invoice_draft->other_discount, 2, '.', ',') }}</th>
                </tr>
                <tr>
                    <th colspan="3">Grand Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align: right">
                        {{ number_format(array_sum($sum_sub_total) - $invoice_draft->other_discount, 2, '.', ',') }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
    <br />
    <input type="hidden" value="{{ $invoice_draft_id }}" name="invoice_draft_id">
    <input type="hidden" value="{{ array_sum($sum_sub_total) - $invoice_draft->other_discount }}" name="total_amount">
    <input type="hidden" value="{{ $invoice_draft->principal_id }}" name="principal_id">
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#invoice_out_saved").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "invoice_out_saved",
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
