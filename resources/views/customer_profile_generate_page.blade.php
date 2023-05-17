<div class="table table-responsive">
    <table class="table table-bordered table-hover table-striped table-sm" style="font-size:13px;width:100%;" id="example1">
        <thead>
            <tr>
                <th>BOOKING CUSTOMER</th>
                <th>ID</th>
                <th>Store Name</th>
                <th>KOB</th>
                <th>Credit Term</th>
                <th>Credit Line</th>
                <th>Location</th>
                <th>Location ID</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Mode of Transaction</th>
                <th>Max SO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer as $data)
                <tr>
                    <td>CUSTOMER DATA</td>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->store_name }}</td>
                    <td>{{ $data->kind_of_business }}</td>
                    <td style="text-align: right">{{ $data->credit_term }}</td>
                    <td style="text-align: right">{{ number_format($data->credit_line_amount, 2, '.', ',') }}</td>
                    <td>{{ $data->location->location }}</td>
                    <td>{{ $data->location_id }}</td>
                    <td>
                        @if ($data->contact_person)
                            {{ $data->contact_person }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($data->contact_number)
                            0{{ $data->contact_number }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $data->latitude }}</td>
                    <td>{{ $data->longitude }}</td>
                    <td>{{ $data->mode_of_transaction }}</td>
                    <td>{{ $data->allowed_number_of_sales_order }}</td>
                </tr>
                @foreach ($data->customer_principal_price as $details)
                    <tr>
                        <td>CUSTOMER PRICE</td>
                        <td>{{ $details->customer_id }}</td>
                        <td>{{ $details->principal_id }}</td>
                        <td>{{ $details->price_level }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
            ordering: false,
            info: true,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                {
                    extend: 'csvHtml5',
                    filename: 'Booking Customer',
                    title: 'BOOKING CUSTOMER',
                },
                'pdfHtml5'
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
