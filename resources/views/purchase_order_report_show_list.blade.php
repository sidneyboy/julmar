<div class="table table-responsive">
    <table class="table table-bordered table-sm" id="example1">
        <thead>
            <tr>
                <th>Transacted By</th>
                <th>Transacted</th>
                <th>PO #</th>
                <th>Principal</th>
                <th>Status</th>
                <th>SI #</th>
                <th>Payment Term</th>
                <th>Delivery Term</th>
                <th>Discount Type</th>
                <th>Gross Purchase</th>
                <th>Total Discount Amount</th>
                <th>Bo Discount Amount</th>
                <th>Vatabable Purchase</th>
                <th>Vat</th>
                <th>Freight</th>
                <th>Total Final Cost</th>
                <th>Other Discount Amount</th>
                <th>Net Payable</th>
            </tr>
        </thead>
        <tbody>
            @if ($counter != 0)
                @foreach ($purchase_order_data as $data)
                    <tr>
                        <td>{{ $data->user->name }}</td>
                        <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                        <td><a target="_blank"
                                href="{{ route('purchase_order_report_show_details', $data->id . '=' . $data->skuPrincipal->principal . '=' . $data->skuPrincipal->contact_number . '=' . $data->payment_term . '=' . $data->delivery_term . '=' . $data->purchase_id . '=' . $data->user->name . '=' . $data->sales_order_number) }}"
                                target="_blank">{{ $data->purchase_id }}</a></td>
                        <td>{{ $data->skuPrincipal->principal }}</td>
                        <td>{{ Str::ucfirst($data->status) }}</td>
                        <td>{{ $data->sales_order_number }}</td>
                        <td>{{ $data->payment_term }}</td>
                        <td>{{ $data->delivery_term }}</td>
                        <td>{{ Str::ucfirst($data->discount_type) }}</td>
                        <td style="text-align:right">{{ number_format($data->gross_purchase, 2, '.', ',') }}
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
                        <td style="text-align:right">{{ number_format($data->total_less_other_discount, 2, '.', ',') }}
                            @php
                                $sum_total_less_other_discount[] = $data->total_less_other_discount;
                            @endphp
                        </td>
                        <td style="text-align:right">{{ number_format($data->net_payable, 2, '.', ',') }}
                            @php
                                $sum_net_payable[] = $data->net_payable;
                            @endphp
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" style="text-align: center;color:red;font-weight: bold;">NO DATA FOUND!</td>
                </tr>
            @endif
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
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

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
