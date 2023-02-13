<form id="van_selling_inventory_adjustments_save">
    <div class="row">
        <div class="col-md-6">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th colspan="10" style="text-align: center;">NEGATIVE QUANTITY <span style="color:red;">(FOR
                                    INVENTORY ADJUSTMENTS)</span>
                            </th>
                        </tr>
                        <tr>
                            <th>PRINCIPAL</th>
                            <th>CODE</th>
                            <th>DESCRIPTION</th>
                            <th>UOM</th>
                            <th>ENDING BALANCE</th>
                            <th>INVENTORY ADJUSTMENTS</th>
                            <th>FINAL QTY</th>
                            <th>U/P</th>
                            <th>SUB TOTAL</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sku as $data)
                            @php
                                $constant_negative_amount = 0;
                            @endphp
                            @if ($data->attributes->quantity_adjustments < 0)
                                <tr>
                                    <td>{{ $data->attributes->principal }}</td>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->attributes->unit_of_measurement }}</td>
                                    <td style="text-align: center;">{{ $data->attributes->ending_balance }}</td>
                                    <td style="text-align: center;">
                                        {{ $data->attributes->quantity_adjustments }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $data->attributes->final_quantity }}
                                    </td>
                                    <td style="text-align: right;">
                                        @php
                                            echo $price = $data->price;
                                        @endphp
                                    </td>
                                    <td style="text-align: right;">
                                        @php
                                            $amount_negative = $price * $data->attributes->quantity_adjustments;
                                            $total_amount_negative[] = $amount_negative;
                                            echo $amount_negative;
                                        @endphp
                                    </td>
                                    <td>{{ $data->attributes->remarks }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>
                                        @php
                                            $amount_negative = $constant_negative_amount;
                                            $total_amount_negative[] = $amount_negative;
                                        @endphp
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="9" style="text-align: center;">TOTAL NEGATIVE VALUE AMOUNT</th>
                            <th style="text-align: right;">
                                {{ number_format(array_sum($total_amount_negative), 2, '.', ',') }}
                                <input type="hidden" name="total_adjustment_amount_negative"
                                    value="{{ array_sum($total_amount_negative) }}">
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th colspan="10" style="text-align: center;">POSITIVE QUANTITY <span style="color:blue;">(FOR
                                    INVENTORY ADJUSTMENTS VAN LOAD)</span>
                            </th>
                        </tr>
                        <tr>
                            <th>PRINCIPAL</th>
                            <th>CODE</th>
                            <th>DESCRIPTION</th>
                            <th>UOM</th>
                            <th>ENDING BALANCE</th>
                            <th>INVENTORY ADJUSTMENTS</th>
                            <th>FINAL QTY</th>
                            <th>U/P</th>
                            <th>SUB TOTAL</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sku as $data)
                            @php
                                $constant_negative_amount = 0;
                            @endphp
                            @if ($data->attributes->quantity_adjustments > 0)
                                <tr>
                                    <td>{{ $data->attributes->principal }}</td>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->attributes->unit_of_measurement }}</td>
                                    <td style="text-align: center;">{{ $data->attributes->ending_balance }}</td>
                                    <td style="text-align: center;">
                                        {{ $data->attributes->quantity_adjustments }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $data->attributes->final_quantity }}

                                    </td>
                                    <td style="text-align: right;">
                                        @php
                                            echo $price = $data->price;
                                        @endphp
                                    </td>
                                    <td style="text-align: right;">
                                        @php
                                            $amount_positive = $price * $data->attributes->quantity_adjustments;
                                            $total_amount_positive[] = $amount_positive;
                                            echo $amount_positive;
                                        @endphp
                                    </td>
                                    <td>{{ $data->attributes->remarks }}</td>
                                </tr>
                            @else
                                @php
                                    $amount_positive = 0;
                                    $total_amount_positive[] = $amount_positive;
                                    $amount_positive;
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="9" style="text-align: center;">TOTAL POSITIVE VALUE AMOUNT</th>
                            <th style="text-align: right;">
                                {{ number_format(array_sum($total_amount_positive), 2, '.', ',') }}
                                <input type="hidden" name="total_adjustment_amount_positive"
                                    value="{{ array_sum($total_amount_positive) }}">
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <p style="padding:10px;background:grey;color:white">REMARKS: {{ $remarks }}</p>
        </div>
    </div>
    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <input type="hidden" name="remarks" value="{{ $remarks }}">
    <button type="submit" class="btn btn-success btn-block">SUBMIT ADJUSTMENTS</button>
</form>
<script type="text/javascript">
    $("#van_selling_inventory_adjustments_save").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_inventory_adjustments_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                // if (data == 'saved') {
                   
                // }

                 Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    location.reload();
            },
        });
    }));
</script>
