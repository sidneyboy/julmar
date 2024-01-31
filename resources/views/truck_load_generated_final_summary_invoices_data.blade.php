<form id="truck_load_generated_very_final_summary_invoices_data">
    <label for="">Total Expense Per Delivery</label>
    <input type="text" class="form-control" required name="total_expense_per_delivery"
        onkeypress="return isNumberKey(event)">
    <br />
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-striped table-sm" style="width:100%;">
            <thead>
                <tr>
                    <th>Delivery Receipt</th>
                    <th>Agent</th>
                    <th>Customer</th>
                    <th>Principal</th>
                    <th>Sku Type</th>
                    <th>Location</th>
                    <th>Total QTY</th>
                    <th>Total KG</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $data)
                    <tr>
                        <td>{{ $data->associatedModel->delivery_receipt }}</td>
                        <td>{{ $data->associatedModel->agent->full_name }}</td>
                        <td>{{ $data->associatedModel->customer->store_name }}</td>
                        <td>{{ $data->associatedModel->principal->principal }}</td>
                        <td>{{ $data->associatedModel->sku_type }}</td>
                        <td>{{ $data->associatedModel->customer->location->location }}</td>
                        <th style="text-align: right">{{ $data->quantity }}</th>
                        <th style="text-align: right">
                            @foreach ($data->attributes as $item)
                                {{ $item['kilograms'] }}
                            @endforeach
                        </th>
                        <td style="text-align: center;"><button value="{{ $data->id }}"
                                class="btn btn-sm btn-danger remove_invoice"><i class="bi bi-trash"></i></button>
                            <input type="hidden" name="final_sales_invoice_id[]" value="{{ $data->id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <input type="hidden" name="location_id" id="location_id" value="{{ $location_id }}">
    <input type="hidden" name="trucking_company" id="trucking_company" value="{{ $trucking_company }}">
    <input type="hidden" name="detailed_location" id="detailed_location" value="{{ $detailed_location }}">
    <input type="hidden" name="sales_invoice_id" id="sales_invoice_id" value="{{ $sales_invoice_id }}">
    <input type="hidden" name="truck_id" id="truck_id" value="{{ $truck_id }}">
    <input type="hidden" name="driver" id="driver" value="{{ $driver }}">
    <input type="hidden" name="driver_id" id="driver_id" value="{{ $driver_id }}">
    <input type="hidden" name="contact_number" id="contact_number" value="{{ $contact_number }}">
    <input type="hidden" name="helper_1" id="helper_1" value="{{ $helper_1 }}">
    <input type="hidden" name="helper_2" id="helper_2" value="{{ $helper_2 }}">

    <button class="btn btn-sm float-right btn-info" type="submit">Generate Final Summary</button>
</form>


<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $("#truck_load_generated_very_final_summary_invoices_data").on('submit', (function(e) {
        e.preventDefault();
        //$('#loader').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "truck_load_generated_very_final_summary_invoices_data",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                $('#truck_load_generated_very_final_summary_invoices_data_page').html(data);
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

    $(".remove_invoice").click(function() {
        //$('#loader').show();
        var sales_invoice_id = $(this).val();
        var location_id = $('#location_id').val();
        var detailed_location = $('#detailed_location').val();
        var truck_id = $('#truck_id').val();
        var driver = $('#driver').val();
        var contact_number = $('#contact_number').val();
        var helper_1 = $('#helper_1').val();
        var helper_2 = $('#helper_2').val();
        var trucking_company = $('#trucking_company').val();

        $.post({
            type: "POST",
            url: "/truck_load_generated_final_summary_invoices_remove_data",
            data: 'sales_invoice_id=' + sales_invoice_id + '&location_id=' + location_id +
                '&detailed_location=' + detailed_location + '&truck_id=' + truck_id + '&driver=' +
                driver + '&contact_number=' + contact_number + '&helper_1=' + helper_1 + '&helper_2=' +
                helper_2 + '&trucking_company=' +
                trucking_company,
            success: function(data) {
                $('#loader').hide();
                $('#truck_load_generated_final_summary_invoices_data_page').html(data);
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
    });
</script>
