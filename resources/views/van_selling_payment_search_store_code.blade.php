<form id="van_selling_payment_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th colspan="7">Final Summary</th>
                </tr>
                <tr>
                    <th>Agent</th>
                    <th>Bank</th>
                    <th>Reference</th>
                    <th>Remarks</th>
                    <th>Running Balance</th>
                    <th>Amount</th>
                    <th>New Outstanding Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $ledger->customer->store_name }}</td>
                    <td>{{ $bank }}</td>
                    <td>{{ $reference }}</td>
                    <td>{{ $remarks }}</td>
                    <td style="text-align: right">{{ number_format($ledger->outstanding_balance, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($amount, 2, '.', ',') }}</td>
                    <td style="text-align: right">
                        @php
                            $new_balance = $ledger->outstanding_balance - $amount;
                            echo number_format($new_balance, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br />
    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <input type="hidden" name="bank" value="{{ $bank }}">
    <input type="hidden" name="reference" value="{{ $reference }}">
    <input type="hidden" name="running_balance" value="{{ $ledger->outstanding_balance }}">
    <input type="hidden" name="remarks" value="{{ $remarks }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="new_balance" value="{{ $new_balance }}">
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#van_selling_payment_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "van_selling_payment_save",
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
