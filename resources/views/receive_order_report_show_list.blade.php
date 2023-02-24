<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm" style="font-size:15px;" id="example1">
        <thead>
            <tr>
                <th>Received #</th>
                <th>Principal</th>
                <th>PO #</th>
                <th>Custodian</th>
                <th>Finalized</th>
                <th>Branch</th>
                <th>Date</th>
                <th>Gross Purchase</th>
                <th>Total Discount</th>
                <th>Total BO Discount</th>
                <th>Vatable Purchase</th>
                <th>Vat</th>
                <th>Freight</th>
                <th>Total Final Cost</th>
                <th>Total Other Discount</th>
                <th>Net Payable</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($received_purchase_order as $data)
                <tr>
                    <td><a target="_blank"
                            href="{{ url('received_order_report_show_details', ['id' => $data->id]) }}">{{ $data->id }}</a>
                    </td>
                    <td>{{ $data->principal->principal }}</td>
                    <td>{{ $data->purchase_order->purchase_id }}</td>
                    <td>{{ $data->scanned_by_data->name }}</td>
                    <td>{{ $data->finalized_data->name }}</td>
                    <td>{{ $data->branch }}</td>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                    <td style="text-align: right">{{ number_format($data->gross_purchase, 2, '.', ',') }}
                        @php
                            $sum_gross_purchase[] = $data->gross_purchase;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->total_less_discount, 2, '.', ',') }}
                        @php
                            $sum_total_less_discount[] = $data->total_less_discount;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->bo_discount, 2, '.', ',') }}
                        @php
                            $sum_bo_discount[] = $data->bo_discount;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->vatable_purchase, 2, '.', ',') }}
                        @php
                            $sum_vatable_purchase[] = $data->vatable_purchase;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->vat, 2, '.', ',') }}
                        @php
                            $sum_vat[] = $data->vat;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->freight, 2, '.', ',') }}
                        @php
                            $sum_freight[] = $data->freight;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->total_final_cost, 2, '.', ',') }}
                        @php
                            $sum_total_final_cost[] = $data->total_final_cost;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->total_less_other_discount, 2, '.', ',') }}
                        @php
                            $sum_total_less_other_discount[] = $data->total_less_other_discount;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->net_payable, 2, '.', ',') }}
                        @php
                            $sum_net_payable[] = $data->net_payable;
                        @endphp
                    </td>
                   
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Grand Total</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right">{{ number_format(array_sum($sum_gross_purchase), 2, '.', ',') }} </th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total_less_discount), 2, '.', ',') }} </th>
                <th style="text-align: right">{{ number_format(array_sum($sum_bo_discount), 2, '.', ',') }} </th>
                <th style="text-align: right">{{ number_format(array_sum($sum_vatable_purchase), 2, '.', ',') }} </th>
                <th style="text-align: right">{{ number_format(array_sum($sum_vat), 2, '.', ',') }} </th>
                <th style="text-align: right">{{ number_format(array_sum($sum_freight), 2, '.', ',') }} </th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total_final_cost), 2, '.', ',') }} </th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total_less_other_discount), 2, '.', ',') }} </th>
                <th style="text-align: right">{{ number_format(array_sum($sum_net_payable), 2, '.', ',') }} </th>
            </tr>
        </tfoot>
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
