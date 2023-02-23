<form id="walkin_sales_order_generate_final_summary">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Mode of Transaction:</label>
                <select class="form-control select2" name="mode_of_transaction" required style="width:100%;">
                    <option value="" default>Select Mode of Transaction</option>
                    <option value="COD">COD</option>
                    <option value="PDC">PDC</option>
                    <option value="VALE">VALE</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Delivery Receipt:</label>
                <input type="text" class="form-control" name="delivery_receipt" placeholder="Delivery Receipt"
                    required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Agent Name:</label>
                <input type="text" class="form-control" name="agent"  required>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr>
                <th>Code</th>
                <th>Desc</th>
                <th>Type</th>
                <th>U/C</th>
                <th>Inventory</th>
                <th>Quantity</th>
                <th>Line Discount Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sku_data as $data)
                <tr>
                    <td>
                        <input type="hidden" name="sku[]" value="{{ $data->id }}">
                        <input type="hidden" name="sku_code[{{ $data->id }}]" value="{{ $data->sku_code }}">
                    </td>
                    <td>
                        <input type="hidden" name="description[{{ $data->id }}]" value="{{ $data->description }}">
                        {{ $data->description }}
                    </td>
                    <td>
                        <input type="hidden" name="sku_type[{{ $data->id }}]" value="{{ $data->sku_type }}">
                        {{ $data->sku_type }}
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm"
                            onkeypress="return isNumberKey(event)" name="unit_price[{{ $data->id }}]"
                            value="0">
                    </td>
                    <td>
                        <input type="hidden" name="remaining_balance[{{ $data->id }}]"
                            value="{{ $data->sku_ledger_latest->running_balance }}">
                        {{ $data->sku_ledger_latest->running_balance }}
                    </td>
                    <td style="text-align: center;">
                        <input type="number" name="quantity[{{ $data->id }}]" class="form-control form-control-sm"
                            required min="0" value="0" style="text-align: center;">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm"
                            name="line_discount_rate_1[{{ $data->id }}]" value="0"
                            onkeypress="return isNumberKey(event)">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <label for="">Other Discount Amount:</label>
    <input type="text" name="total_other_discount" class="form-control form-control-sm" value="0"
        onkeypress="return isNumberKey(event)" required>
    <input type="hidden" name="principal_id" value="{{ $principal_id }}">
    <input type="hidden" name="principal_name" value="{{ $principal_name }}">
    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <input type="hidden" name="store_name" value="{{ $store_name }}">
    <input type="hidden" name="sku_type" value="{{ $type }}">
    <br />
    <button type="submit" class="btn btn-info btn-sm float-right">Proceed Final Summary</button>
</form>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $("#walkin_sales_order_generate_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "walkin_sales_order_generate_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#walkin_sales_order_generate_final_summary_page').html(data);
            },
        });
    }));
</script>
