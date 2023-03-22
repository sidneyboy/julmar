<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm" id="example1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction</th>
                <th>Principal</th>
                <th>Running</th>
                <th>Amount</th>
                <th>Short</th>
                <th>Outstanding</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ledger as $data)
                <tr>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                    <td>{{ Str::ucfirst($data->transaction) }}</td>
                    <td>{{ $data->principal->principal }}</td>
                    <td style="text-align: right">{{ number_format($data->running_balance,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->amount,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->short,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->outstanding_balance,2,".",",") }}</td>
                    <td>{{ $data->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <input type="hidden" id="customer" value="{{ $ledger[0]->customer->store_name }}">
</div>

<script>
    $("#example1").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "fixedHeader": true,
        "ordering": false,
        "buttons": [{
                extend: 'copyHtml5',
                footer: true
            },
            {
                extend: 'excelHtml5',
                title: 'Van Selling AR Ledger',
                messageTop: $('#customer').val(),
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
