<form id="purchase_order_report_show_data">
    <div class="row">
        <div class="col-md-12">
            <select name="purchase_order_id" class="form-control" required>
                <option value="" default>Select Purchase Order</option>
                @foreach ($purchase_order_data as $data)
                    <option value="{{ $data->id }}">{{ $data->purchase_id }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <br />
            <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
        </div>
    </div>
</form>

<script>
    $("#purchase_order_report_show_data").on('submit', (function(e) {
        e.preventDefault();
        //$('#loader').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "purchase_order_report_show_data",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                $('#show_report_data').html(data);
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
