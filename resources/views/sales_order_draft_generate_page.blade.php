<form id="sales_order_draft_proceed_to_final_summary">
    @if ($sales_order_draft->principal->principal == 'GCI')
        <label for="">Delivery Receipt</label>
        <input type="text" name="delivery_receipt_for_gci" class="form-control" required>
    @endif
    <br />

    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped" style="width:100%;">
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
                        <input type="hidden" name="mode_of_transaction"
                            value="{{ $sales_order_draft->mode_of_transaction }}">
                        <input type="hidden" name="customer_id" value="{{ $sales_order_draft->customer_id }}">
                        <input type="hidden" name="agent_id" value="{{ $sales_order_draft->agent_id }}">
                        <input type="hidden" name="principal_id" value="{{ $sales_order_draft->principal_id }}">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped" style="width:100%;">
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
                            <input type="number" style="text-align:right" min="0"
                                value="{{ $details->quantity }}" class="form-control"
                                name="final_quantity[{{ $details->sku_id }}]">
                        </td>
                        <td style="text-align: right">
                            @if ($customer_principal_price->price_level == 'price_1')
                                @if ($details->sku->sku_price_details_one)
                                    @php
                                        $unit_price = $details->sku->sku_price_details_one->price_1;
                                        echo number_format($details->sku->sku_price_details_one->price_1, 2, '.', ',');
                                    @endphp
                                @else
                                    @php
                                        $unit_price = 0;
                                    @endphp
                                    {{ number_format(0, 2, '.', ',') }}
                                @endif
                            @elseif($customer_principal_price->price_level == 'price_2')
                                @if ($details->sku->sku_price_details_one)
                                    @php
                                        $unit_price = $details->sku->sku_price_details_one->price_2;
                                        echo number_format($details->sku->sku_price_details_one->price_2, 2, '.', ',');
                                    @endphp
                                @else
                                    @php
                                        $unit_price = 0;
                                    @endphp
                                    {{ number_format(0, 2, '.', ',') }}
                                @endif
                            @elseif($customer_principal_price->price_level == 'price_3')
                                @if ($details->sku->sku_price_details_one)
                                    @php
                                        $unit_price = $details->sku->sku_price_details_one->price_3;
                                        echo number_format($details->sku->sku_price_details_one->price_3, 2, '.', ',');
                                    @endphp
                                @else
                                    @php
                                        $unit_price = 0;
                                    @endphp
                                    {{ number_format(0, 2, '.', ',') }}
                                @endif
                            @elseif($customer_principal_price->price_level == 'price_4')
                                @if ($details->sku->sku_price_details_one)
                                    @php
                                        $unit_price = $details->sku->sku_price_details_one->price_4;
                                        echo number_format($details->sku->sku_price_details_one->price_4, 2, '.', ',');
                                    @endphp
                                @else
                                    @php
                                        $unit_price = 0;
                                    @endphp
                                    {{ number_format(0, 2, '.', ',') }}
                                @endif
                            @elseif($customer_principal_price->price_level == 'price_5')
                                @if ($details->sku->sku_price_details_one)
                                    @php
                                        $unit_price = $details->sku->sku_price_details_one->price_5;
                                        echo number_format($details->sku->sku_price_details_one->price_5, 2, '.', ',');
                                    @endphp
                                @else
                                    @php
                                        $unit_price = 0;
                                    @endphp
                                    {{ number_format(0, 2, '.', ',') }}
                                @endif
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
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>Available Discount For This Customer</label>
            <select class="form-control select2bs4" name="customer_discount[]" multiple="multiple"
                data-placeholder="Customer Discounts" style="width: 100%;">
                <option value="" default>Select</option>
                @foreach ($customer_discount as $data)
                    <option value="{{ $data->customer_discount }}" selected>Less - {{ $data->customer_discount }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <br />
            <button type="submit" class="btn btn-info btn-sm float-right">Proceed to final summary</button>
        </div>
    </div>
</form>


<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $("#sales_order_draft_proceed_to_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "sales_order_draft_proceed_to_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                $('#sales_order_draft_proceed_to_final_summary_page').html(data);
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
