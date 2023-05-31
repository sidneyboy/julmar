<form id="truck_load_generated_invoices_data">
    <div class="row">
        <div class="col-md-12">
            <label for="">Invoices</label>
            <select name="sales_invoice_id[]" multiple class="form-control select2bs4" style="width:100%;" required>
                <option value="" default>Select</option>
                @foreach ($sales_invoice as $data)
                    <option value="{{ $data->id }}">{{ $data->agent->full_name }} - {{ $data->delivery_receipt }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <br />
            <input type="hidden" name="location_id" value="{{ $location_id }}">
            <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
        </div>
    </div>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#truck_load_generated_invoices_data").on('submit', (function(e) {
        e.preventDefault();
        //$('#loader').show();
        $.ajax({
            url: "truck_load_generated_invoices_data",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                $('#truck_load_generated_invoices_data_page').html(data);
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
