<div class="table table-responsive">
    <form id="sales_order_draft_proceed_to_final_summary">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Agent</th>
                    <th>Customer</th>
                    <th>Customer Code</th>
                    <th>Price Level</th>
                    <th>Principal</th>
                    <th>Sku Type</th>
                    <th>Mode of Transaction</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $sales_order_draft->agent->full_name }}</td>
                    <td>{{ $sales_order_draft->customer->store_name }}</td>
                    <td>{{ $customer_principal_code->store_code }}</td>
                    <td style="text-transform:uppercase">{{ $customer_principal_price->price_level }}</td>
                    <td>{{ $sales_order_draft->principal->principal }}</td>
                    <td>{{ $sales_order_draft->sku_type }}</td>
                    <td>
                        {{ $sales_order_draft->mode_of_transaction }}
                        <input type="hidden" name="sales_order_id" value="{{ $sales_order_draft->id }}">
                        <input type="hidden" name="customer_principal_code"
                            value="{{ $customer_principal_code->store_code }}">
                        <input type="hidden" name="customer_principal_price"
                            value="{{ $customer_principal_price->price_level }}">
                        <input type="hidden" name="principal" value="{{ $sales_order_draft->principal->principal }}">
                        <input type="hidden" name="sku_type" value="{{ $sales_order_draft->sku_type }}">
                        <input type="hidden" name="mode_of_transaction" value="{{ $sales_order_draft->mode_of_transaction }}">
                        <input type="hidden" name="customer_id" value="{{ $sales_order_draft->customer_id }}">
                        <input type="hidden" name="agent_id" value="{{ $sales_order_draft->agent_id }}">
                        <input type="hidden" name="principal_id" value="{{ $sales_order_draft->principal_id }}">
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Desc</th>
                    <th>UOM</th>
                    <th>Qty</th>
                    <th>U/P</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_order_draft->sales_order_draft_details as $details)
                    <tr>
                        <td>{{ $details->sku->sku_code }}</td>
                        <td>{{ $details->sku->description }}</td>
                        <td>{{ $details->sku->unit_of_measurement }}</td>
                        <td>
                            <input type="number" style="text-align:right" min="0" value="{{ $details->quantity }}" class="form-control" name="final_quantity[{{ $details->sku_id }}]">
                        </td>
                        <td style="text-align: right">
                            @if ($customer_principal_price->price_level == 'price_1')
                                @php
                                    echo $unit_price = $details->sku->sku_price_details_one->price_1;
                                @endphp
                            @elseif($customer_principal_price->price_level == 'price_2')
                                @php
                                    echo $unit_price = $details->sku->sku_price_details_one->price_2;
                                @endphp
                            @elseif($customer_principal_price->price_level == 'price_3')
                                @php
                                    echo $unit_price = $details->sku->sku_price_details_one->price_3;
                                @endphp
                            @elseif($customer_principal_price->price_level == 'price_4')
                                @php
                                    echo $unit_price = $details->sku->sku_price_details_one->price_4;
                                @endphp
                            @elseif($customer_principal_price->price_level == 'price_5')
                                @php
                                    echo $unit_price = $details->sku->sku_price_details_one->price_5;
                                @endphp
                            @endif

                            <input type="hidden" name="unit_price[{{ $details->sku_id }}]"
                                value="{{ $unit_price }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                echo $sub_total = $details->quantity * $unit_price;
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
            {{-- <tfoot>
                <tr>
                    <td colspan="5">TOTAL</td>
                    <td style="text-align: right">{{ array_sum($sum_total) }}</td>
                </tr>
            </tfoot> --}}
        </table>
        <div class="row">
            <div class="col-md-12">
                <label>Available Discount For This Customer</label>
                <select class="form-control select2" name="customer_discount[]" multiple="multiple"
                    data-placeholder="Customer Discounts" style="width: 100%;">
                    <option value="" default>Select</option>
                    @foreach ($customer_discount as $data)
                        <option value="{{ $data->customer_discount }}">Less - {{ $data->customer_discount }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <br />
                <button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
            </div>
        </div>
    </form>
</div>

<script>
    $('.select2').select2();

    $("#sales_order_draft_proceed_to_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        // $('#sales_order_migrate_summary_page').show();
        $.ajax({
            url: "sales_order_draft_proceed_to_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('.loading').hide();
                $('#sales_order_draft_proceed_to_final_summary_page').html(data);
            },
        });
    }));
</script>
