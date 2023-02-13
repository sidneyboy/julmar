<form id="dr_for_delivery_proceed_to_final_summary">

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Truck</label>
                <select name="truck_id" class="form-control select2" required style="width:100%">
                    <option value="" default>Select</option>
                    @foreach ($truck as $data)
                        <option value="{{ $data->id }}">
                            {{ $data->plate_no . ' - ' . $data->model . ' - ' . $data->capacity }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Driver</label>
                <input type="text" class="form-control" required name="driver">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Assistant</label>
                <input type="text" class="form-control" required name="assistant">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-info btn-block">Proceed To Final Summary</button>
            </div>
        </div>
    </div>
    <br />

    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Area</th>
                    <th>Customer</th>
                    <th>Agent</th>
                    <th>Principal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice_data as $data)
                    <tr>
                        <td>{{ $data->customer->location->location }}</td>
                        <td>{{ $data->customer->store_name }}</td>
                        <td>{{ $data->agent->full_name }}</td>
                        <td>{{ $data->principal->principal }}</td>
                        <td style="text-align: right">
                            {{ number_format($data->total, 2, '.', ',') }}
                            <input type="hidden" name="sales_invoice_id[]" value="{{ $data->id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>

<script>
    $('.select2').select2();

    $("#dr_for_delivery_proceed_to_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        // $('#sales_order_migrate_summary_page').show();
        $.ajax({
            url: "dr_for_delivery_proceed_to_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#dr_for_delivery_proceed_to_final_summary_page').html(data)
            },
        });
    }));
</script>
