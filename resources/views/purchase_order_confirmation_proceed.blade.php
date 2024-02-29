<form id="purchase_order_confirmation_final_summary">
    <div class="row">
        <div class="col-md-3">
            <label for="">Payment Term:</label>
            <select name="payment_term" class="form-control" required>
                <option value="" default>Select</option>
                <option value="cash with order">CASH W/ ORDER</option>
                <option value="15 days">15 DAYS</option>
                <option value="30 days">30 DAYS</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="">Delivery Term:</label>
            <input type="text" class="form-control" style="text-transform: uppercase" required name="delivery_term">
        </div>
        <div class="col-md-3">
            <label for="">Van #:</label>
            <input type="text" class="form-control" style="text-transform: uppercase" required name="van_number">
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
                            {{ $details->discount_name }} - {{ $details->discount_rate }}% |
                        @endforeach
                        {{-- BO - {{ $data->total_bo_allowance_discount }}% | CWO - {{ $data->cash_with_order_discount }}% --}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <label for="">Less Other Discounts:</label>
            <select class="form-control select2bs4" name="less_other_discount_selected[]" multiple="multiple"
                style="width:100%;">
                @foreach ($principal_discount as $data)
                    @foreach ($data->principal_discount_details as $details)
                        <option value="{{ $details->id }}">
                            {{ $details->discount_name . ' - ' . $details->discount_rate }}%</option>
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>
    <br />
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped" id="example1">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Quantity</th>
                    <th>Confirmed Quantity</th>
                    <th>U/C(VAT EX)</th>
                    <th>Freight</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase_order->purchase_order_details as $data)
                    <tr>
                        <td>{{ $data->sku->sku_code }} - {{ $data->sku->description }}</td>
                        <td>{{ $data->quantity }}</td>
                        <td><input style="text-align: right" type="number" min="0"
                                class="form-control form-control-sm" required
                                name="quantity_confirmed[{{ $data->sku_id }}]" value="0"></td>
                        <td>

                            @if ($data->sku->sku_price_details_one)
                                <input style="text-align: right" type="text" class="form-control form-control-sm"
                                    required value="{{ $data->sku->sku_price_details_one->unit_cost }}"
                                    name="unit_cost[{{ $data->sku_id }}]" onkeypress="return isNumberKey(event)">
                            @else
                                <input style="text-align: right" type="text" class="form-control form-control-sm"
                                    required value="0" name="unit_cost[{{ $data->sku_id }}]"
                                    onkeypress="return isNumberKey(event)">
                            @endif

                            <input type="hidden" name="sku_id[]" value="{{ $data->sku_id }}">
                            <input type="hidden" name="sku_code[{{ $data->sku_id }}]"
                                value="{{ $data->sku->sku_code }}">
                            <input type="hidden" name="description[{{ $data->sku_id }}]"
                                value="{{ $data->sku->description }}">
                        </td>
                        <td><input style="text-align: right" type="text" class="form-control form-control-sm"
                                required value="{{ $freight }}" name="freight[{{ $data->sku_id }}]"
                                onkeypress="return isNumberKey(event)"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br />
    <input type="hidden" name="purchase_order_id" value="{{ $purchase_order->id }}">
    <input type="hidden" name="principal_id" value="{{ $purchase_order->principal_id }}">
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


    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })


    $("#purchase_order_confirmation_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "purchase_order_confirmation_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#purchase_order_confirmation_final_summary_page').html(data);
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

    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: false,
            ordering: true,
            info: false,
            // dom: 'Bfrtip',
            // buttons: [
            //     'copyHtml5',
            //     'excelHtml5',
            //     'csvHtml5',
            //     'pdfHtml5'
            // ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
