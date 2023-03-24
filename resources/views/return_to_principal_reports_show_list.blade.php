<div style="width:100%;">
    <table class="table table-bordered table-hover table-sm table-striped" id="example1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Gross Purchase</th>
                <th>Less Discount</th>
                <th>BO Discount</th>
                <th>Vatable Purchase</th>
                <th>Vat</th>
                <th>Freight</th>
                <th>Final Cost Returned</th>
                <th>Other Discount</th>
                <th>Net Amount Returned</th>
                <th>#</th>
                <th>Principal</th>
                <th>Received #</th>
                <th>Driver</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($return_to_principal_data as $data)
                <tr>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                    <td style="text-align:right">
                        {{ number_format($data->gross_purchase, 2, '.', ',') }}
                        @php
                            $sum_gross_purchase[] = $data->gross_purchase;
                        @endphp
                    </td>
                    <td style="text-align:right">{{ number_format($data->total_less_discount, 2, '.', ',') }}
                        @php
                            $sum_total_less_discount[] = $data->total_less_discount;
                        @endphp
                    </td>
                    <td style="text-align:right">{{ number_format($data->bo_discount, 2, '.', ',') }}
                        @php
                            $sum_bo_discount[] = $data->bo_discount;
                        @endphp
                    </td>
                    <td style="text-align:right">{{ number_format($data->vatable_purchase, 2, '.', ',') }}
                        @php
                            $sum_vatable_purchase[] = $data->vatable_purchase;
                        @endphp
                    </td>
                    <td style="text-align:right">{{ number_format($data->vat, 2, '.', ',') }}
                        @php
                            $sum_vat[] = $data->vat;
                        @endphp
                    </td>
                    <td style="text-align:right">{{ number_format($data->freight, 2, '.', ',') }}
                        @php
                            $sum_freight[] = $data->freight;
                        @endphp
                    </td>
                    <td style="text-align:right">{{ number_format($data->total_final_cost, 2, '.', ',') }}
                        @php
                            $sum_total_final_cost[] = $data->total_final_cost;
                        @endphp
                    </td>
                    <td style="text-align:right">
                        {{ number_format($data->total_less_other_discount, 2, '.', ',') }}
                        @php
                            $sum_total_less_other_discount[] = $data->total_less_other_discount;
                        @endphp
                    </td>
                    <td style="text-align:right">{{ number_format($data->net_payable, 2, '.', ',') }}
                        @php
                            $sum_net_payable[] = $data->net_payable;
                        @endphp
                    </td>
                    <td><a target="_blank"
                            href="{{ route('return_to_principal_show_list_details', $data->id) }}">{{ $data->id }}</a>
                    </td>
                    <td text-transform: uppercase;">{{ $data->principal->principal }}</td>
                    <td><a href="{{ route('received_order_report_show_details', $data->received_id . '=' . $data->principal->principal) }}"
                            target="_blank">{{ $data->received_id }}</a></td>
                    <td text-transform: uppercase;">{{ $data->personnel }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Grand Total</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_gross_purchase), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total_less_discount), 2, '.', ',') }}
                </th>
                <th style="text-align: right">{{ number_format(array_sum($sum_bo_discount), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_vatable_purchase), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_vat), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_freight), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total_final_cost), 2, '.', ',') }}</th>
                <th style="text-align: right">
                    {{ number_format(array_sum($sum_total_less_other_discount), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_net_payable), 2, '.', ',') }}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
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
