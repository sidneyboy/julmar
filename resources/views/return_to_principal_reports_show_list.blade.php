<div style="width:100%;">
    <table class="table table-bordered table-hover table-sm table-striped" id="example1">
        <thead>
            <tr>
                <th class="text-center align-middle" style="text-transform:uppercase">Date/Time</th>
                <th class="text-center align-middle" style="text-transform:uppercase">#</th>
                <th class="text-center align-middle" style="text-transform:uppercase">Received #</th>
                <th class="text-center align-middle" style="text-transform:uppercase">Amount</th>
                <th class="text-center align-middle" style="text-transform:uppercase">Discount</th>
                <th class="text-center align-middle" style="text-transform:uppercase">BO Allowance</th>
                <th class="text-center align-middle" style="text-transform:uppercase">CWO</th>
                <th class="text-center align-middle" style="text-transform:uppercase">T-Discount</th>
                <th class="text-center align-middle" style="text-transform:uppercase">Vat</th>
                <th class="text-center align-middle" style="text-transform:uppercase">Freight</th>
                <th class="text-center align-middle" style="text-transform:uppercase">Total Cost</th>
                {{-- <th class="text-center align-middle" style="text-trnsform:uppercase">Other Discount</th>
                <th class="text-center align-middle" style="text-transform:uppercase">Net Amount Returned</th> --}}
                <th class="text-center align-middle" style="text-transform:uppercase">Principal</th>
                <th class="text-center align-middle" style="text-transform:uppercase">Driver</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($return_to_principal_data as $data)
                <tr>
                    <td>{{ date('F j, Y H:i a', strtotime($data->date . ' ' . $data->time)) }}</td>
                    <td style="font-size:20px;" class="text-center"><a target="_blank"
                            href="{{ url('return_to_principal_report_generate',[
                                'id' => $data->id,
                                'report_type' => 'return_to_principal',
                                ]) }}">RET - {{ $data->id }}</a>
                    <td style="font-size:20px;" class="text-center"><a href="{{ route('received_order_report_show_details', $data->received_id . '=' . $data->principal->principal) }}"
                            target="_blank">RR - {{ $data->received_id }}</a></td>
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
                    <td style="text-align:right">{{ number_format($data->cwo_discount, 2, '.', ',') }}
                        @php
                            $sum_cwo_discount[] = $data->cwo_discount;
                        @endphp
                    </td>
                    <td style="text-align:right">
                        @php
                            $total_discount = $data->total_less_discount + $data->bo_discount + $data->cwo_discount;
                            $sum_vatable_purchase[] = $total_discount;
                        @endphp
                        {{ number_format($total_discount, 2, '.', ',') }}
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
                    <td style="text-align:right">
                        @php
                            $total_cost = $data->gross_purchase - $total_discount + $data->vat + $data->freight;
                            $sum_total_final_cost[] = $total_cost;
                        @endphp
                        {{ number_format($total_cost, 2, '.', ',') }}
                    </td>
                    {{-- <td style="text-align:right">
                        {{ number_format($data->total_less_other_discount, 2, '.', ',') }}
                        @php
                            $sum_total_less_other_discount[] = $data->total_less_other_discount;
                        @endphp
                    </td>
                    <td style="text-align:right">{{ number_format($data->net_payable, 2, '.', ',') }}
                        @php
                            $sum_net_payable[] = $data->net_payable;
                        @endphp
                    </td> --}}

                    </td>
                    <td style="text-transform: uppercase;">{{ $data->principal->principal }}</td>

                    <td style="text-transform: uppercase;">{{ $data->personnel }}</td>
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
                <th style="text-align: right">{{ number_format(array_sum($sum_cwo_discount), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_vatable_purchase), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_vat), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_freight), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total_final_cost), 2, '.', ',') }}</th>
                {{-- <th style="text-align: right">
                    {{ number_format(array_sum($sum_total_less_other_discount), 2, '.', ',') }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_net_payable), 2, '.', ',') }}</th> --}}
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
