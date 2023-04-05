<form id="invoice_out_very_final_summary">
    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <th>Principal</th>
                <th>Code</th>
                <th>Desc</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice_raw as $data)
                <tr>
                    <td>{{ $data->principal }}</td>
                    <td>{{ $data->sku_code }}</td>
                    <td>{{ $data->description }}</td>
                    <td>{{ $data->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br />
    <div class="row">
        <div class="col-md-6">
            <label for="">Quantity:</label>
            <input type="number" class="form-control" required min="1" name="quantity">
        </div>
        <div class="col-md-6">
            <label for="">Barcode:</label>
            <input type="text" class="form-control" required name="barcode">
        </div>
    </div>
    <br />
    
    @foreach ($customer as $customer_data)
        <input type="hidden" value="{{ $customer_data }}" name="customer_data[]">
    @endforeach

    <input type="hidden" name="sales_representative" value="{{ $sales_representative }}">
    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
</form>

<script>
    $("#invoice_out_very_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "invoice_out_very_final_summary",
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
                    $('#invoice_out_very_final_summary_page').html(data);
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
