<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <th>SKU Type</th>
                <th>Store Name</th>
                <th>Principal</th>
                <th>Agent</th>
                <th>Total</th>
                <th>DR</th>
                <th>Delivered Date</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @if ($sales_invoice_case != null)
                <tr>
                    <td style="color:blue;font-weight:bold;">{{ $sales_invoice_case->sku_type }}</td>
                    <td>{{ $sales_invoice_case->customer->store_name }}</td>
                    <td>{{ $sales_invoice_case->principal->principal }}</td>
                    <td>{{ $sales_invoice_case->agent->full_name }}</td>
                    <td style="text-align: right">{{ number_format($sales_invoice_case->total, 2, '.', ',') }}</td>
                    <td>{{ $sales_invoice_case->delivery_receipt }}</td>
                    <td>{{ $sales_invoice_case->delivered_date }}</td>
                    <td><button class="btn btn-info btn-block btn-sm view_detailed_report"
                            value="{{ $sales_invoice_case->id }}">Show</button></td>
                </tr>
            @endif
            @if ($sales_invoice_butal != null)
                <tr>
                    <td style="color:green;font-weight:bold;">{{ $sales_invoice_butal->sku_type }}</td>
                    <td>{{ $sales_invoice_butal->customer->store_name }}</td>
                    <td>{{ $sales_invoice_butal->principal->principal }}</td>
                    <td>{{ $sales_invoice_butal->agent->full_name }}</td>
                    <td style="text-align: right">{{ number_format($sales_invoice_butal->total, 2, '.', ',') }}</td>
                    <td>{{ $sales_invoice_butal->delivery_receipt }}</td>
                    <td>{{ $sales_invoice_butal->delivered_date }}</td>
                    <td><button class="btn btn-info btn-block btn-sm view_detailed_report"
                            value="{{ $sales_invoice_butal->id }}">Show</button></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(".view_detailed_report").on('click', (function(e) {
        e.preventDefault();
        $('#loader').show();
        var sales_invoice_id = $(this).val();
        $.ajax({
            url: "sales_order_register_view_details",
            type: "POST",
            data: 'sales_invoice_id=' + sales_invoice_id,
            success: function(data) {
                $('#loader').hide();
                $('#sales_order_register_view_details').html(data);
            },
        });
    }));
</script>
