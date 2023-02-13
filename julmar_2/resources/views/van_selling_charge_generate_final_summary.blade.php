<div class="table table-responsive">
    <form id="van_selling_charge_save">
        @csrf
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="5" style="text-align: center;">NEW AR LEDGER BALANCE</th>
                </tr>
                <tr>
                    <th>STORE NAME</th>
                    <th>RUNNING BALANCE</th>
                    <th>CHARGE PAYMENT</th>
                    <th>OUSTANDING BALANCE</th>
                    <th>REMARKS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $store_name }}</td>
                    <td style="text-align: right;">
                        {{ number_format($running_balance - $charge, 2, '.', ',') }}
                        <input type="hidden" name="running_balance" value="{{ $running_balance - $charge }}">
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($charge, 2, '.', ',') }}
                        <input type="hidden" name="charge" value="{{ $charge }}">
                    </td>
                    <td style="text-align: right;">
                        @php
                            $outstanding_balance = $outstanding_balance - $charge;
                            echo number_format($outstanding_balance, 2, '.', ',');
                        @endphp
                        <input type="hidden" name="outstanding_balance" value="{{ $outstanding_balance }}">
                    </td>
                    <td>
                        {{ $remarks }}
                        <input type="hidden" name="remarks" value="{{ $remarks }}">
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
        <button type="submit" class="btn btn-success btn-block">SUBMIT</button>
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

    $("#van_selling_charge_save").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_charge_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data == 'saved') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    location.reload();
                }
            },
        });
    }));
</script>
