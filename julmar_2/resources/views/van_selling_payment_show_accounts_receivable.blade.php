<div class="table table-responsive">
    <form id="van_selling_payment_show_accounts_receivable_submit">
        @csrf
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Bank/Money Remitance Station</th>
                    <th>Cheque/Control #</th>
                    <th>Date</th>
                    <th>Outstanding Balance</th>
                    <th>Collection for <span style="color:blue;">{{ $date }}</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $van_selling_ledger->customer->store_name }}
                        <input type="hidden" name="store_name"
                            value="{{ $van_selling_ledger->customer->store_name }}">
                    </td>
                    <td>
                        <select name="bank" class="form-control select2" required style="width:100%;">
                            <option value="" default>Select</option>
                            <option value="1ST VALLEY BANK">1ST VALLEY BANK</option>
                            <option value="BDO">BDO</option>
                            <option value="PNB">PNB</option>
                            <option value="PALAWAN">PALAWAN</option>
                            <option value="METROBANK">METROBANK</option>
                            <option value="CHINA BANK">CHINA BANK</option>
                            <option value="EAST WEST">EAST WEST</option>
                            <option value="BPI">BPI</option>
                            <option value="CASH">CASH</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="cheque_control_number" required class="form-control">
                    </td>
                    <td>
                        <input type="date" name="date" required class="form-control">
                    </td>
                    <td style="text-align: right;">


                        @if ($van_selling_ledger->outstanding_balance == 0)
                            @php
                                $outstanding_balance = $van_selling_ledger->running_balance;
                            @endphp
                        @else
                            @php
                                $outstanding_balance = $van_selling_ledger->outstanding_balance;
                            @endphp
                        @endif

                        {{ number_format($outstanding_balance, 2, '.', ',') }}
                        <input type="hidden" name="outstanding_balance" value="{{ $outstanding_balance }}" required
                            class="form-control">






                    </td>
                    <td><input type="text" name="collection" class="currency-default" required style="display: block;
      width: 100%;
      height: calc(2.25rem + 2px);
      padding: .375rem .75rem;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #495057;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: .25rem;
      box-shadow: inset 0 0 0 transparent;
      transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;">
                    </td>
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

    $("#van_selling_payment_show_accounts_receivable_submit").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_payment_generate_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'collection_cannot_be_greater_than_outstanding_balance') {
                    Swal.fire(
                        'COLLECTION CANNOT BE GREATER THAN OUTSTANDING BALANCE',
                        'CANNOT PROCEED!',
                        'error'
                    )
                    $('.loading').hide();
                } else {
                    $('.loading').hide();
                    $('#van_selling_payment_generate_summary_page').html(data);
                }
            },
        });
    }));
</script>
