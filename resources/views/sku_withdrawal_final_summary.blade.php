<form id="sku_withdrawal_very_final_summary">
    <label for="">Agent</label>
    <select name="agent_id" class="form-control select2bs4" required>
        <option value="" default>Select</option>
        @foreach ($agent as $data)
            <option value="{{ $data->id }}">{{ $data->full_name }}</option>
        @endforeach
    </select>
    <br />
    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Sku Type</th>
                <th>Quantity</th>
                <th>U/P</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $data)
                <tr>
                    <td>{{ $data->associatedModel->sku_code }}</td>
                    <td>{{ $data->associatedModel->description }}</td>
                    <td>{{ $data->associatedModel->sku_type }}</td>
                    <td style="text-align: right">{{ $data->quantity }}
                        @php
                            $sum_quantity[] = $data->quantity;
                        @endphp
                    </td>
                    <td style="text-align: right">
                        {{-- {{ number_format($data->price, 2, '.', ',') }} --}}
                        <input type="text" value="{{ $data->price }}" name="price[{{ $data->id }}]"
                            class="form-control form-control-sm" required>
                    </td>
                    <td style="text-align:right">
                        @php
                            $total = $data->quantity * $data->price;
                            $sum_total[] = $total;
                            echo number_format($total, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Grand Total</th>
                <th style="text-align: right">
                    {{ array_sum($sum_quantity) }}
                </th>
                <th></th>
                <th>{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
            </tr>
        </tfoot>
    </table>
    <br />
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <input type="hidden" value="{{ $sku_type }}" name="sku_type">
    <input type="hidden" value="{{ $price_level }}" name="price_level">
    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#sku_withdrawal_very_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "sku_withdrawal_very_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#sku_withdrawal_very_final_summary_page').html(data);
                $('#loader').hide();
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
