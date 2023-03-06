<form id="inventory_adjustments_saved">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Running Balance</th>
                    <th>Adjustment</th>
                    <th>New Running Balance</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $ledger->sku->sku_code }} - {{ $ledger->sku->description }}</td>
                    <td style="text-align: right">{{ $ledger->running_balance }}</td>
                    <td style="text-align: right">{{ $quantity }}</td>
                    <td style="text-align: right">
                        @php
                            $new_running_balance = $ledger->running_balance + $quantity;
                            echo $new_running_balance;
                        @endphp
                    </td>
                    <td><input type="text" class="form-control form-control-sm" name="remarks" required></td>
                </tr>
            </tbody>
        </table>
    </div>

    
    <input type="hidden" name="sku_id" value="{{ $ledger->sku_id }}">
    <input type="hidden" name="adjustments" value="{{ $quantity }}">
    <input type="hidden" name="principal_id" value="{{ $ledger->principal_id }}">
    <input type="hidden" name="sku_type" value="{{ $ledger->sku_type }}">
    <button class="btn btn-sm float-right btn-success">Submit</button>
</form>
<script>
    $("#inventory_adjustments_saved").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "inventory_adjustments_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
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
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
