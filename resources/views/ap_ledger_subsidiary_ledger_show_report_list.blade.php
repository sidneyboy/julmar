<div class="table table-responsive">
    <table class="table table-bordered table-striped table-sm" style="width:100%;font-size:13px;" id="example1">
        <thead>
            <tr>
                <th>Principal</th>
                <th>Transaction Date</th>
                <th>Description</th>
                <th>DR</th>
                <th>CR</th>
                <th>Running</th>
                <th>Remarks</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ap_ledger as $data)
                <tr>
                    <td>{{ $data->principal->principal }}</td>
                    <td>{{ $data->transaction_date }}</td>
                    <td>{{ $data->description }}</td>
                    <td style="text-align: right">{{ number_format($data->debit_record, 2, '.', ',') }}
                        @php
                            $total_dr[] = $data->debit_record;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->credit_record, 2, '.', ',') }}
                        @php
                            $total_cr[] = $data->credit_record;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ number_format($data->running_balance, 2, '.', ',') }}</td>
                    <td>{{ $data->remarks }}</td>
                    <td>{{ $data->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right">{{ number_format(array_sum($total_dr), 2, '.', ',') }}</td>
                <td style="text-align: right">{{ number_format(array_sum($total_cr), 2, '.', ',') }}</td>
                <td></td>
                <td></td>
                <td></td>
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
