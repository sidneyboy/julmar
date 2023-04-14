<form id="invoice_out_van_final_summary">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th>Principal</th>
                    <th>Desc</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($van_selling_draft as $data)
                    <tr>
                        <td>{{ $data->sku->skuPrincipal->principal }}</td>
                        <td>[<span style="color:green">{{ $data->sku->sku_code }}</span>] - {{ $data->sku->description }}
                        </td>
                        <td style="text-align: right">{{ $data->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-sm float-right btn-dark" id="scan_barcode" style="display:none">SCAN BARCODE</a>
            <a class="btn btn-sm float-right btn-warning" id="select_sku">SELECT SKU</a>
        </div>
    </div>
    <div class="row" id="show_sku" style="display:none">
        <div class="col-md-12">
            <label for="">SKU:</label>
            <select name="sku_barcode" id="sku_barcode" class="form-control select2bs4">
                <option value="" default>Select</option>
                @foreach ($van_selling_draft as $data)
                    <option value="{{ $data->sku_id }}">[<span
                            style="font-weight: bold;color:green">{{ $data->sku->sku_code }}</span>] -
                        {{ $data->sku->description }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" id="show_barcode">
        <div class="col-md-12">
            <label for="">Barcode:</label>
            <input type="text" class="form-control" id="barcode" name="barcode">
        </div>
    </div>
    <br />
    <input type="hidden" name="rep_dr" value="{{ $rep_dr }}">
    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

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
        $("#sku_barcode").val('').trigger('change');
    });


    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#invoice_out_van_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "invoice_out_van_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'invalid') {
                    $('#loader').hide();
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
                    $('#loader').hide();
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
