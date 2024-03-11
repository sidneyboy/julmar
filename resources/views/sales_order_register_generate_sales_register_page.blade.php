<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <th>SKU Type</th>
                <th>Store Name</th>
                <th>Principal</th>
                <th>Agent</th>
                <th>Balance</th>
                <th>DR</th>
                <th>Delivered Date</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @if ($sales_invoice_case != null)
                @foreach ($sales_invoice_case as $data_case)
                    @if (round($data_case->total, 2) - $data_case->total_payment > 0)
                        <tr>
                            <td style="color:blue;font-weight:bold;">{{ $data_case->sku_type }}</td>
                            <td>{{ $data_case->customer->store_name }}</td>
                            <td>{{ $data_case->principal->principal }}</td>
                            <td>{{ $data_case->agent->full_name }}</td>
                            <td style="text-align: right">
                                {{ number_format($data_case->total - $data_case->total_payment, 2, '.', ',') }}
                            </td>
                            <td>{{ $data_case->delivery_receipt }}</td>
                            <td>{{ $data_case->delivered_date }}</td>
                            <td><button class="btn btn-info btn-block btn-sm view_detailed_report"
                                    value="{{ $data_case->id }}">Show</button></td>
                        </tr>
                    @endif
                @endforeach
            @endif
            @if ($sales_invoice_butal != null)
                @foreach ($sales_invoice_butal as $data_butal)
                    @if (round($data_butal->total, 2) - $data_butal->total_payment > 0)
                        <tr>
                            <td style="color:green;font-weight:bold;">{{ $data_butal->sku_type }}</td>
                            <td>{{ $data_butal->customer->store_name }}</td>
                            <td>{{ $data_butal->principal->principal }}</td>
                            <td>{{ $data_butal->agent->full_name }}</td>
                            <td style="text-align: right">
                                {{ number_format($data_butal->total - $sales_invoice_case->total_payment, 2, '.', ',') }}
                            </td>
                            <td>{{ $data_butal->delivery_receipt }}</td>
                            <td>{{ $data_butal->delivered_date }}</td>
                            <td><button class="btn btn-info btn-block btn-sm view_detailed_report"
                                    value="{{ $data_butal->id }}">Show</button></td>
                        </tr>
                    @endif
                @endforeach
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
