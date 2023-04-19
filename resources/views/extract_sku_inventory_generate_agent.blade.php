<form id="extract_sku_inventory_generate_agent_proceed">
    <div class="row">
        <div class="col-md-6">
            <label for="">Agent</label>
            <select name="agent_id" class="form-control select2bs4" required>
                <option value="" default>Select</option>
                @foreach ($agent as $data)
                    <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Principal</label>
            <select name="principal_id[]" class="form-control select2bs4" multiple="multiple" required>
                <option value="" default>Select</option>
                @foreach ($principal as $data)
                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br />
    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
</form>
<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#extract_sku_inventory_generate_agent_proceed").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "extract_sku_inventory_generate_agent_proceed",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                $('#extract_sku_inventory_generate_export_data_page').html(data);
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
