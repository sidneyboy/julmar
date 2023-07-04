<div class="table table-responsive">
    <table class="table table-bordered table-striped table-sm" style="width:100%;font-size:11px;" id="example1">
        <thead>
            <tr>
                <th>DATE</th>
                <th>SALES AREA</th>
                <th>SALESMAN</th>
                <th>INVOICE</th>
                <th>NAME OF OUTLET</th>
                <th>ADDRESS</th>
                <th>CASE</th>
                <th>BUTAL</th>
                <th>CONVERSION</th>
                <th>AMOUNT</th>
                <th>TRANSACTION</th>
                <th>TOTAL WEIGHT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logistics as $data)
                @foreach ($data->logistics_invoices as $details)
                    <tr>
                        <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                        <td>{{ $data->location->location }}</td>
                        <td>{{ $details->sales_invoice->agent->full_name }}</td>
                        <td>{{ $details->sales_invoice->delivery_receipt }}</td>
                        <td>{{ $details->sales_invoice->customer->store_name }}</td>
                        <td>{{ $details->sales_invoice->customer->detailed_location }}</td>
                        <td>{{ $details->case }}</td>
                        <td>{{ $details->butal }}</td>
                        <td>{{ $details->conversion }}</td>
                        <td>{{ $details->amount }}</td>
                        <td>{{ $details->sales_invoice->customer->mode_of_transaction }}</td>
                        <th>{{ $details->weight }}</th>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: false,
            ordering: true,
            info: false,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
