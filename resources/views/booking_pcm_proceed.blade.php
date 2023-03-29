<form id="booking_pcm_proceed_final_summary">
    <div class="row">
        <div class="col-md-4">
            <label for="">SKU:</label>
            <select name="sku_id" id="sku_id" class="form-control select2bs4" style="width:100%;" required>
                <option value="" default>Select</option>
                @foreach ($sku as $data)
                    <option value="{{ $data->id }}">[{{ $data->sku_code }}] - {{ $data->description }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="">Quantity:</label>
            <input type="number" min="1" class="form-control" id="quantity" required name="quantity">
        </div>
        <div class="col-md-4">
            <label for="">Unit Price:</label>
            <input type="text" class="form-control" required id="unit_price" name="unit_price" onkeypress="return isNumberKey(event)">
        </div>
        <div class="col-md-12">
            <br />
            <input type="hidden" value="{{ $principal_id }}" name="principal_id">
            <input type="hidden" value="{{ $sku_type }}" name="sku_type">
            <input type="hidden" value="{{ $pcm_type }}" name="pcm_type">
            <input type="hidden" value="{{ $agent_id }}" name="agent_id">
            <input type="hidden" value="{{ $customer_id }}" name="customer_id">
            <button class="btn btn-sm float-right btn-info" type="submit">Final Summary</button>
        </div>
    </div>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#booking_pcm_proceed_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "booking_pcm_proceed_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('#unit_price').val('');
                $('#quantity').val('');
                $("#sku_id").val('').trigger('change') ;
                $('#booking_pcm_proceed_final_summary_page').html(data);
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
