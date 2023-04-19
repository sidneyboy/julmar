<div style="width:100%;">
    <table class="table table-sm table-hover table-striped table-bordered table-striped" id="example1">
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
                    <td>
                        @if ($data->principal)
                            {{ $data->principal->principal }}
                        @else
                            n/a
                        @endif
                    </td>
                    <td style="text-align: right">{{ number_format($data->running_balance, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->amount, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->short, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->outstanding_balance, 2, '.', ',') }}</td>
                    <td style="width:100px;">{{ $data->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <input type="hidden" id="customer" value="{{ $ledger[0]->customer->store_name }}">
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
