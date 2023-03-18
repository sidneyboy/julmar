<form id="van_selling_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="7" style="text-align: center">
                        {{ $sales_order_number }}

                        <input type="hidden" name="sales_order_number" value="{{ $sales_order_number }}">
                    </th>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: center">SN: {{ $customer->store_name }}</th>
                    <th colspan="2" style="text-align: center">SC: {{ $customer_principal_code->store_code }}
                        <input type="hidden" name="store_code" value="{{ $customer_principal_code->store_code }}">
                    </th>
                    <th style="text-align: center">
                        DR: {{ $delivery_receipt }}
                        <input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
                        <input type="hidden" name="principal_name" value="{{ $principal_name }}">
                    </th>
                    <th style="text-align: center">VAN LOAD WITHDRAWAL</th>
                    <th style="text-align: center">{{ $sku_type }}</th>
                </tr>
                <tr>
                    <th style="text-align: center;">Code</th>
                    <th style="text-align: center;">Description</th>
                    <th style="text-align: center;">Type</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: center;">X Butal</th>
                    <th style="text-align: center;">Butal Price</th>
                    <th style="text-align: center;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sku as $data)
                    {{-- @if ($quantity[$data->id] != 0) --}}
                    <tr>
                        <td>
                            {{ $data->sku_code }}
                            <input type="hidden" name="sku[]" value="{{ $data->id . ',' . $data->sku_code }}">
                            <input type="hidden" name="principal_id_per_sku[{{ $data->id }}]"
                                value="{{ $data->principal_id }}">
                            <input type="hidden" name="category_id[{{ $data->id }}]"
                                value="{{ $data->category_id }}">
                        </td>
                        <td>
                            {{ $data->description }}
                            <input type="hidden" name="description[{{ $data->id }}]"
                                value="{{ $data->description }}">
                        </td>
                        <td style="text-transform: uppercase;">
                            {{ $data->sku_type }}
                            <input type="hidden" name="sku_type[{{ $data->id }}]" value="{{ $data->sku_type }}">
                            <input type="hidden" name="unit_of_measurement[{{ $data->id }}]"
                                value="{{ $data->unit_of_measurement }}">
                        </td>
                        <td style="text-align: right;">
                            @php
                                $sum_quantity[] = $quantity[$data->id];
                            @endphp
                            {{ $quantity[$data->id] }}
                            <input type="hidden" name="quantity[{{ $data->id }}]"
                                value="{{ $quantity[$data->id] }}">
                        </td>
                        <td style="text-align: right">
                            {{ $equivalent_butal_pcs[$data->id] }}
                            <input type="hidden" name="equivalent_butal_pcs[{{ $data->id }}]"
                                value="{{ $equivalent_butal_pcs[$data->id] }}">
                        </td>
                        <td style="text-align: right;">
                            @php
                                $sku_price = $price_butal[$data->id];
                                echo number_format($sku_price, 4, '.', ',');
                            @endphp

                            {{-- <input type="hidden" name="sku_price[{{ $data->id }}]" value="{{ $sku_price }}"> --}}
                            <input type="hidden" name="sku_price[{{ $data->id }}]"
                                value="{{ $price_butal[$data->id] }}">
                        </td>
                        <td style="text-align: right;">
                            @if ($sku_type == 'Case' or $sku_type == 'CASE')
                                @php
                                    $amount_per_sku = $sku_price * $equivalent_butal_pcs[$data->id] * $quantity[$data->id];
                                    // $amount_per_sku = $price_case[$data->id] * $quantity[$data->id]
                                @endphp
                            @else
                                @php
                                    $amount_per_sku = $sku_price * $quantity[$data->id];
                                @endphp
                            @endif
                            @php
                                $sum_amount_per_sku[] = round($amount_per_sku, 2);
                                echo number_format($amount_per_sku, 2, '.', ',');
                            @endphp
                            <input type="hidden" name="final_amount_per_sku[{{ $data->id }}]"
                                value="{{ $amount_per_sku }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ array_sum($sum_quantity) }}</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">
                        {{ number_format(array_sum($sum_amount_per_sku), 2, '.', ',') }}
                        <input type="hidden" name="total_customer_payable_amount"
                            value="{{ array_sum($sum_amount_per_sku) }}">
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="form-group">
        <input type="hidden" name="price_level" value="{{ $price_level }}">
        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
        <input type="hidden" name="principal" value="{{ $principal }}">
        <input type="hidden" name="dr_sku_type" value="{{ $sku_type }}">
        <button type="submit" class="btn btn-success btn-block">SUBMIT VAN LOAD</button>
    </div>
</form>

<script type="text/javascript">
    $("#van_selling_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $.ajax({
            url: "van_selling_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(res) {

                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: 'Your work has been saved',
                //     showConfirmButton: false,
                //     timer: 1500
                // })

                // location.reload();

            },
            error: function(res) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));

    $(".example1").DataTable();
    $('.example2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });
</script>
