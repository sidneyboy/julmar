<table class="table table-bordered table-sm table-striped">
    <tr>
        <th colspan="8" style="text-align: center;">BAD ORDER CREDIT MEMO</th>
    </tr>
    <tr>
        <td>CM #</td>
        <th style="text-align: center;">{{ $bad_order->pcm_number }}</th>
        <td>SALES AGENT</td>
        <th style="text-align: center;">{{ $bad_order->collection_agent->full_name }}</th>
        <td>DATE</td>
        <th style="text-align: center;">{{ $date }}</th>
        <td>CUSTOMER NAME</td>
        <th style="text-align: center;">{{ $bad_order->collection_customer->store_name }}</th>
    </tr>
</table>
<form id="collection_post_bo_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped">
            <thead>
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
                                $sum_outstanding_balance[] = $outstanding_balance;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($bo_amount[$data->id], 2, '.', ',') }}
                            @php
                                $sum_bo_amount[] = $bo_amount[$data->id];
                            @endphp
                            <input type="hidden" name="bo_amount[{{ $data->id }}]" value="{{ $bo_amount[$data->id] }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                $balance = $outstanding_balance - $bo_amount[$data->id];
                                $sum_balance[] = $balance;
                            @endphp
                            {{ number_format($balance, 2, '.', ',') }}
                        </td>
                        <td>
                            {{ $remarks[$data->id] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align: center;">GRAND TOTAL</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_outstanding_balance), 2, '.', ',') }}</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_bo_amount), 2, '.', ',') }}</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_balance), 2, '.', ',') }}</th>
                    <th></th>
                </tr>
            </tfoot>
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
                <td style="text-align: center;">{{ $get_spoiled_goods->account_name }}</td>
                <td></td>
                <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($bo_amount), 2, '.', ','); ?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center;">{{ $get_customer_ar->account_name }}</td>
                <td>
                </td>
                <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($bo_amount), 2, '.', ','); ?>
                    <input type="hidden" name="spoiled_goods_amount" value="{{ array_sum($bo_amount) }}">

                </td>
            </tr>
        </tbody>
    </table>

    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <input type="hidden" name="principal_id" value="{{ $bad_order->principal_id }}">
    <input type="hidden" name="cm_id" value="{{ $cm_id }}">

    <input type="hidden" value="{{ $get_spoiled_goods->account_name }}" name="get_spoiled_goods_account_name">
    <input type="hidden" value="{{ $get_spoiled_goods->account_number }}" name="get_spoiled_goods_account_number">
    <input type="hidden" value="{{ $get_spoiled_goods->chart_of_accounts->account_number }}"
        name="get_spoiled_goods_general_account_number">

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
