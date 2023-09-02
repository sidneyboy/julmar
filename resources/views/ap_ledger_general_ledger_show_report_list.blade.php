<div class="table table-responsive">
    <table class="table table-bordered table-striped table-sm" style="width:100%;font-size:15px;" id="example1">
        <thead>
            <tr>
                <th>Principal</th>
                <th>DR</th>
                <th>CR</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $principal }}</td>
                <td style="text-align: right">{{ number_format($ap_ledger_debit_credit->total_dr,2,".",",")  }}</td>
                <td style="text-align: right">
                    @php
                       $credit_record = $ap_ledger_debit_credit->total_cr + $ap_ledger_running_balance->running_balance;
                    @endphp
                    {{ number_format($credit_record,2,".",",") }}
                </td>
                <td style="text-align: right">
                    {{ number_format($credit_record - $ap_ledger_debit_credit->total_dr,2,".",",") }}
                </td>
            </tr>
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
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
