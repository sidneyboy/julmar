<div class="col-md-12">
    <form id="van_selling_ar_save">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                <tr>
                    <td colspan="5" style="text-align: center;">BEGINNING BALANCE OF <span
                            style="color:blue;font-weight: bold;">{{ $store_name }}</span></td>
                </tr>
                </tr>
                <tr>
                    <th>Running Balance</th>
                    <th>Actual Stocks  on Hand</th>
                    <th>Over/Short</th>
                    <th>Outstanding Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: right;">{{ number_format($running_balance, 2, '.', ',') }}</td>
                    <td style="text-align: right;">{{ number_format($actual_stocks_on_hand, 2, '.', ',') }}</td>
                    <td style="text-align: right;">

                        @php
                            $over_short = $running_balance - $actual_stocks_on_hand;
                        @endphp
                        @if ($over_short > 0)
                            @php
                                echo number_format($over_short, 2, '.', ',');
                            @endphp
                        @else
                            @php
                                echo '(' . number_format(str_replace('-', '', $over_short), 2, '.', ',') . ')';
                            @endphp
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @php
                            echo number_format($actual_stocks_on_hand + $over_short, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                        <input type="hidden" name="running_balance" value="{{ $running_balance }}">
                        <input type="hidden" name="actual_stocks_on_hand" value="{{ $actual_stocks_on_hand }}">
                        <input type="hidden" name="over_short" value="{{ $over_short }}">
                        <input type="hidden" name="outstanding_balance"
                            value="{{ $actual_stocks_on_hand + $over_short }}">
                        <button type="submit" class="btn btn-sm float-right btn-success">Submit</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $("#van_selling_ar_save").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_ar_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data == 'error') {
                    Swal.fire(
                        'OVER AND SHORT CANNOT HAVE A VALUE AT THE SAME TIME!!',
                        'CANNOT PROCEED!!',
                        'error'
                    )
                    $('.loading').hide();
                } else if (data == 'saved') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    location.reload();
                } else {
                    Swal.fire(
                        data,
                        'CANNOT PROCEED!!',
                        'error'
                    )
                    $('.loading').hide();
                }
            },
        });
    }));
</script>
