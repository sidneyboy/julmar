<form id="driver_collection_final_summary">
    <div class="table table-responsive">
        <table class="table table-bordered table-striped table-sm" id="search_table">
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
                </tr>
            </thead>
            <tbody>
                @foreach ($logistics_upload as $data)
             
                        <tr>
                            <td class="text-center">{{ $data->delivered_date }}</td>
                            <td class="text-center">{{ $data->sales_invoice->delivery_receipt }}</td>
                            <td class="text-center">{{ $data->sales_invoice->customer->store_name }}</td>
                            <td class="text-center">{{ $data->sales_invoice->principal->principal }}</td>
                            <td style="text-align: right">{{ number_format($data->sales_invoice->total, 2, '.', ',') }}
                            </td>
                            <td style="text-align: right">
                                @php
                                    $unconfirmed_cm_amount = $data->sales_invoice->cm_amount_deducted + $data->sales_invoice->cm_for_confirmation_amount;
                                    echo number_format($unconfirmed_cm_amount, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                {{ number_format($data->sales_invoice->total_payment, 2, '.', ',') }}</td>
                            <td>
                                @php
                                    $total = $data->sales_invoice->total - $data->sales_invoice->total_payment - $unconfirmed_cm_amount;
                                @endphp
                                <input type="hidden" name="logistics_upload_id[]"
                                    value="{{ $data->sales_invoice_id }}">
                                <input type="text" name="payment[{{ $data->sales_invoice_id }}]"
                                    class="form-control form-control-sm text-center"
                                    onkeypress="return isNumberKey(event)"
                                    value="{{ number_format($total, 2, '.', ',') }}">
                            </td>
                        </tr>
                @endforeach
            </tbody>
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

    $('#search_table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "autoWidth": false,
        "responsive": true,
        "info": false,
    });


    $("#driver_collection_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "driver_collection_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                $('#driver_collection_final_summary_page').html(data);
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
