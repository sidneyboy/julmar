<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped" style="font-size:13px;width:100%:"
        id="example1">
        <thead>
            <tr>
                <th>Transaction</th>
                <th>Transaction Date</th>
                <th>Account Name</th>
                <th>Account Number</th>
                <th>DR</th>
                <th>CR</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($general_ledger as $data)
                <tr>
                    <td>{{ $data->transaction }}</td>
                    <td>{{ $data->transaction_date }}</td>
                    <td>{{ $data->account_name }}</td>
                    <td style="text-align: center;">{{ $data->account_number }}</td>
                    <td style="text-align: right;">{{ number_format($data->debit_record, 2, '.', ',') }}</td>
                    <td style="text-align: right;">{{ number_format($data->credit_record, 2, '.', ',') }}</td>
                    <td style="text-align: right;">
                        @if ($data->running_balance > 0)
                            {{ number_format($data->running_balance, 2, '.', ',') }}
                        @else
                            ({{ number_format($data->running_balance, 2, '.', ',') }})
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
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
                'excelHtml5',
                'csvHtml5',
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
