<table class="table table-bordered table-sm table-striped">
    <tr>
        <th colspan="8" style="text-align: center;">RGS CREDIT MEMO</th>
    </tr>
    <tr>
        <td>CM #</td>
        <th style="text-align: center;">{{ $rgs->pcm_number }}</th>
        <td>SALES AGENT</td>
        <th style="text-align: center;">{{ $rgs->collection_agent->full_name }}</th>
        <td>DATE</td>
        <th style="text-align: center;">{{ $date }}</th>
        <td>CUSTOMER NAME</td>
        <th style="text-align: center;">{{ $rgs->collection_customer->store_name }}</th>
    </tr>
</table>
<form id="collection_post_bo_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th style="text-align: center;">CM AMOUNT:</th>
                    <th style="text-align: center;">{{ number_format($rgs->total_amount, 2, '.', ',')}}</th>
                    <th style="text-align: center;">CM COST OF GOODS SOLD:</th>
                    <th style="text-align: center;">{{ number_format($rgs->cost_of_goods_sold, 2, '.', ',')}}</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th style="text-align: center">INVOICE NO</th>
                    <th style="text-align: center">PRINCIPAL</th>
                    <th style="text-align: center">OUTSTANDING</th>
                    <th style="text-align: center">CM AMOUNT</th>
                    <th style="text-align: center">BALANCE</th>
                    <th style="text-align: center">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice as $data)
                    <tr>
                        <td style="text-align: center;">{{ $data->delivery_receipt }}</td>
                        <td style="text-align: center;">{{ $data->principal->principal }}</td>
                        <td style="text-align: right">
                            @php
                                $outstanding_balance = $data->total - $data->cm_amount_deducted - $data->total_payment;
                                echo number_format($outstanding_balance, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($rgs_amount[$data->id], 2, '.', ',') }}
                            <input type="hidden" name="rgs_amount[{{ $data->id }}]"
                                value="{{ $rgs_amount[$data->id] }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                $balance = $outstanding_balance - $rgs_amount[$data->id];
                            @endphp
                            {{ number_format($balance, 2, '.', ',') }}
                        </td>
                        <td>
                            {{ $remarks[$data->id] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                <th style="text-align: center;">DR</th>
                <th style="text-align: center;">CR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">{{ $get_sales_return_and_allowances->account_name }}</td>
                <td></td>
                <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($rgs_amount), 2, '.', ','); ?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center;">{{ $get_customer_ar->account_name }}</td>
                <td>
                </td>
                <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($rgs_amount), 2, '.', ','); ?>
                    <input type="hidden" name="spoiled_goods_amount" value="{{ array_sum($rgs_amount) }}">

                </td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ $get_general_merchandise->account_name }}</td>
                <td></td>
                <td style="font-weight: bold;text-align: center;">
                    <?php
                        $inventory = (array_sum($rgs_amount) / $rgs->total_amount) * $rgs->cost_of_goods_sold;
                        echo number_format($inventory, 2, '.', ',');
                    ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center;"> COST OF GOODS SOLD</td>
                <td>
                </td>
                <td style="font-weight: bold;text-align: center;">
                    <?php
                        $inventory = (array_sum($rgs_amount) / $rgs->total_amount) * $rgs->cost_of_goods_sold;
                        echo number_format($inventory, 2, '.', ',');
                    ?>
                    <input type="hidden" name="spoiled_goods_amount" value="{{ $rgs->inventory }}">
                </td>
            </tr>
           
        </tbody>
    </table>

    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <input type="hidden" name="principal_id" value="{{ $rgs->principal_id }}">
    <input type="hidden" name="cm_id" value="{{ $cm_id }}">

    <input type="hidden" value="{{ $get_sales_return_and_allowances->account_name }}"
        name="get_sales_return_and_allowances_account_name">
    <input type="hidden" value="{{ $get_sales_return_and_allowances->account_number }}"
        name="get_sales_return_and_allowances_account_number">
    <input type="hidden" value="{{ $get_sales_return_and_allowances->chart_of_accounts->account_number }}"
        name="get_sales_return_and_allowances_general_account_number">

    <input type="hidden" value="{{ $get_customer_ar->account_name }}" name="get_customer_ar_account_name">
    <input type="hidden" value="{{ $get_customer_ar->account_number }}" name="get_customer_ar_account_number">
    <input type="hidden" value="{{ $get_customer_ar->chart_of_accounts->account_number }}"
        name="get_customer_ar_general_account_number">



    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#collection_post_bo_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "collection_post_bo_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                //Swal.fire({
                // position: 'top-end',
                //icon: 'success',
                //title: 'Your work has been saved',
                //showConfirmButton: false,
                //timer: 1500
                //});

                //location.reload();
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
