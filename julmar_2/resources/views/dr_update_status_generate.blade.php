<form id="dr_update_status_generate_final_summary">
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
                            <select name="sales_invoice_status[{{ $data->id }}]" class="form-control select2" required style="width:100%;">
                                <option value="" default>Set Status</option>
                                <option value="Received By Warehouse">Received By Warehouse</option>
                                <option value="Out From Warehouse">Out From Warehouse</option>
                            </select>
                            <input type="hidden" value="{{ $data->id }}" name="sales_invoice_id[]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <button type="submit" class="btn btn-block btn-info">Proceed To Final Summary</button>
</form>

<script>
    $("#dr_update_status_generate_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        // $('#sales_order_migrate_summary_page').show();
        $.ajax({
            url: "dr_update_status_generate_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#dr_update_status_generate_final_summary_page').html(data);
            },
        });
    }));
</script>
