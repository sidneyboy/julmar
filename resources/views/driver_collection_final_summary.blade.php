<form id="driver_collection_final_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th class="text-center">Delivered Date</th>
                    <th class="text-center">Delivery Receipt</th>
                    <th class="text-center">Store</th>
                    <th class="text-center">Principal</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Unconfirmed CM</th>
                    <th class="text-center">Prev Payment</th>
                    <th class="text-center">Payment</th>
                    <th class="text-center">Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logistics_upload as $data)
                    <tr>
                        <td class="text-center">{{ $data->delivered_date }}</td>
                        <td class="text-center">{{ $data->sales_invoice->delivery_receipt }}</td>
                        <td class="text-center">{{ $data->sales_invoice->customer->store_name }}</td>
                        <td class="text-center">{{ $data->sales_invoice->principal->principal }}</td>
                        <td style="text-align: right">
                            {{ number_format($data->sales_invoice->total, 2, '.', ',') }}
                            @php
                                $sum_total_amount[] = $data->sales_invoice->total;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $unconfirmed_cm_amount = $data->sales_invoice->cm_amount_deducted + $data->sales_invoice->cm_for_confirmation_amount;
                                $sum_unconfirmed_cm_amount[] = $unconfirmed_cm_amount;
                                echo number_format($unconfirmed_cm_amount, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right;">
                            {{ number_format($data->sales_invoice->total_payment, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right">
                            {{ number_format(str_replace(',', '', $payment[$data->id]), 2, '.', ',') }}
                            @php
                                
                                $sum_total_payment[] = str_replace(',', '', $payment[$data->id]);
                            @endphp
                            <input type="hidden" name="logistics_id[]" value="{{ $data->id }}">
                            <input type="hidden" name="sales_invoice_id[{{ $data->id }}]"
                                value="{{ $data->sales_invoice_id }}">
                            <input type="hidden" name="customer_id[{{ $data->id }}]"
                                value="{{ $data->sales_invoice->customer_id }}">
                            <input type="hidden" name="agent_id[{{ $data->id }}]"
                                value="{{ $data->sales_invoice->agent_id }}">
                            <input type="hidden" name="payment[{{ $data->id }}]"
                                value="{{ str_replace(',', '', $payment[$data->id]) }}">
                        </td>

                        <td style="text-align: right">
                            {{ number_format(round($data->sales_invoice->total - $data->sales_invoice->total_payment, 2) - str_replace(',', '', $payment[$data->id]), 2, '.', ',') }}
                            @php
                                $outstanding_balance = round($data->sales_invoice->total - $data->sales_invoice->total_payment, 2) - str_replace(',', '', $payment[$data->id]);
                            @endphp
                            <input type="hidden" name="outstanding_balance[{{ $data->id }}]"
                                value="{{ $outstanding_balance }}">
                            <input type="hidden" name="total_amount[{{ $data->id }}]"
                                value="{{ $data->sales_invoice->total }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center" colspan="4">TOTAL</th>
                    <th style="text-align:right">{{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}</th>
                    <th style="text-align:right">
                        {{ number_format(array_sum($sum_unconfirmed_cm_amount), 2, '.', ',') }}</th>
                    <th></th>
                    <th style="text-align:right">{{ number_format(array_sum($sum_total_payment), 2, '.', ',') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <input type="hidden" name="search_per" value="{{ $search_per }}">
    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
</form>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $("#driver_collection_final_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "driver_collection_final_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: 'Your work has been saved',
                //     showConfirmButton: false,
                //     timer: 1500
                // });

                // location.reload();
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
