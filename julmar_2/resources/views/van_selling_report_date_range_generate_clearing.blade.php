<style type="text/css" media="screen">
    #col {
        height: 700px;
        overflow-y: scroll;
        padding: 0px 0px;
        margin-bottom: 50px;
    }

    #dsTable {
        padding: 0px 0px;
    }

    .table_header {
        position: sticky;
        top: 0;
    }

</style>
<form id="van_selling_report_date_range_clearing_operation_save">
    <div class="row">
        <div class="col-md-12" id="col">
            <table class="table table-bordered table-hover ">
                <thead style="position: sticky;top: 0;" class="thead-light">
                    <tr>
                        <th class="table_header" style="text-align: center;" colspan="6">INVENTORY CLEARING TABLE</th>
                    </tr>
                    <tr>
                        <th class="table_header" colspan="6">NOTE: ALL SKU INVENTORY WILL BE
                            CLEARED</th>
                    </tr>
                    <tr>
                        <th class="table_header">DESCRIPTION</th>
                        <th class="table_header">END</th>
                        <th class="table_header">CLEARING</th>
                        <th class="table_header">NEW END</th>
                        <th class="table_header">U/P</th>
                        <th class="table_header">RUNNING BALANCE</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($van_selling_sku_ledger) != 0)
                        @foreach ($van_selling_sku_ledger as $data)
                            <tr>
                                <td>
                                    <span style="color:blue;font-weight: bold;">{{ $data->principal }}</span>
                                    - <span style="color:green;font-weight: bold;">{{ $data->sku_code }}</span>
                                    <br />
                                    {{ $data->description }}
                                    <input type="hidden" name="sku_code[]" value="{{ $data->sku_code }}">
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        echo $ending_balance = $data->end;
                                    @endphp
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        echo $clearing = $data->end*-1;
                                    @endphp
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        echo $new_inventory_beg = $ending_balance + $clearing;
                                    @endphp
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        echo number_format($data->unit_price, 2, '.', ',');
                                    @endphp
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        $running_balance_amount[] = $data->unit_price * $data->end;
                                        $final_inventory_running_balance[] = $data->unit_price * $new_inventory_beg;
                                    @endphp
                                    {{ number_format($data->unit_price * $new_inventory_beg, 2, '.', ',') }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @php
                            $final_inventory_running_balance = 0;
                        @endphp
                    @endif
                    <tr>
                        <th style="text-align: center;" colspan="5">TOTAL INVENTORY RUNNING BALANCE:</th>
                        <th style="text-align: right;">
                            {{ number_format(array_sum($final_inventory_running_balance), 2, '.', ',') }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">CLEARING OPERATION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="text-align: center;">VS AR ENDING BALANCE: <span style="color:blue;">(LAST ROW FROM
                                AR)</span></th>
                        <th style="text-align: right;font-weight: bold;color:blue">
                            {{ number_format($van_selling_ar_ledger->running_balance, 2, '.', ',') }}
                            <input type="hidden" name="vs_ar_ending_balance"
                                value="{{ $van_selling_ar_ledger->running_balance }}">
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">VS AR OVER/SHORT BALANCE:</th>
                        <th style="text-align: right;font-weight: bold;color:#ff9933">
                            {{ number_format($van_selling_ar_ledger->over_short, 2, '.', ',') }}
                            <input type="hidden" name="over_short" value="{{ $van_selling_ar_ledger->over_short }}">
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">OUTSTANDING BALANCE:</th>
                        <th style="text-align: right;font-weight: bold;color:#ff9933">
                            {{ number_format($van_selling_ar_ledger->running_balance + $van_selling_ar_ledger->over_short, 2, '.', ',') }}
                            <input type="hidden" name="outstanding_balance"
                                value="{{ $van_selling_ar_ledger->running_balance + $van_selling_ar_ledger->over_short }}">
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">VS INVENTORY RUNNING BALANCE:</th>
                        <th style="text-align: right;font-weight: bold;color:#ff9933">
                            {{ number_format(array_sum($running_balance_amount), 2, '.', ',') }}
                            <input type="hidden" name="vs_inventory_running_balance"
                                value="{{ array_sum($running_balance_amount) }}">
                        </th>
                    </tr>

                    <tr>
                        <th style="text-align: center;">ADJUSTMENT (DIFFERENCE):</th>
                        <th style="text-align: right;font-weight: bold;color:red">
                            @php
                                $add_adjustments = array_sum($running_balance_amount) - $van_selling_ar_ledger->running_balance;
                            @endphp
                            {{ number_format($add_adjustments, 2, '.', ',') }}
                            <input type="hidden" name="vs_add_adjustments" value="{{ $add_adjustments }}">
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">TOTAL AMOUNT TO BE ADJUSTED:</th>
                        <th style="text-align: right;font-weight: bold;color:green">
                            @php
                                $total_adjustments = array_sum($running_balance_amount) + round($add_adjustments,2);
                            @endphp
                            {{ number_format($total_adjustments, 2, '.', ',') }}
                            <input type="hidden" name="vs_total_adjustments" value="{{ $total_adjustments }}">
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
        @if (round($add_adjustments,2) != 0)
            <div class="continer" style="text-align: center;">
                <center>
                    <h5 style="color:red;">CANNOT PROCEED, DIFFERENCE MUST BE 0. MAKE SOME ADJUSTMENTS WITH ACCOUNTING!
                    </h5>
                </center>
            </div>
        @else
            <div class="col-md-12">
                <label>AUDIT/ADMIN ACCESS KEY:</label>
                <input type="password" name="secret_key" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label>&nbsp;</label>
                <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                <input type="hidden" name="date_from" value="{{ $date_from }}">
                <input type="hidden" name="date_to" value="{{ $date_to }}">
                <button type="submit" class="btn btn-block btn-success">SUBMIT CLEARING OPERATION</button>
            </div>
        @endif
    </div>
</form>

<script>
    $("#van_selling_report_date_range_clearing_operation_save").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_report_date_range_clearing_operation_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'access_denied') {
                    Swal.fire(
                        'Access Denied!',
                        'Cannot Proceed',
                        'error'
                    )
                } else if (data == 'saved') {
                    Swal.fire(
                        'Good job!',
                        'Generating Updated Van Load Report',
                        'success'
                    )
                    $('#generate').click();
                }
            },
        });
    }));
</script>
