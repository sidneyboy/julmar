<form id="disbursement_saved">
    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr>
                <th></th>
                <th colspan="3" style="text-align: center;text-transform:uppercase">{{ $title }}</th>
                <th>{{ date('F j, Y', strtotime($date)) }}</th>
            </tr>
            <tr>
                <th style="text-align: center">PAYEE</th>
                <th style="text-transform: uppercase;text-align:center;" colspan="3">{{ $payee }}</th>
                <th style="text-align: center">AMOUNT PAID</th>
            </tr>
            <tr>
                <th>AMOUNT IN WORDS</th>
                <th style="text-transform:uppercase;" colspan="3">{{ $amount_in_words }}</th>
                <th style="text-align: right">₱ {{ number_format($amount, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th>PARTICULARS</th>
                <th>DEBIT</th>
                <th>AMOUNT</th>
                <th>CREDIT</th>
                <th>AMOUNT</th>
            </tr>
            <tr>
                <th style="text-transform: uppercase">{{ $particulars }}</th>
                <th style="text-transform: uppercase">{{ $debit }}</th>
                <th style="text-align: right">₱ {{ number_format($amount, 2, '.', ',') }}</th>
                <th style="text-transform: uppercase">{{ $credit }}</th>
                <th style="text-align: right">₱ {{ number_format($amount, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th colspan="2"></th>
                <th style="text-align: center;" colspan="2">TOTAL PAYABLE</th>
                <th style="background-color:yellow;text-align:right">₱ {{ number_format($amount, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th colspan="5" style="text-transform: uppercase">REMARKS: {{ $remarks }}</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th>CHECK #</th>
                <th>{{ $check_deposit_slip }}</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th>CV #</th>
                <th>{{ $cv_number }}</th>
            </tr>
        </thead>
    </table>
    <input type="hidden" name="disbursement" value="{{ $disbursement }}">
    <input type="hidden" name="bank" value="{{ $bank }}">
    <input type="hidden" name="check_deposit_slip" value="{{ $check_deposit_slip }}">
    <input type="hidden" name="title" value="{{ $title }}">
    <input type="hidden" name="payee" value="{{ $payee }}">
    <input type="hidden" name="amount_in_words" value="{{ $amount_in_words }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="particulars" value="{{ $particulars }}">
    <input type="hidden" name="debit" value="{{ $debit }}">
    <input type="hidden" name="credit" value="{{ $credit }}">
    <input type="hidden" name="remarks" value="{{ $remarks }}">
    <input type="hidden" name="cv_number" value="{{ $cv_number }}">
    <input type="hidden" name="principal_id" value="{{ $principal_id }}">

    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#disbursement_saved").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "disbursement_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                location.reload();
            },
            error: function(error) {
                $('#loader').hide();
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
                
            }
        });
    }));
</script>
