<form id="transfer_to_branch_saved">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>RECEIVED #: <span style="color:blue;">{{ $id }}</span></th>
                    <th>PO #: <span style="color:blue">{{ $purchase_id }}</span>
                    </th>
                    <th>SI: {{ $dr_si }}</th>
                    <th>Transfer From: {{ $received_purchase_order->branch }}</th>
                    <th>
                        Transfer To: {{ $transfer_to_branch }}
                    </th>
                </tr>
                <tr>
                    <th>Description</th>
                    <th>UOM</th>
                    <th>Received</th>
                    <th>Final Unit Cost</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sku_details as $data)
                    <tr>
                        <td>{{ $data->sku->sku_code }} - {{ $data->sku->description }}</td>
                        <td>{{ $data->sku->unit_of_measurement }}</td>
                        <td>
                            @php
                                $quantity = $data->quantity - $data->quantity_returned;
                                echo $quantity;
                            @endphp
                        </td>
                        <td style="text-align: right;">
                            {{ number_format($data->final_unit_cost, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $sum_total_amount[] = $quantity * $data->final_unit_cost;
                            @endphp
                            {{ number_format($quantity * $data->final_unit_cost, 2, '.', ',') }}
                            <input type="hidden" name="final_unit_cost[{{ $data->sku_id }}]"
                                value="{{ $data->final_unit_cost }}">
                            <input type="hidden" name="quantity[{{ $data->sku_id }}]" value="{{ $quantity }}">
                            <input type="hidden" name="sku_id[]" value="{{ $data->sku_id }}">
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="4">GRAND TOTAL</th>
                    <th style="text-align: right;">{{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}</th>

                </tr>
            </tbody>
        </table>
    </div>
    <table class="table-bordered table-hover table-sm" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th>DEBIT</th>
                <th>CREDIT</th>
            </tr>
            <tr>
                <th>{{ $get_merchandise_inventory->account_name }} - {{ $transfer_to_branch }}</th>
                <th></th>
                <th>{{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}</th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th>{{ $get_merchandise_inventory->account_name }} -
                    {{ $received_purchase_order->branch }}</th>
                <th></th>
                <th>{{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}</th>
            </tr>
        </thead>
    </table>

    <br />
    <input type="text" value="{{ $get_merchandise_inventory->account_name }}"
        name="merchandise_inventory_account_name">
    <input type="text" value="{{ $get_merchandise_inventory->account_number }}"
        name="merchandise_inventory_account_number">
    <input type="text" value="{{ $get_merchandise_inventory->chart_of_accounts->account_number }}"
        name="merchandise_inventory_general_account_number">
    <input type="text" name="transaction_date" value="{{ $transaction_date }}">
    <input type="hidden" name="received_id" value="{{ $id }}">
    <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
    <input type="hidden" name="principal_id" value="{{ $principal_id }}">
    <input type="hidden" name="dr_si" value="{{ $dr_si }}">
    <input type="hidden" name="id" value="{{ $id }}">
    <input type="hidden" name="total_amount" value="{{ array_sum($sum_total_amount) }}">
    <input type="hidden" name="transfer_to_branch" value="{{ $transfer_to_branch }}">
    <input type="hidden" name="transfer_from_branch" value="{{ $received_purchase_order->branch }}">
    <input type="hidden" name="principal_name" value="{{ $received_purchase_order->principal->principal }}
	">
    <input type="hidden" name="sku_type" value="{{ $sku_type }}">
    <button class="btn btn-success btn-sm float-right" type="submit">Submit</button>
</form>



<script>
    $("#transfer_to_branch_saved").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "transfer_to_branch_saved",
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
