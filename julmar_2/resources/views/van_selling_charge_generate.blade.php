<div class="table table-responsive">
    <form id="van_selling_charge_generate_final_summary">
        @csrf
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>STORE NAME</th>
                    <th>RUNNING BALANCE</th>
                    <th>AMOUNT TO BE PAID</th>
                    <th>OUTSTANDING BALANCE</th>
                    <th>CHARGE</th>
                    <th>REMARKS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $van_selling_ledger->customer->store_name }}
                        <input type="hidden" name="store_name"
                            value="{{ $van_selling_ledger->customer->store_name }}">
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($van_selling_ledger->running_balance, 2, '.', ',') }}
                        <input type="hidden" name="running_balance" value="{{ $van_selling_ledger->running_balance }}"
                            required class="form-control">
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($van_selling_ledger->over_short, 2, '.', ',') }}
                        <input type="hidden" name="over_short" value="{{ $van_selling_ledger->over_short }}" required
                            class="form-control">
                    </td>
                    <td style="text-align: right;">
                        @if ($van_selling_ledger->outstanding_balance == 0)
                            <input type="hidden" name="outstanding_balance"
                                value="{{ $van_selling_ledger->running_balance }}" required class="form-control">
                            {{ number_format($van_selling_ledger->running_balance, 2, '.', ',') }}
                        @else
                            <input type="hidden" name="outstanding_balance"
                                value="{{ $van_selling_ledger->outstanding_balance }}" required class="form-control">
								{{ number_format($van_selling_ledger->outstanding_balance, 2, '.', ',') }}
                        @endif


                    </td>
                    <td><input type="text" name="charge" min="0" required style="display: block;" class="form-control">
                    </td>
                    <td><input type="text" name="remarks" class="form-control" required></td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
        <button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
    </form>
</div>

<script>
    $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({
        decimal: '_',
        thousands: '*'
    });
    $('[class=integer-default]').maskNumber({
        integer: true
    });
    $('[class=integer-data-attribute]').maskNumber({
        integer: true
    });
    $('[class=integer-configuration]').maskNumber({
        integer: true,
        thousands: '_'
    });
    $('.select2').select2()

    $("#van_selling_charge_generate_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_charge_generate_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
               if (data == 'walay_short_nga_bayaran') {
                    $('.loading').hide();
                    Swal.fire(
                      'Amount To Be Paid is 0.00',
                      'Cannot Proceed!!',
                      'error'
                    )
                   
               }else{
                    $('.loading').hide();
                    $('#van_selling_charge_generate_final_summary_page').html(data);
               }
            },
        });
    }));
</script>
