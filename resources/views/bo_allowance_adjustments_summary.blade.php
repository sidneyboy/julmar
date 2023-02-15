<form id="myform" class="myform" method="post" name="myform">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th style="text-align: center;">Code</th>
                    <th style="text-align: center;">Description</th>
                    <th style="text-align: center;">UOM</th>
                    <th style="text-align: center;">Quantity Received</th>
                    <th style="text-align: center;">Unit Cost</th>
                    <th style="text-align: center;">BO Cost Adjustment</th>
                    <th style="text-align: center;">Adjusted Unit Cost</th>
                    <th style="text-align: center;">BO Allowance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sku as $data)
                    <tr>
                        <td style="text-transform: uppercase;text-align: center;">{{ $code[$data] }}</td>
                        <td style="text-transform: uppercase;text-align: center;">{{ $description[$data] }}</td>
                        <td style="text-transform: uppercase;text-align: center;">{{ $unit_of_measurement[$data] }}</td>
                        <td style="text-align: center;">{{ $quantity[$data] }}</td>
                        <td style="text-align: right;">
                            {{ number_format($unit_cost[$data], 2, '.', ',') }}
                            <input type="hidden" name="unit_cost[$data]" value="{{ $unit_cost[$data] }}">
                        </td>
                        <td style="text-align: right;">{{ number_format($unit_cost_adjustment[$data], 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $difference = $unit_cost[$data] - $unit_cost_adjustment[$data];
                            @endphp
                            {{ number_format($difference, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $total_amount = $unit_cost_adjustment[$data] * $quantity[$data];
                                $sum_total_amount[] = $total_amount;
                            @endphp
                            {{ number_format($total_amount, 2, '.', ',') }}
                            <input type="hidden" name="bo_allowance_per_sku[{{ $data }}]"
                                value="{{ $total_amount }}">
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7" style="text-align: center;font-weight: bold;color:green;">GRAND TOTAL</td>
                    <td style="font-weight: bold;text-align: right;color:green;">
                        {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" value="{{ $received_id }}" name="received_id">
    <input type="hidden" value="{{ $principal_name }}" name="principal_name">
    <h3>Particulars</h3>
    <p>{{ $particulars }}</p>


    <table class="table table-bordered table-hover table-sm">
        <tr>
            <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY OF DEDUCTION:</td>
            <td></td>
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
        {{-- <tr>
          <td>VAT DEDUCTION</td>
          <td style="text-align: right;font-size: 15px;">
          	
          </td>
        </tr> --}}
        <tr>
            <td style="font-weight: bold;">NET DEDUCTION</td>
            <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                {{--  @php
             	$net_deduction = $bo_allowance_deduction + $vat_deduction;
             @endphp --}}

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

    <label>JOURNAL ENTRY</label>


    <table class="table table-bordered table-hover table-sm">
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
                <td style="font-weight: bold;text-align: center;">{{ number_format($net_deduction, 2, '.', ',') }}</td>

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
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success btn-sm float-right" type="submit">Submit</button>
        </div>
    </div>
</form>

<script>
    function save() {

        var form = document.myform;
        var dataString = $(form).serialize();

        // /$('.loading').show();
        $.ajax({
            type: 'POST',
            url: '/bo_allowance_adjustments_save',
            data: dataString,
            success: function(data) {

                console.log(data);
                if (data == 'Saved') {

                    toastr.success('BO ALLOWANCE ADJUSTMENT SAVED! RELOADING PAGE PLEASE WAIT.')
                    $('.loading').show();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                } else {
                    toastr.error('Something went wrong, please redo process');
                }

            }
        });
        return false;
    }
</script>
