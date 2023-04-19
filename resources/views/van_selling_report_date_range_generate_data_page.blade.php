<div style="width:100%;">
    <table class="table table-sm table-hover table-bordered table-striped" id="example1">
        <thead>
            <tr>
                <th>Principal</th>
                <th>Description</th>
                <th>Type</th>
                <th>Transaction</th>
                <th>Beginning</th>
                <th>Quantity</th>
                <th>Ending</th>
                <th>U/P</th>
                <th>Sub-Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($sku_ledger as $data) --}}
            @for ($i = 0; $i < count($sku_ledger); $i++)
                <tr>
                    <td>{{ $sku[$i]->skuPrincipal->principal }}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-link btn-sm" data-toggle="modal"
                            data-target="#exampleModal{{ $sku_ledger[$i]->id }}">
                            <span style="color:green;font-weight:bold">{{ $sku[$i]->sku_code }}</span> -
                            {{ $sku[$i]->description }}
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $sku_ledger[$i]->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg mw-100" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $sku[$i]->sku_code }} -
                                            {{ $sku[$i]->description }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped table-bordered table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>By</th>
                                                    <th>Principal</th>
                                                    <th>Transaction</th>
                                                    <th>Beg</th>
                                                    <th>Qty</th>
                                                    <th>Ending</th>
                                                    <th>U/P</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sku[$i]->vs_sku_ledger as $details)
                                                    <tr>
                                                        <td>{{ date('F j, Y', strtotime($details->created_at)) }}</td>
                                                        <td>
                                                            @if ($details->vs_reference)
                                                                {{ $details->vs_reference->customer_store_name }} - ({{ $details->vs_reference->reference }})
                                                            @else
                                                                {{ $details->user->name }}
                                                            @endif

                                                        </td>
                                                        <td>{{ $details->principal->principal }}</td>
                                                        <td>{{ $details->transaction }}</td>
                                                        <td style="text-align: right">
                                                            {{ $details->beginning_inventory }}</td>
                                                        <td style="text-align: right">{{ $details->quantity }}</td>
                                                        <td style="text-align: right">{{ $details->ending_inventory }}
                                                        </td>
                                                        <td style="text-align: right">
                                                            {{ number_format($details->unit_price, 2, '.', ',') }}</td>
                                                        <td style="text-align: right">
                                                            {{ number_format($details->unit_price * $details->ending_inventory, 2, '.', ',') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-dismiss="modal">Close</button>

                                    </div>
                                </div>
                            </div>
                        </div>



                    </td>
                    <td>{{ $sku[$i]->sku_type }}</td>
                    <td>{{ Str::ucfirst($sku_ledger[$i]->transaction) }}</td>
                    <td style="text-align: right">{{ $sku_ledger[$i]->beginning_inventory }}</td>
                    <td style="text-align: right">{{ $sku_ledger[$i]->quantity }}</td>
                    <td style="text-align: right">{{ $sku_ledger[$i]->ending_inventory }}</td>
                    <td style="text-align: right">
                        {{ number_format($sku_ledger[$i]->unit_price, 2, '.', ',') }}
                    </td>
                    <td style="text-align: right">
                        @php
                            $total = $sku_ledger[$i]->unit_price * $sku_ledger[$i]->ending_inventory;
                            $sum_total[] = $total;
                            echo number_format($total, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            @endfor
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right">
                    {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                </th>
            </tr>
        </tfoot>
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
