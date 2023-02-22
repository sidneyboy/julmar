<div class="table table-responsive">
    <table class="table table-sm table-bordered table-hover" id="example1">
        <thead>
            <tr>
                <th>Transacted</th>
                <th>Transaction</th>
                <th>#</th>
                <th>Desc</th>
                <th>Quantity</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sku_ledger as $data)
                <tr>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                    <td>{{ $data->transaction_type }}</td>
                    <td>
                        @if ($data->transaction_type == 'received')
                            <a target="_blank"
                                href="{{ url('received_order_report_show_details', ['id' => $data->all_id]) }}">{{ $data->all_id }}</a>
                        @elseif($data->transaction_type == 'returned')
                            <a target="_blank"
                                href="{{ route('return_to_principal_show_list_details', $data->all_id) }}">{{ $data->all_id }}</a>
                        @endif
                    </td>
                    <td>{{ $data->sku->sku_code }} - {{ $data->sku->description }}</td>
                    <td style="text-align:right;">
                        @if ($data->transaction_type == 'received')
                            <span style="color:green">{{ $data->quantity }}</span>
                        @elseif($data->transaction_type == 'returned')
                            (<span style="color:red">{{ $data->quantity }}</span>)
                        @endif
                    </td>
                    <td style="text-align:right;">{{ number_format($data->running_balance) }}</td>
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
