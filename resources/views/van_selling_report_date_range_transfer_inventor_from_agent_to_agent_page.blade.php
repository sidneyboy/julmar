<style>
    #col {
        height: 400px;
        overflow-y: scroll;
        padding: 0px 0px;
    }

</style>
<br />
<div class="table table-responsive">
    <form id="van_selling_report_date_range_transfer_inventor_from_agent_to_agent_save">
        <table class="table table-bordered table-hover">
            <tr>
                <th>TRANSFER FROM</th>
                <th>TRANSFER OPTION</th>
                <th>TRANSFER TO</th>
            </tr>
            <tr>
                <th>{{ $van_selling_ar_ledger->customer->store_name }}</th>
                <th>
                    <select name="transfer_option" id="" class="form-control select2" style="width:100%;" required>
                        <option value="" default>SELECT</option>
                        <option value="swap_inventory">SWAP INVENTORY</option>
                        <option value="transfer">TRANSFER INVENTORY</option>
                    </select>
                </th>
                <th>
                    <select name="transfered_to" id="transfered_to" class="form-control select2" style="width:100%;" required>
                        <option value="" default>SELECT</option>
                        @foreach ($van_selling_agent as $data)
                            <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                        @endforeach
                    </select>
                </th>
            </tr>
        </table>

        <div class="row">
            <div class="col-md-6" id="col">
                <div class="container">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th colspan="6" style="text-align: center;">
                                    {{ $van_selling_ar_ledger->customer->store_name }} INVENTORY</th>
                            </tr>
                            <tr>
                                <th>CODE</th>
                                <th>DESC</th>
                                <th>PRINCIPAL</th>
                                <th>END</th>
                                <th>U/P</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transfered_from as $data)
                                <tr>
                                    <td>{{ $data->sku_code }}</td>
                                    <td>{{ $data->description }}</td>
                                    <td>{{ $data->principal }}</td>
                                    <td style="text-align: right">
                                        {{ $transfered_from_ending_balance[$data->sku_code] }}
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($transfered_from_unit_price[$data->sku_code], 2, '.', ',') }}
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($transfered_from_running_balance[$data->sku_code], 2, '.', ',') }}
                                        @php
                                            $transfered_to_total[] = $transfered_from_running_balance[$data->sku_code];
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5">TOTAL INVENTORY AMOUNT</th>
                                <th>{{ number_format(array_sum($transfered_to_total), 2, '.', ',') }}</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
            <div class="col-md-6">
                <div id="van_selling_report_date_range_transfered_to_show_inventory"></div>
            </div>
        </div>
        <br />
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>INVENTORY AMOUNT</th>
                    <th>AR OUTSTANDING BALANCE</th>
                    <th>DIFFERENCE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="text-align: right">{{ number_format($inventory_total_sum, 2, '.', ',') }}</th>
                    <th style="text-align: right">{{ number_format($ar_outstanding_balance, 2, '.', ',') }}</th>
                    <th style="text-align: right">
                        @php
                            $difference = round($ar_outstanding_balance - $inventory_total_sum, 2);
                            echo number_format($difference, 2, '.', ',');
                        @endphp
                    </th>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    @if ($difference != 0)
                        <th colspan="3">
                            <p style="color:red;text-align:center">CANNOT PROCEED DIFFERENCE MUST BE 0. MAKE SOME
                                ADJUSTMENTS</p>
                        </th>
                    @else
                        <th colspan="3">
                            <label>AUDIT/OM/SYSTEM ADMIN ACCESS KEY:</label>
                            <input type="password" name="access_key" required class="form-control"><br />
                            <button type="submit" class="btn btn-block btn-success">SUBMIT TRANSFER</button>
                        </th>
                    @endif
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<script>
    $('.select2').select2()

    $( "#transfered_to" ).click(function() {
        e.preventDefault();
        //$('.loading').show();
        alert('asdasd');
        // var transfered_to = $('#transfered_to').val();
        // $.ajax({
        //     url: "van_selling_report_date_range_transfered_to_show_inventory",
        //     type: "POST",
        //     data: 'transfered_to=' + transfered_to,
        //     success: function(data) {
        //         console.log(data);
        //         $('.loading').hide();
        //         $('#van_selling_report_date_range_transfered_to_page').html(data);
        //     },
        // });
    });
    
    $("#van_selling_report_date_range_transfer_inventor_from_agent_to_agent_save").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_report_date_range_transfer_inventor_from_agent_to_agent_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                // if (data == 'saved') {
                //     Swal.fire(
                //         'INVENTORY MOVEMENT SUCCESSFUL',
                //         '',
                //         'success'
                //     );
                //     $('.loading').hide();
                //     $('#click_if_trigger').click();
                // }
            },
        });
    }));


   
</script>
