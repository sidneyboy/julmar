<table class="table table-sm table-bordered table-hover table-striped" id="example1">
    <thead>
        <tr>
            <th>Date</th>
            <th>Desc</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Adjustment</th>
            <th>Running Inventory</th>
            <th>Running Amount</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < count($sku_ledger); $i++)
            <tr>
                <td>{{ date('F j, Y', strtotime($sku_ledger[$i]->created_at)) }}</td>
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
                    @elseif($sku_ledger[$i]->transaction_type == 'van cm')
                        <span style="color:green">{{ $sku_ledger[$i]->quantity }}</span>
                    @elseif($sku_ledger[$i]->transaction_type == 'booking cm')
                        <span style="color:green">{{ $sku_ledger[$i]->quantity }}</span>
                    @elseif($sku_ledger[$i]->transaction_type == 'invoice cost adjustment')
                        <span style="color:orange">{{ $sku_ledger[$i]->quantity }}</span>
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
                <td>
                    <button style="text-align: right" type="button" class="btn btn-link" data-toggle="modal"
                        data-target="#exampleModal{{ $sku_ledger[$i]->id }}">
                        <span>{{ number_format($sku_ledger[$i]->running_balance) }}</span>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $sku_ledger[$i]->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg mw-100" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ $description[$i]->sku_code }}
                                        -
                                        {{ $description[$i]->description }} [{{ $description[$i]->sku_type }}]</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-sm table-striped" style="font-size:11;">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Transacted</th>
                                                <th>Transaction</th>
                                                <th>Quantity</th>
                                                <th>Adjustment</th>
                                                <th>Running Inventory</th>
                                                <th>Unit Cost</th>
                                                <th>Sub-Total</th>
                                                <th>Running Amount</th>
                                                <th>Average Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($description[$i]->sku_ledger as $details)
                                                <tr>
                                                    <td>{{ date('F j, Y', strtotime($details->created_at)) }}</td>
                                                    <td>{{ $details->user->name }}</td>
                                                    <td>{{ Str::ucfirst($details->transaction_type) }}</td>
                                                    <td style="text-align: right">
                                                        @if ($details->transaction_type == 'received')
                                                            <span style="color:green">{{ $details->quantity }}</span>
                                                            @php
                                                                $lower_quantity = $details->quantity;
                                                            @endphp
                                                        @elseif($details->transaction_type == 'returned')
                                                            (<span style="color:red">{{ $details->quantity }}</span>)
                                                            @php
                                                                $lower_quantity = $details->quantity * -1;
                                                            @endphp
                                                        @elseif($details->transaction_type == 'out from warehouse')
                                                            (<span style="color:red">{{ $details->quantity }}</span>)
                                                            @php
                                                                $lower_quantity = $details->quantity * -1;
                                                            @endphp
                                                        @elseif($details->transaction_type == 'bodega in')
                                                            <span style="color:green">{{ $details->quantity }}</span>
                                                            @php
                                                                $lower_quantity = $details->quantity;
                                                            @endphp
                                                        @elseif($details->transaction_type == 'bodega out')
                                                            (<span style="color:red">{{ $details->quantity }}</span>)
                                                            @php
                                                                $lower_quantity = $details->quantity * -1;
                                                            @endphp
                                                        @elseif($details->transaction_type == 'transfer to branch')
                                                            (<span style="color:red">{{ $details->quantity }}</span>)
                                                            @php
                                                                $lower_quantity = $details->quantity * -1;
                                                            @endphp
                                                        @elseif($details->transaction_type == 'releasing')
                                                            (<span style="color:red">{{ $details->quantity }}</span>)
                                                            @php
                                                                $lower_quantity = $details->quantity * -1;
                                                            @endphp
                                                        @elseif($details->transaction_type == 'van cm')
                                                            <span style="color:green">{{ $details->quantity }}</span>
                                                            @php
                                                                $lower_quantity = $details->quantity;
                                                            @endphp
                                                        @elseif($details->transaction_type == 'booking cm')
                                                            <span style="color:green">{{ $details->quantity }}</span>
                                                            @php
                                                                $lower_quantity = $details->quantity;
                                                            @endphp
                                                        @elseif($details->transaction_type == 'migration')
                                                            <span style="color:green">{{ $details->quantity }}</span>
                                                            @php
                                                                $lower_quantity = $details->quantity;
                                                            @endphp
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td style="text-align: right">
                                                        @if ($details->adjustments == null)
                                                            0
                                                        @else
                                                            @if ($details->adjustments < 0)
                                                                (<span style="color:red">
                                                                    {{ $details->adjustments }}
                                                                </span>)
                                                            @else
                                                                <span
                                                                    style="color:blue">{{ $details->adjustments }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td style="text-align: right">{{ $details->running_balance }}</td>
                                                    <td style="text-align: right">
                                                        {{ number_format($details->amount, 2, '.', ',') }}</td>
                                                    <td style="text-align: right">
                                                        @php
                                                            if ($details->adjustments == null) {
                                                                $details_total = $lower_quantity * $details->amount;
                                                            } else {
                                                                $details_total = $details->adjustments * $details->amount;
                                                            }
                                                            
                                                            echo number_format($details_total, 2, '.', ',');
                                                        @endphp
                                                    </td>
                                                    <td style="text-align: right">
                                                        {{ number_format($details->running_amount, 2, '.', ',') }}</td>
                                                    <td style="text-align: right">
                                                        @if ($details->running_balance == 0)
                                                            0
                                                        @else
                                                            {{ number_format($details->running_amount / $details->running_balance, 2, '.', ',') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td style="text-align:right">{{ number_format($sku_ledger[$i]->running_amount, 2, '.', ',') }}</td>
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
