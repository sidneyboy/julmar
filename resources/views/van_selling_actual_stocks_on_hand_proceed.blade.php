<div class="table table-responsive">
    <form id="van_selling_actual_stocks_on_hand_save">
        @csrf
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead>
                <tr>
                    <th>Agent</th>
                    <th>Outstanding Balance</th>
                    <th>Actual Stocks on Hand</th>
                    <th>(Over)/Short</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $van_selling_ledger->customer->store_name }}</td>
                    <td style="text-align: right">
                        {{ number_format($van_selling_ledger->outstanding_balance, 2, '.', ',') }}
                    </td>
                    <td style="text-align: right">{{ number_format($actual_stocks_on_hand, 2, '.', ',') }}</td>
                    <td style="text-align: right">
                        {{ number_format($van_selling_ledger->outstanding_balance - $actual_stocks_on_hand, 2, '.', ',') }}
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- <label>AUDIT ACCESS KEY:</label>
		<input type="password" name="password" class="form-control" required> --}}
        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
		<input type="hidden" name="actual_stocks_on_hand" value="{{ $actual_stocks_on_hand }}">
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-success float-right btn-sm">Submit</button>
    </form>
</div>

<script>
    $("#van_selling_actual_stocks_on_hand_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "van_selling_actual_stocks_on_hand_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
				$('#loader').hide();
                // Swal.fire(
                //     'Good job!',
                //     'Reloading Page',
                //     'success'
                // )
                // location.reload();
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
