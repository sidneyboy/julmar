<form id="van_selling_ar_ledger_adjustments_proceed_save">
    <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <th>Outstanding Balance</th>
                <th>Adjustment</th>
                <th>New Outstanding Balance</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format($ledger->outstanding_balance, 2, '.', ',') }}</td>
                <td>{{ number_format($adjustment, 2, '.', ',') }}</td>
                <td>
                    @php
                        $new_outstanding_balance = $ledger->outstanding_balance + $adjustment;
                        echo number_format($new_outstanding_balance, 2, '.', ',');
                    @endphp
                    <input type="hidden" name="new_outstanding_balance" value="{{ $new_outstanding_balance }}">
                    <input type="hidden" name="adjustment" value="{{ $adjustment }}">
                    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                    <input type="hidden" name="remarks" value="{{ $remarks }}">
                </td>
                <td>{{ $remarks }}</td>
            </tr>
        </tbody>
    </table>
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#van_selling_ar_ledger_adjustments_proceed_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "van_selling_ar_ledger_adjustments_proceed_save",
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

                window.location.replace('van_selling_ar_ledger');
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
