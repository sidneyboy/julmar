<form id="bo_allowance_adjustments_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="10">Particulars: {{ $particulars }}</th>
                </tr>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>UOM</th>
                    <th>Quantity</th>
                    <th>FUC</th>
                    <th>Amount</th>
                    <th>Adjustment</th>
                    <th>BO Allowance</th>
                    <th>Adjusted Amount</th>
                    <th>Adjusted FUC</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sku as $data)
                    <tr>
                        <td style="text-transform: uppercase;text-align: center;">{{ $code[$data->sku_id] }}</td>
                        <td style="text-transform: uppercase;text-align: center;">{{ $description[$data->sku_id] }}</td>
                        <td style="text-transform: uppercase;text-align: center;">
                            {{ $unit_of_measurement[$data->sku_id] }}
                        </td>
                        <td style="text-align: center;">{{ $quantity[$data->sku_id] }}</td>
                        <td style="text-align: right;">
                            {{ number_format($unit_cost[$data->sku_id], 2, '.', ',') }}
                        </td>
                        <td style="text-align: right">
                            @php
                                $amount = $quantity[$data->sku_id] * $unit_cost[$data->sku_id];
                            @endphp
                            {{ number_format($amount, 2, '.', ',') }}</td>
                        <td style="text-align: right;">{{ number_format($unit_cost_adjustment, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                if ($unit_cost_adjustment > 0) {
                                    $total_amount = $unit_cost_adjustment * $quantity[$data->sku_id] * -1;
                                    $sum_total_amount[] = $total_amount;
                                } else {
                                    $total_amount = $unit_cost_adjustment * $quantity[$data->sku_id] * -1;
                                    $sum_total_amount[] = $total_amount;
                                }
                            @endphp
                            {{ number_format($total_amount, 2, '.', ',') }}
                            <input type="hidden" name="bo_allowance_per_sku[{{ $data->sku_id }}]"
                                value="{{ $total_amount }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                $adjusted_amount = $amount + $total_amount;
                            @endphp
                            {{ number_format($adjusted_amount, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $difference = $adjusted_amount / $quantity[$data->sku_id];
                            @endphp
                            {{ number_format($difference, 2, '.', ',') }}

                            <input type="hidden" name="sku_id[]" value="{{ $data->sku_id }}">
                            <input type="hidden" name="quantity[{{ $data->sku_id }}]"
                                value="{{ $quantity[$data->sku_id] }}">
                            <input type="hidden" name="unit_cost[{{ $data->sku_id }}]"
                                value="{{ $unit_cost[$data->sku_id] }}">
                            <input type="hidden" name="adjusted_amount[{{ $data->sku_id }}]"
                                value="{{ $unit_cost_adjustment }}">
                            <input type="hidden" name="adjusted_amount_data[{{ $data->sku_id }}]"
                                value="{{ $adjusted_amount }}">
                            <input type="hidden" name="adjusted_final_unit_cost[{{ $data->sku_id }}]"
                                value="{{ $difference }}">
                            <input type="hidden" name="original_final_unit_cost[{{ $data->sku_id }}]"
                                value="{{ $unit_cost[$data->sku_id] }}">
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7" style="text-align: center;font-weight: bold;color:green;">GRAND TOTAL</td>
                    <td style="font-weight: bold;text-align: right;color:green;">
                        {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" value="{{ $received_id }}" name="received_id">
    <input type="hidden" value="{{ $principal_name }}" name="principal_name">
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <input type="hidden" value="{{ $particulars }}" name="particulars">


    <table class="table table-bordered table-hover table-striped table-sm float-right" style="width:35%;">
        <tr>
            <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY OF DISCOUNTS:
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">BO ALLOWANCE</td>
            <td style="font-weight: bold; text-align: right;font-size: 15px;">
                @php
                    $bo_allowance_deduction = array_sum($sum_total_amount);
                @endphp
                {{ number_format($bo_allowance_deduction, 2, '.', ',') }}
                <input type="hidden" name="bo_allowance_deduction" value="{{ $bo_allowance_deduction }}">
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">NET DEDUCTION</td>
            <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                @php
                    $vat_deduction = array_sum($sum_total_amount) * 0.12;
                @endphp
                <input type="hidden" name="vat_deduction" value="{{ $vat_deduction }}">
                @php
                    $net_deduction = $bo_allowance_deduction;
                @endphp
                {{ number_format($net_deduction, 2, '.', ',') }}
                <input type="hidden" name="net_deduction" value="{{ $net_deduction }}">
            </td>
        </tr>
    </table>
    @if ($net_deduction > 0)
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                    <th style="text-align: center;">DR</th>
                    <th style="text-align: center;">CR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">ACCOUNTS PAYABLE - {{ $principal_name }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;">{{ number_format($net_deduction, 2, '.', ',') }}
                    </td>
                    <td></td>

                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">INVENTORY - {{ $principal_name }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;">
                        {{ number_format($net_deduction, 2, '.', ',') }}
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                    <th style="text-align: center;">DR</th>
                    <th style="text-align: center;">CR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">INVENTORY - {{ $principal_name }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;">
                        {{ number_format($net_deduction * -1, 2, '.', ',') }}
                    </td>
                    <td></td>

                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">ACCOUNTS PAYABLE - {{ $principal_name }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;">
                        {{ number_format($net_deduction * -1, 2, '.', ',') }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success btn-sm float-right" type="submit">Submit</button>
        </div>
    </div>

</form>

<script>
    $("#bo_allowance_adjustments_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "bo_allowance_adjustments_save",
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
