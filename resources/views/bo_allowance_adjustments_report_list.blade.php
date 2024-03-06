<div style="width:100%;">
    <table class="table table-bordered table-hover table-sm table-striped" id="example1">
        <thead>
            <tr>
                <th class="text-center align-middle" style="text-transform: uppercase">DATE</th>
                <th class="text-center align-middle" style="text-transform: uppercase">#</th>
                <th class="text-center align-middle" style="text-transform: uppercase">Received #</th>
                <th class="text-center align-middle" style="text-transform: uppercase">Principal</th>
                <th class="text-center align-middle" style="text-transform: uppercase">Particulars</th>
                <th class="text-center align-middle" style="text-transform: uppercase">Net BO Adjustment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bo_adjustments_data as $data)
                <tr>
                    <td class="text-center">{{ $data->date }}</td>
                    <td class="text-center"><a
                            href="{{ route('bo_allowance_adjustments_report_generate', [
                                'id' => $data->id,
                            ]) }}"
                            target="_blank">DM - BO
                            {{ $data->id }}</a></td>
                    <td class="text-center"><a
                            href="{{ route('received_order_report_show_details', $data->received_id . '=' . $data->principal->principal) }}"
                            target="_blank">RR - {{ $data->received_id }}</a></td>
                    <td class="text-center">{{ $data->principal->principal }}</td>
                    <td class="text-center">{{ strtoupper($data->particulars) }}</td>
                    <td style="text-align: right;">
                        {{ number_format($data->net_deduction, 2, '.', ',') }}
                        @php
                            $sum_net_deduction[] = $data->net_deduction;
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        {{-- <tfoot>
            <tr>
                <th>Grand Total</th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right">{{ number_format(array_sum($sum_net_deduction), 2, '.', ',') }}</th>
            </tr>
        </tfoot> --}}
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
