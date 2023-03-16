<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm" id="example1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Transacted</th>
                <th>Title</th>
                <th>Type</th>
                <th>Bank</th>
                <th>Check #</th>
                <th>CV #</th>
                <th>Particulars</th>
                <th>Payee</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Amount</th>
                <th>Amount in Words</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($disbursement as $data)
                <tr>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                    <td>{{ $data->user_id }}</td>
                    <td>{{ $data->title }}</td>
                    <td>{{ $data->disbursement }}</td>
                    <td>{{ $data->bank }}</td>
                    <td>{{ $data->check_deposit_slip }}</td>
                    <td>{{ $data->cv_number }}</td>
                    <td>{{ $data->particulars }}</td>
                    <td>{{ $data->payee }}</td>
                    <td>{{ $data->debit }}</td>
                    <td>{{ $data->credit }}</td>
                    <td style="text-align: right">{{ number_format($data->amount,2,".",",") }}</td>
                    <td>{{ $data->amount_in_words }}</td>
                    <td>{{ $data->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
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
