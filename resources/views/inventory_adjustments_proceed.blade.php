<form id="inventory_adjustments_proceed_to_final_summary">
    <div class="row">
        <div class="col-md-6">
            <label for="">SKU</label>
            <select name="sku_id" class="form-control select2bs4" style="width:100%;" required>
                <option value="" default>Select</option>
                @foreach ($sku as $data)
                    <option value="{{ $data->id }}">{{ $data->sku_code }} - {{ $data->description }} -
                        {{ $data->sku_type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Quantity</label>
            <input type="text" required class="form-control" placeholder="Numbers Only!" name="quantity">
        </div>
        <div class="col-md-12">
            <br />
            <button class="btn btn-sm btn-info float-right">Final Summary</button>
        </div>
    </div>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#inventory_adjustments_proceed_to_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "inventory_adjustments_proceed_to_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'no_quantity') {
                    Swal.fire(
                        'Cannot Proceed',
                        'SKU no beginning quantity!',
                        'error'
                    )
                    $('#loader').hide();
                } else {
                    $('#inventory_adjustments_proceed_to_final_summary_page').html(data);
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
