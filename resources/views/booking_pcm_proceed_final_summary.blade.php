<form id="booking_pcm_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="5">
                        <input type="text" name="returned_by" style="text-transform:uppercase" class="form-control"
                            required placeholder="Returned By ?">
                    </th>
                    <th colspan="5">
                        <input type="text" name="pcm_number" class="form-control" required placeholder="PCM #">
                    </th>
                </tr>
                <tr>
                    <td>PCM Type:</td>
                    <th>Return Good Stock</th>
                    <td>Customer:</td>
                    <th style="text-align: center;">{{ $sales_invoice_details[0]->sales_invoice->customer->store_name }}
                    </th>
                    <td>Principal:</td>
                    <th style="text-align: center;">{{ $sales_invoice_details[0]->sales_invoice->principal->principal }}
                    </th>
                    <td>Delivery Receipt:</td>
                    <th style="text-align: center;">{{ $sales_invoice_details[0]->sales_invoice->delivery_receipt }}
                    </th>
                    <td>Sku Type:</td>
                    <th style="text-align: center;">{{ $sales_invoice_details[0]->sales_invoice->sku_type }}
                        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                        <input type="hidden" name="delivery_receipt"
                            value="{{ $sales_invoice_details[0]->sales_invoice->delivery_receipt }}">
                        <input type="hidden" name="principal_id" value="{{ $principal_id }}">
                        <input type="hidden" name="agent_id" value="{{ $agent_id }}">
                        <input type="hidden" name="sku_type" value="{{ $sku_type }}">
                        <input type="hidden" name="sales_invoice_id" value="{{ $sales_invoice_id }}">
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="table table-responsive"></div>
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
            @foreach ($sales_invoice_details as $details)
                <tr>
                    <td>{{ $details->sku->sku_code }}</td>
                    <td>{{ $details->sku->description }}</td>
                    <td style="text-align: right">{{ $quantity_returned[$details->id] }}</td>
                    <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                    <td style="text-align: right">
                        @php
                            $sub_total = $quantity_returned[$details->id] * $details->unit_price;
                            $sum_total[] = $sub_total;
                            $sum_quantity[] = $quantity_returned[$details->id];
                            echo number_format($sub_total, 2, '.', ',');
                        @endphp
                        <input type="hidden" name="quantity_returned[{{ $details->id }}]"
                            value="{{ $quantity_returned[$details->id] }}">
                        <input type="hidden" name="unit_price[{{ $details->id }}]"
                            value="{{ $details->unit_price }}">
                    </td>
                    <td><input type="text" class="form-control form-control-sm" name="remarks[{{ $details->id }}]">
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th style="text-align: right">{{ array_sum($sum_quantity) }}</th>
                <th></th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" value="{{ array_sum($sum_total) }}" name="total_amount">
    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
</form>

<script>
    $("#booking_pcm_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "booking_pcm_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                if (data == 'existing pcm number') {
                    Swal.fire(
                        'Cannot Proceed',
                        'Existing PCM #!',
                        'error'
                    )
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    location.reload();
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
