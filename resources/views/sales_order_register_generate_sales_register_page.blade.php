<div class="table table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STORE NAME</th>
                <th>PRINCIPAL</th>
                <th>AGENT</th>
                <th>TOTAL</th>
                <th>DR</th>
                <th>DATE</th>
                <th>DETAILS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sales_invoice->customer->store_name }}</td>
                <td>{{ $sales_invoice->principal->principal }}</td>
                <td>{{ $sales_invoice->agent->full_name }}</td>
                <td style="text-align: right">{{ number_format($sales_invoice->total, 2, '.', ',') }}</td>
                <td>{{ $sales_invoice->delivery_receipt }}</td>
                <td>{{ $sales_invoice->delivered_date }}</td>
                <td><button class="btn btn-info btn-block view_detailed_report" value="{{ $sales_invoice->id }}">VIEW
                        DETAILS</button></td>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(".view_detailed_report").on('click', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        var sales_invoice_id = $(this).val();
        $.ajax({
            url: "sales_order_register_view_details",
            type: "POST",
            data: 'sales_invoice_id=' + sales_invoice_id,
            success: function(data) {
                console.log(data);
                $('.loading').hide();
                $('#sales_order_register_view_details').html(data);

            },
        });
    }));
</script>
