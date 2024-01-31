<form id="truck_load_generated_final_summary_invoices_data">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-striped table-sm" style="width:100%">
            <thead>
                <tr>
                    <th>{{ $sales_invoice->delivery_receipt }}</th>
                    <th>{{ $sales_invoice->customer->store_name }}</th>
                    <th>{{ $sales_invoice->principal->principal }}</th>
                    <th>{{ $sales_invoice->sku_type }}</th>
                </tr>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>KG</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice->sales_invoice_details as $data)
                    <tr>
                        <td>{{ $data->sku->sku_code }}</td>
                        <td>{{ $data->sku->description }}</td>
                        <td style="text-align: right">{{ $data->quantity }}
                            @php
                                $total_quantity[] = $data->quantity;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                echo $data->sku->kilograms;
                                $total_kg[] = $data->sku->kilograms;
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total Quantity</th>
                    <th></th>
                    <th style="text-align: right">{{ array_sum($total_quantity) }}
                        <input type="hidden" name="total_quantity" value="{{ array_sum($total_quantity) }}">
                    </th>
                    <th style="text-align: right">{{ array_sum($total_kg) }}
                        <input type="hidden" name="total_kg" value="{{ array_sum($total_kg) }}">
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>

    <input type="hidden" name="trucking_company" value="{{ $trucking_company }}">
    <input type="hidden" name="location_id" value="{{ $location_id }}">
    <input type="hidden" name="detailed_location" value="{{ $detailed_location }}">
    <input type="hidden" name="sales_invoice_id" value="{{ $sales_invoice_id }}">
    <input type="hidden" name="truck_id" value="{{ $truck_id }}">
    <input type="hidden" name="driver" value="{{ $driver }}">
    <input type="hidden" name="driver_id" value="{{ $driver_id }}">
    <input type="hidden" name="contact_number" value="{{ $contact_number }}">
    <input type="hidden" name="helper_1" value="{{ $helper_1 }}">
    <input type="hidden" name="helper_2" value="{{ $helper_2 }}">

    <button class="btn btn-sm float-right btn-info" style="submit">Proceed</button>

</form>

<script>
    $("#truck_load_generated_final_summary_invoices_data").on('submit', (function(e) {
        e.preventDefault();
        //$('#loader').show();
        $.ajax({
            url: "truck_load_generated_final_summary_invoices_data",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
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
    }));
</script>
