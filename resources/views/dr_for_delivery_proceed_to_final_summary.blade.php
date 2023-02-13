<form id="dr_for_delivery_saved">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Plate & Model {{ $truck->plate_no . ' - ' . $truck->model }}</th>
                    <th>Driver: {{ $driver }}</th>
                    <th colspan="3">Pahinante: {{ $assistant }}</th>
                </tr>
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
    <input type="hidden" name="driver" value="{{ $driver }}">
    <input type="hidden" name="assistant" value="{{ $assistant }}">
    <input type="hidden" name="truck_id" value="{{ $truck->id }}">
    <button type="submit" class="btn btn-block btn-success">Submit</button>
</form>

<script>
    $('.select2').select2();

    $("#dr_for_delivery_saved").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        // $('#sales_order_migrate_summary_page').show();
        $.ajax({
            url: "dr_for_delivery_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data = 'saved') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    location.reload();
                }
            },
        });
    }));
</script>
