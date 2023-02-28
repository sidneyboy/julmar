<div class="table table-responsive">
    <table class="table table-sm table-bordered table-hover" id="example1">
        <thead>
            <tr>
                <th>Transacted By</th>
                <th>Transacted</th>
                <th>Transaction</th>
                <th>#</th>
                <th>Desc</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($sku_ledger); $i++)
                <tr>
                    <td>{{ $name[$i]->name }}</td>
                    <td>{{ date('F j, Y', strtotime($sku_ledger[$i]->created_at)) }}</td>
                    <td>{{ $sku_ledger[$i]->transaction_type }}</td>
                    <td>
                        @if ($sku_ledger[$i]->transaction_type == 'received')
                            <a target="_blank"
                                href="{{ url('received_order_report_show_details', ['id' => $sku_ledger[$i]->all_id]) }}">{{ $sku_ledger[$i]->all_id }}</a>
                        @elseif($sku_ledger[$i]->transaction_type == 'returned')
                            <a target="_blank"
                                href="{{ route('return_to_principal_show_list_details', $sku_ledger[$i]->all_id) }}">{{ $sku_ledger[$i]->all_id }}</a>
                        @elseif($sku_ledger[$i]->transaction_type == 'out from warehouse')
                            {{ $sku_ledger[$i]->all_id }}
                        @elseif($sku_ledger[$i]->transaction_type == 'bodega out')
                            <a href="{{ route('bodega_out_show_details', $sku_ledger[$i]->all_id) }}"
                                target="_blank">{{ $sku_ledger[$i]->all_id }}</a>
                        @elseif($sku_ledger[$i]->transaction_type == 'bodega in')
                            <a href="{{ route('bodega_out_show_details', $sku_ledger[$i]->all_id) }}"
                                target="_blank">{{ $sku_ledger[$i]->all_id }}</a>
                        @elseif($sku_ledger[$i]->transaction_type == 'transfer to branch')
                            <a href="{{ route('transfer_to_branch_show_details', $sku_ledger[$i]->all_id . '=' . $sku_ledger[$i]->principal->principal) }}"
                                target="_blank">{{ $sku_ledger[$i]->all_id }}</a>
                        @endif
                    </td>
                    <td>{{ $description[$i]->sku_code }} - {{ $description[$i]->description }}</td>
                    <td>
                        {{ $description[$i]->sku_type }}
                    </td>
                    <td style="text-align:right;">
                        @if ($sku_ledger[$i]->transaction_type == 'received')
                            <span style="color:green">{{ $sku_ledger[$i]->quantity }}</span>
                        @elseif($sku_ledger[$i]->transaction_type == 'returned')
                            (<span style="color:red">{{ $sku_ledger[$i]->quantity }}</span>)
                        @elseif($sku_ledger[$i]->transaction_type == 'out from warehouse')
                            (<span style="color:red">{{ $sku_ledger[$i]->quantity }}</span>)
                        @elseif($sku_ledger[$i]->transaction_type == 'bodega in')
                            <span style="color:green">{{ $sku_ledger[$i]->quantity }}</span>
                        @elseif($sku_ledger[$i]->transaction_type == 'bodega out')
                            (<span style="color:red">{{ $sku_ledger[$i]->quantity }}</span>)
                        @elseif($sku_ledger[$i]->transaction_type == 'transfer to branch')
                            (<span style="color:red">{{ $sku_ledger[$i]->quantity }}</span>)
                        @endif
                    </td>
                    <td style="text-align:right;">{{ number_format($sku_ledger[$i]->running_balance) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<script>
    $("#example1").DataTable({
        "responsive": false,
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
