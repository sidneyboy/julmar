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
                <th style="text-align: center;">{{ $sales_invoice->sku_type }}</th>
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
                    <td><input type="number" min="0" class="form-control form-control-sm"
                            name="quantity_returned[{{ $details->id }}]"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

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
                console.log(data);
                $('#unit_price').val('');
                $('#quantity').val('');
                $("#sku_id").val('').trigger('change');
                $('#booking_pcm_proceed_final_summary_page').html(data);
                $('#loader').hide();
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
