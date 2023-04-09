<form id="van_selling_inventory_adjustments_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Ending Inventory</th>
                    <th>Adjustment</th>
                    <th>New Inventory</th>
                    <th>U/P</th>
                    <th>Sub-Total</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vs_inventory_ledger as $data)
                    <tr>
                        <td><span style="color:green;font-weight:bold">{{ $data->sku->sku_code }}</span> -
                            {{ $data->sku->description }}</span></td>
                        <td style="text-align: right">{{ $data->ending_inventory }}</td>
                        <td style="text-align: right">{{ $confirmed_quantity[$data->id] }}</td>
                        <td style="text-align: right">
                            @php
                                $new_inventory = $data->ending_inventory + $confirmed_quantity[$data->id];
                                echo $new_inventory;
                            @endphp
                        </td>
                        <td style="text-align: right">{{ number_format($data->unit_price, 2, '.', ',') }}</td>
                        <td style="text-align: right">
                            @php
                                $total = $data->unit_price * $new_inventory;
                                $sum_total[] = $total;
                                echo number_format($total, 2, '.', ',');
                            @endphp
                        </td>
                        <td>{{ $remarks[$data->id] }}
                            <input type="hidden" name="sku_id[]" value="{{ $data->sku_id }}">
                            <input type="hidden" name="adjustments[{{ $data->sku_id }}]" value="{{ $confirmed_quantity[$data->id] }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th colspan="4"></th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <br />
    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <input type="hidden" name="total_amount" value="{{ array_sum($sum_total) }}">
    <button class="btn btn-sm btn-success float-right" type="submit">Submit</button>
</form>

<script>
    $("#van_selling_inventory_adjustments_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "van_selling_inventory_adjustments_save",
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
