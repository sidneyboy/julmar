<form id="princpal_payment_save">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th colspan="8" style="text-align: center;font-weight: bold">PRINCIPAL PAYMENT FINAL SUMMARY</th>
            </tr>
            <tr>
                <th>Date</th>
                <th>Transacted By</th>
                <th>Principal</th>
                <th>Cheque #</th>
                <th>Disbursement #</th>
                <th>Current Accounts Payable</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $date }}</td>
                <td>{{ $employee_name->name }}</td>
                <td>{{ $principal->principal }}</td>
                <td>{{ $cheque_number }}</td>
                <td>{{ $disbursement_number }}</td>
                <td>{{ number_format($current_accounts_payable_final, 2, '.', ',') }}</td>
                <td>{{ number_format($amount, 2, '.', ',') }}</td>
                <td>{{ number_format($current_accounts_payable_final - $amount, 2, '.', ',') }}</td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="current_accounts_payable_final" value="{{ $current_accounts_payable_final }}">
    <input type="hidden" name="principal_id" value="{{ $principal_id }}">
    <input type="hidden" name="date" value="{{ $date }}">
    <input type="hidden" name="employee_id" value="{{ $employee_name->id }}">
    <input type="hidden" name="cheque_number" value="{{ $cheque_number }}">
    <input type="hidden" name="disbursement_number" value="{{ $disbursement_number }}">

    <div class="form-group">
        <button type="submit" class="btn btn-success btn-sm float-right">Submit Payment</button>
    </div>
</form>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#princpal_payment_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "princpal_payment_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved, Reloading Page!',
                    showConfirmButton: false,
                    timer: 1500
                })

                location.reload();
            },
            error: function(error) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
