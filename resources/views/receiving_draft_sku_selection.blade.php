<form id="receiving_draft_proceed">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-sm float-right btn-dark" id="scan_barcode" style="display:none">SCAN BARCODE</a>
            <a class="btn btn-sm float-right btn-warning" id="select_sku">SELECT SKU</a>
        </div>
    </div>
    <div class="row" id="show_sku" style="display:none">
        <div class="col-md-6">
            <label for="">Quantity:</label>
            <input type="number" class="form-control" min="1" name="sku_quantity" id="sku_quantity">
        </div>
        <div class="col-md-6">
            <label for="">SKU:</label>
            <select name="sku_barcode" id="sku_barcode" class="form-control select2bs4">
                <option value="" default>Select</option>
                @foreach ($purchase_order_details as $data)
                    <option value="{{ $data->sku_id }}">[<span
                            style="font-weight: bold;color:green">{{ $data->sku->sku_code }}</span>] -
                        {{ $data->sku->description }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" id="show_barcode">
        <div class="col-md-6">
            <label for="">Quantity:</label>
            <input type="number" class="form-control" min="1" name="quantity" id="quantity">
        </div>
        <div class="col-md-6">
            <label for="">Barcode:</label>
            <input type="text" class="form-control" id="barcode" name="barcode">
        </div>
    </div>
    <br />
    <input type="hidden" name="purchase_order_id" value="{{ $purchase_order_id }}">
    <button class="btn btn-info btn-sm float-right" type="submit">Proceed</button>
</form>


<script>
    $("#receiving_draft_proceed").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "receiving_draft_proceed",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                $('#show_draft').html(data);
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
</script>
