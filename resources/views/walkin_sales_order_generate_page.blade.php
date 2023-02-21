<form id="walkin_sales_order_generate_final_summary">
    <div class="row">
        <div class="col-md-6">
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
        <div class="col-md-6">
            <div class="form-group">
                <label>Delivery Receipt:</label>
                <input type="text" class="form-control" name="delivery_receipt" placeholder="Delivery Receipt" required>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr>
                <th>CODE</th>
                <th>DESC</th>
                <th>SKU TYPE</th>
                <th>PRICE</th>
                <th>RB</th>
                <th>QTY</th>
                <th>LINE DISC 1</th>
                <th>LINE DISC 2</th>
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
                        @if ($customer_principal_price->price_level == 'price_1')
                            @php
                                $sku_price = $data->sku_price_details_one->price_1;
                            @endphp
                        @elseif($customer_principal_price->price_level == 'price_2')
                            @php
                                $sku_price = $data->sku_price_details_one->price_2;
                            @endphp
                        @elseif($customer_principal_price->price_level == 'price_3')
                            @php
                                $sku_price = $data->sku_price_details_one->price_3;
                            @endphp
                        @elseif($customer_principal_price->price_level == 'price_4')
                            @php
                                $sku_price = $data->sku_price_details_one->price_4;
                            @endphp
                        @else
                            @php
                                $sku_price = $data->sku_price_details_one->price_5;
                            @endphp
                        @endif
                        <input type="text" class="form-control form-control-sm"
                            onkeypress="return isNumberKey(event)" name="unit_price[{{ $data->id }}]"
                            value="{{ $sku_price }}">
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
                            name="line_discount_rate_1[{{ $data->id }}]" value="0" onkeypress="return isNumberKey(event)">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm"
                            name="line_discount_rate_2[{{ $data->id }}]" value="0" onkeypress="return isNumberKey(event)">
                    </td>
                </tr>
            @endforeach
            {{-- <tr>
                <td colspan="8">
                    <select class="form-control select2bs4" name="customer_discount[]" multiple="multiple"
                        data-placeholder="Select Customer Discounts" style="width: 100%;">
                        @foreach ($customer_discount as $discount_data)
                            <option selected value="{{ $discount_data->customer_discount }}">
                                {{ $discount_data->customer_discount }}</option>
                        @endforeach
                    </select>
                </td>
            </tr> --}}
        </tbody>
    </table>
    <input type="hidden" name="principal_id" value="{{ $principal_id }}">
    <input type="hidden" name="principal_name" value="{{ $principal_name }}">
    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <input type="hidden" name="store_name" value="{{ $store_name }}">
    <input type="hidden" name="type" value="{{ $type }}">
    <button type="submit" class="btn btn-info btn-sm float-right">Proceed Final Summary</button>
</form>

<script type="text/javascript">
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
        //$('.loading').show();

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
