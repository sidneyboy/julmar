<div class="table table-responsive">
    <form id="van_selling_payment_save">
        @csrf
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="7" style="text-align: center;">NEW AR LEDGER</th>
                </tr>
                <tr>
                    <th>Store Name</th>
                    <th>Bank/Money Remitance Station</th>
                    <th>Cheque/Control #</th>
                    <th>Date</th>
                    <th>Collection for <span style="color:blue;">{{ $date }}</span></th>
                    <th>Outstanding Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $store_name }}
                        <input type="hidden" name="store_name" value="{{ $store_name }}">
                    </td>
                    <td>
                        {{ $bank }}
                        <input type="hidden" name="bank" value="{{ $bank }}">
                    </td>
                    <td>
                        {{ $cheque_control_number }}
                        <input type="hidden" name="cheque_control_number" value="{{ $cheque_control_number }}">
                    </td>
                    <td>
                        {{ $date }}
                        <input type="hidden" name="date" value="{{ $date }}">
                    </td>
                    <td style="text-align: right;font-weight: bold;color:green">
                        {{ number_format($collection, 2, '.', ',') }}
                        <input type="hidden" name="collection" value="{{ $collection }}">
                    </td>
                    <td style="text-align: right;font-weight: bold;color:red">
                        @php
                            $new_balance = $outstanding_balance - $collection;
                        @endphp
                        {{ number_format($new_balance, 2, '.', ',') }}
                        <input type="hidden" name="outstanding_balance" value="{{ $new_balance }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="6"><input type="text" name="remarks" class="form-control" required placeholder="Collection Remarks"></td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
        <button type="submit" id="submit" class="btn btn-success btn-block">SUBMIT COLLECTION</button>
    </form>
</div>

<script>
    $("#van_selling_payment_save").on('submit', (function(e) {
        e.preventDefault();
        $('#submit').hide();
        $('.loading').show();
        $.ajax({
            url: "van_selling_payment_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                if (data == 'saved') {
                    Swal.fire(
                        'Good job!',
                        'Reloading Page',
                        'success'
                    )
                    location.reload();
                } else {
                    Swal.fire(
                        'ERROR, PLEASE CALL SYSTEM ADMIN',
                        data,
                        'success'
                    )
                }
            },
        });
    }));
</script>
