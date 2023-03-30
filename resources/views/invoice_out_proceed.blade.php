<form id="invoice_out_final_summary">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="1">{{ $invoice_draft[0]->sales_representative }}</th>
                    <th colspan="2">{{ $invoice_draft[0]->customer }}</th>
                </tr>
                <tr>
                    <th>Desc</th>
                    <th>SKU Type</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice_draft as $data)
                    <tr>
                        <td>[<span style="color:green">{{ $data->sku_code }}</span>] - {{ $data->description }}</td>
                        <td>{{ $data->sku->sku_type }}</td>
                        <td>{{ $data->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="">Quantity:</label>
            <input type="number" min="1" class="form-control" required id="confirmed_quantity" name="confirmed_quantity">
        </div>
        <div class="col-md-6">
            <label for="">Barcode:</label>
            <input type="text" class="form-control" required id="barcode" name="barcode">
        </div>
    </div>
    <br />
    <input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
    <button class="btn btn-sm float-right btn-info">Proceed to final summary</button>
</form>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#invoice_out_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "invoice_out_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'invalid') {
                    Swal.fire(
                        'Cannot Proceed',
                        'Invalid Barcode',
                        'error'
                    )
                } else {
                    $('#confirmed_quantity').val('');
                    $('#barcode').val('');
                    $('#confirmed_quantity').focus();
                    $('#invoice_out_final_summary_page').html(data);
                }
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
