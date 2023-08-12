<div class="table table-responsive">
    <table class="table table-bordered table-striped table-sm" style="width:100%;font-size:13px;" id="example1">
        <thead>
            <tr>
                <th>Description</th>
                <th>DR</th>
                <th>CR</th>
                <th>Running</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Beginning Balance</td>
                <td style="text-align: right">0</td>
                <td style="text-align: right">0</td>
                <td style="text-align: right">{{ number_format(array_sum($running_balance), 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td>NEED TO ASK MAAM VAN</td>
                <td style="text-align: right">{{ number_format($ap_ledger_debit_credit->total_dr, 2, '.', ',') }}</td>
                <td style="text-align: right">{{ number_format($ap_ledger_debit_credit->total_cr, 2, '.', ',') }}</td>
                <td style="text-align: right">{{ number_format(array_sum($running_balance) + $ap_ledger_debit_credit->total_cr - $ap_ledger_debit_credit->total_dr, 2, '.', ',') }}</td>
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
