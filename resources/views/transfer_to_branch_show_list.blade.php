<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm" id="example1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Transacted By</th>
                <th>#</th>
                <th>Received #</th>
                <th>PO #</th>
                <th>Principal</th>
                <th>Transfer From</th>
                <th>Transfer To</th>
                <th>Total Amount</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($transfer_to_bran as $data)
                <tr>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                    <td>{{ $data->user->name }}</td>
                    <td><a href="{{ route('transfer_to_branch_show_details', $data->id . '=' . $data->principal->principal) }}"
                            target="_blank">{{ $data->id }}</a></td>
                    <td>
                        <a target="_blank"
                            href="{{ url('received_order_report_show_details', ['id' => $data->received_id]) }}">{{ $data->received_id }}
                    </td>
                    <td>{{ $data->received_purchase_order->purchase_order->purchase_id }}</td>
                    <td>{{ $data->principal->principal }}</td>
                    <td>{{ $data->transfer_from }}</td>
                    <td>{{ $data->transfer_to }}</td>
                    <td style="text-align: right">{{ number_format($data->total_amount, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "buttons": [{
                extend: 'copyHtml5',
                footer: true
            },
            {
                extend: 'excelHtml5',
                footer: true
            },
            {
                extend: 'csvHtml5',
                footer: true
            },
            {
                extend: 'print',
                footer: true
            }
        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
