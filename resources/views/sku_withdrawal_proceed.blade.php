<form id="sku_withdrawal_final_summary">
    <div class="row">
        <div class="col-md-6">
            <label for="">SKU</label>
            <select name="sku_id" class="form-control select2bs4" required>
                <option value="" default>Select</option>
                @foreach ($sku as $data)
                    <option value="{{ $data->id }}">
                        [{{ $data->sku_code }}]-{{ $data->description }}-[{{ $data->sku_type }}]</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Quantity</label>
            <input type="number" min="1" class="form-control" name="quantity" required>
        </div>
        <div class="col-md-12">
            <br />
            <input type="hidden" value="{{ $principal_id }}" name="principal_id">
            <input type="hidden" value="{{ $sku_type }}" name="sku_type">
            <input type="hidden" value="{{ $price_level }}" name="price_level">
            <button class="btn btn-sm float-right btn-info">Proceed</button>
        </div>
    </div>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#sku_withdrawal_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "sku_withdrawal_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#sku_withdrawal_final_summary_page').html(data);
                $('#loader').hide();
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
