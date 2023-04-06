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
        <div class="col-md-12">
            <a class="btn btn-sm float-right btn-dark" id="scan_barcode" style="display:none">SCAN BARCODE</a>
            <a class="btn btn-sm float-right btn-warning" id="select_sku">SELECT SKU</a>
        </div>
    </div>
    <div class="row" id="show_sku" style="display:none">
        <div class="col-md-6">
            <label for="">Quantity:</label>
            <input type="number" class="form-control" min="1" id="sku_quantity" name="sku_quantity">
        </div>
        <div class="col-md-6">
            <label for="">SKU:</label>
            <select name="sku_barcode" id="sku_barcode" class="form-control select2bs4">
                <option value="" default>Select</option>
                @foreach ($invoice_raw as $data)
                    <option value="{{ $data->barcode }}">[<span
                            style="font-weight: bold;color:green">{{ $data->sku_code }}</span>] -
                        {{ $data->description }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" id="show_barcode">
        <div class="col-md-6">
            <label for="">Quantity:</label>
            <input type="number" class="form-control" min="1" id="quantity" name="quantity">
        </div>
        <div class="col-md-6">
            <label for="">Barcode:</label>
            <input type="text" class="form-control" id="barcode" name="barcode">
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
    $("#select_sku").click(function() {
       $('#show_barcode').hide();
       $('#select_sku').hide();
       $('#show_sku').show();
       $('#scan_barcode').show();
       $('#quantity').val('');
       $('#barcode').val('');
    });

    $("#scan_barcode").click(function() {
       $('#show_barcode').show();
       $('#select_sku').show();
       $('#show_sku').hide();
       $('#scan_barcode').hide();
       $('#sku_quantity').val('');
       $("#sku_barcode").val('').trigger('change') ;
    });

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#invoice_out_very_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
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
                    $('#loader').hide();
                } else {
                    $('#invoice_out_very_final_summary_page').html(data);
                    $('#loader').hide();
                }
            },
            error: function(error) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
                $('#loader').hide();
            }
        });
    }));
</script>
