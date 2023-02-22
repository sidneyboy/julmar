<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm" id="example1">
        <thead>
            <tr>
				<th>Transacted</th>
                <th>Principal</th>
                <th>#</th>
                <th>Transaction</th>
                <th>AP / Beg</th>
                <th>Received</th>
                <th>Returned</th>
                <th>Adjustment</th>
                <th>Payment</th>
                <th>AP / End</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($principal_ledger as $data)
                <tr>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                    <td>{{ $data->principal->principal }}</td>
                    <td style="text-align: center;">
                        @if ($data->transaction == 'received')
                            <a target="_blank"
                                href="{{ url('received_order_report_show_details', ['id' => $data->all_id]) }}">{{ $data->all_id }}</a>
                        @elseif($data->transaction == 'returned')
                            <a target="_blank"
                                href="{{ route('return_to_principal_show_list_details', $data->all_id) }}">{{ $data->all_id }}</a>
                        @elseif($data->transaction == 'bo adjustment')
                            <a href="{{ route('bo_allowance_adjustments_show_details', $data->all_id) }}"
                                target="_blank">DM -
                                BO {{ $data->all_id }}</a>
                        @elseif($data->transaction == 'invoice cost adjustment')
                            <a href="{{ route('invoice_cost_adjustments_show_details', $data->all_id) }}"
                                target="_blank">{{ $data->all_id }}</a>
                        @else
                            {{ $data->all_id }}
                        @endif
                    </td>
                    <td>{{ Str::ucfirst($data->transaction) }}</td>
                    <td style="text-align: right">{{ number_format($data->accounts_payable_beginning, 2, '.', ',') }}
                       
                    </td>
                    <td style="text-align: right">{{ number_format($data->received, 2, '.', ',') }}
                        
                    </td>
                    <td style="text-align: right">{{ number_format($data->returned, 2, '.', ',') }}
                      
                    </td>
                    <td style="text-align: right">
                        @if ($data->adjustment < 0)
                            <span
                                style="color:red;">{{ ' (' . number_format($data->adjustment * -1, 2, '.', ',') . ')' }}</span>
                        @else
                            {{ number_format($data->adjustment, 2, '.', ',') }}
                        @endif
                       
                    </td>
                    <td style="text-align: right">{{ number_format($data->payment, 2, '.', ',') }}
                  
                    </td>
                    <td style="text-align: right">{{ number_format($data->accounts_payable_end, 2, '.', ',') }}

                    </td>
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
