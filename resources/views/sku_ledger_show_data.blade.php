<table class="table table-sm table-bordered table-hover table-striped" id="example1">
    <thead>
        <tr>
            <th>Date</th>
            <th>Transacted</th>
            <th>Transaction</th>
            <th>#</th>
            <th>Desc</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Adjustment</th>
            <th>Running</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < count($sku_ledger); $i++)
            <tr>
                <td>{{ date('F j, Y', strtotime($sku_ledger[$i]->created_at)) }}</td>
                <td>{{ $name[$i]->name }}</td>
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
                    @elseif($sku_ledger[$i]->transaction_type == 'releasing')
                        {{-- <a href="{{ route('transfer_to_branch_show_details', $sku_ledger[$i]->all_id . '=' . $sku_ledger[$i]->principal->principal) }}"
                            target="_blank">{{ $sku_ledger[$i]->all_id }}</a> --}}
                        {{ $sku_ledger[$i]->all_id }}
                    @elseif($sku_ledger[$i]->transaction_type == 'vs credit memo')
                        {{ $sku_ledger[$i]->all_id }}
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
                    @elseif($sku_ledger[$i]->transaction_type == 'releasing')
                        (<span style="color:red">{{ $sku_ledger[$i]->quantity }}</span>)
                    @elseif($sku_ledger[$i]->transaction_type == 'vs credit memo')
                        (<span style="color:red">{{ $sku_ledger[$i]->quantity }}</span>)
                    @else
                        0
                    @endif
                </td>
                <td style="text-align: right">
                    @if ($sku_ledger[$i]->adjustments == null)
                        0
                    @else
                        @if ($sku_ledger[$i]->adjustments < 0)
                            (<span style="color:red">
                                @php
                                    echo str_replace('-', '', $sku_ledger[$i]->adjustments);
                                @endphp
                            </span>)
                        @else
                            <span style="color:green">{{ $sku_ledger[$i]->adjustments }}</span>
                        @endif
                    @endif
                </td>
                <td style="text-align:right;">{{ number_format($sku_ledger[$i]->running_balance) }}</td>
            </tr>
        @endfor
    </tbody>
</table>

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
