<form id="purchase_order_confirmation_final_summary">
    <div class="row">
        <div class="col-md-3">
            <label for="">Payment Term:</label>
            <select name="payment_term" class="form-control" required>
                <option value="" default>Select</option>
                <option value="cash with order">cash with order</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="">Delivery Term:</label>
            <input type="text" class="form-control" required name="delivery_term">
        </div>
        <div class="col-md-3">
            <label for="">Sales Order #:</label>
            <input type="text" class="form-control" required name="sales_order_number">
        </div>
        <div class="col-md-3">
            <label for="">Discount Type:</label>
            <select name="discount_type" class="form-control" required>
                <option value="" default>Select</option>
                <option value="type_a">Type A(Total & BO Discount)</option>
                <option value="type_b">Type B(Cascade Discount)</option>
            </select>
        </div>
        <div class="col-md-12">
            <label for="">Principal Discount:</label>
            <select name="discount_id" class="form-control" required>
                <option value="" default>Select</option>
                @foreach ($principal_discount as $data)
                    <option value="{{ $data->id }}">
                        @foreach ($data->principal_discount_details as $details)
                            {{ $details->discount_name }} - {{ $details->discount_rate }}% -
                        @endforeach
                        BO - {{ $data->total_bo_allowance_discount }}%
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <br />
    <div class="table table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Quantity</th>
                    <th>Confirmed Quantity</th>
                    <th>U/C(VAT EX)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase_order->purchase_order_details as $data)
                    <tr>
                        <td>{{ $data->sku->sku_code }} - {{ $data->sku->description }}</td>
                        <td>{{ $data->quantity }}</td>
                        <td><input style="text-align: right" type="number" min="0" value="0"
                                class="form-control form-control-sm" required name="quantity_confirmed[{{ $data->sku_id }}]"></td>
                        <td><input style="text-align: right" type="text" class="form-control form-control-sm"
                                required value="0" name="unit_cost[{{ $data->sku_id }}]"
                                onkeypress="return isNumberKey(event)">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />
    <input type="text" name="purchase_order_id" value="{{ $purchase_order->id }}">
    <button class="btn btn-sm float-right btn-info" type="submit">Generate Final Summary</button>
</form>


<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $("#purchase_order_confirmation_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "purchase_order_confirmation_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#purchase_order_confirmation_final_summary_page').html(data);
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
