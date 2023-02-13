<form id="dr_update_status_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Delivery Receipt</th>
                    <th>Store Name</th>
                    <th>Principal</th>
                    <th>Agent</th>
                    <th>Total</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice_data as $data)
                    <tr>
                        <td>{{ $data->delivery_receipt }}</td>
                        <td>{{ $data->customer->store_name }}</td>
                        <td>{{ $data->principal->principal }}</td>
                        <td>{{ $data->agent->full_name }}</td>
                        <td style="text-align: right">{{ number_format($data->total, 2, '.', ',') }}</td>
                        <td>
                            {{ $sales_invoice_status[$data->id] }}
                            <input type="hidden" value="{{ $data->id }}" name="sales_invoice_id[]">
                            <input type="hidden" value="{{ $sales_invoice_status[$data->id] }}"
                                name="sales_invoice_status[{{ $data->id }}]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <button type="submit" class="btn btn-block btn-info">Proceed To Final Summary</button>
</form>

<script>
    $("#dr_update_status_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        // $('#sales_order_migrate_summary_page').show();
        $.ajax({
            url: "dr_update_status_save",
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
