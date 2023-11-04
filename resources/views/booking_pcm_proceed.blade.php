<form id="booking_pcm_proceed_final_summary">
    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <td>Customer:</td>
                <th style="text-align: center;">{{ $sales_invoice->customer->store_name }}</th>
                <td>Principal:</td>
                <th style="text-align: center;">{{ $sales_invoice->principal->principal }}</th>
                <td>Delivery Receipt:</td>
                <th style="text-align: center;">{{ $sales_invoice->delivery_receipt }}</th>
                <td>Sku Type:</td>
                <th style="text-align: center;">{{ $sales_invoice->sku_type }}
                    <input type="hidden" name="customer_id" value="{{ $sales_invoice->customer_id }}">
                    <input type="hidden" name="principal_id" value="{{ $sales_invoice->principal_id }}">
                    <input type="hidden" name="agent_id" value="{{ $sales_invoice->agent_id }}">
                    <input type="hidden" name="sku_type" value="{{ $sales_invoice->sku_type }}">
                    <input type="hidden" name="sales_invoice_id" value="{{ $sales_invoice->id }}">
                </th>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <th style="text-align: center;">Code</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: center;">Unit Price</th>
                <th style="text-align: center;">Quantity Returned</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_invoice->sales_invoice_details as $details)
                <tr>
                    <td>{{ $details->sku->sku_code }}</td>
                    <td>{{ $details->sku->description }}</td>
                    <td style="text-align: right">{{ $details->quantity }}</td>
                    <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                    <td>
                        <input type="number" min="0" class="form-control form-control-sm"
                            name="quantity_returned[{{ $details->id }}]">
                        <input type="hidden" min="0" value="{{ $details->quantity }}"
                            class="form-control form-control-sm" name="quantity[{{ $details->id }}]">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
</form>

<script>
    $("#booking_pcm_proceed_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "booking_pcm_proceed_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                $('#loader').hide();

                if (data == 'quantity_exceed') {
                    Swal.fire(
                        'Cannot Proceed',
                        'Quantity returned exceeds invoice quantity',
                        'error'
                    )
                } else {
                    $('#unit_price').val('');
                    $('#quantity').val('');
                    $("#sku_id").val('').trigger('change');
                    $('#booking_pcm_proceed_final_summary_page').html(data);
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
