<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm" id="example1">
        <thead>
            <tr>
                <th>#</th>
                <th>Received #</th>
                <th>Principal</th>
                <th>Particulars</th>
                <th>Transacted By</th>
                <th>Gross Purchase</th>
                <th>Less Discount</th>
                <th>BO Discount</th>
                <th>Vatable Purchase</th>
                <th>Vat</th>
                <th>Freight</th>
                <th>Total Cost Adj</th>
                <th>Other Discount</th>
                <th>Net Adjustment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice_cost_adjustment as $data)
                <tr>
                    <td style="text-align: center;"><a
                            href="{{ route('invoice_cost_adjustments_show_details', $data->id) }}"
                            target="_blank">{{ $data->id }}</a></td>
                    <td style="text-align: center;"><a
                            href="{{ route('received_order_report_show_details', $data->received_id . '=' . $data->principal->principal) }}"
                            target="_blank">{{ $data->received_id }}</a></td>
                    <td>{{ $data->principal->principal }}</td>
                    <td>{{ $data->particulars }}</td>
                    <td>{{ $data->user->name }}</td>
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
                <th style="text-align: right">{{ number_format(array_sum($sum_gross_purchase),2,".",",") }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total_less_discount),2,".",",") }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_bo_discount),2,".",",") }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_vatable_purchase),2,".",",") }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_vat),2,".",",") }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_freight),2,".",",") }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total_final_cost),2,".",",") }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total_less_other_discount),2,".",",") }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_net_payable),2,".",",") }}</th>
            </tr>
        </tfoot>
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
