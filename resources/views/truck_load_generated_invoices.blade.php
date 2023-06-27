<form id="truck_load_generated_invoices_data">
    <div class="row">
        <div class="col-md-4">
            <label for="">Truck</label>
            <select name="truck_id" class="form-control" required>
                <option value="" default>Select</option>
                @foreach ($truck as $data)
                    <option value="{{ $data->id . '-' . $data->plate_no }}">{{ $data->plate_no }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="">Driver</label>
            <input type="text" class="form-control" name="driver" required style="text-transform: uppercase">
        </div>
        <div class="col-md-4">
            <label for="">Contact #</label>
            <input type="text" class="form-control" name="contact_number" required
                onkeypress="return isNumberKey(event)">
        </div>
        <div class="col-md-6">
            <label for="">Helper 1</label>
            <input type="text" class="form-control" name="helper_1" required style="text-transform: uppercase">
        </div>
        <div class="col-md-6">
            <label for="">Helper 2</label>
            <input type="text" class="form-control" name="helper_2" required style="text-transform: uppercase">
        </div>
        <div class="col-md-12">
            <label for="">Detailed Location</label>
            @foreach ($location as $location_data)
               <p> {{ $location_data->detailed_location .","}} </p>
            @endforeach
        </div>
        <div class="col-md-12">
            <label for="">Invoices</label>
            <select name="sales_invoice_id" class="form-control select2bs4" style="width:100%;" required>
                <option value="" default>Select</option>
                @foreach ($sales_invoice as $data)
                    <option value="{{ $data->id }}">{{ $data->agent->full_name }} - {{ $data->delivery_receipt }}
                    </option>
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

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

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
