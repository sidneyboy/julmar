<form id="booking_pcm_upload_final_process">
    @csrf
    <input type="text" name="delivery_receipt" placeholder="Input Delivery Receipt if none this textbox can be a remark"
        class="form-control" required>
    <br />
    <table class="table table-bordered table-hover table-striped table-sm" style="width:100%;font-size:13px;">
        @for ($i = 0; $i <= 2; $i++)
            <tr>
                <td>{{ $csv[$i][0] }}</td>
                <td>{{ $csv[$i][1] }}</td>
                <td>{{ $csv[$i][2] }}</td>
                <td>{{ $csv[$i][3] }}</td>
                <td>{{ $csv[$i][4] }}</td>
                @if (isset($csv[$i][5]))
                    <td>{{ $csv[$i][5] }}</td>
                @else
                    <td>Unit Price</td>
                @endif
            </tr>
        @endfor
        @for ($sku_details = 3; $sku_details < count($csv); $sku_details++)
            <tr>
                <td>{{ $id[$sku_details][0] }}</td>
                <td>{{ $code[$sku_details][1] }}</td>
                <td>{{ $description[$sku_details][2] }}</td>
                <td>{{ $sku_type[$sku_details][3] }}</td>
                <td>{{ $quantity[$sku_details][4] }}</td>
                <td>
                    <input type="text" name="unit_price[{{ $id[$sku_details][0] }}]" style="text-align: right"
                        onkeypress="return isNumberKey(event)" required class="form-control form-control-sm">
                </td>
            </tr>
        @endfor
    </table>

    <input type="text" name="principal_id" value="{{ $csv[1][2] }}">
    <input type="text" name="sku_type" value="{{ $csv[3][3] }}">
    <input type="text" name="pcm_number" value="{{ $csv[0][5] }}">
    <input type="text" name="customer_id" value="{{ $csv[0][1] }}">
    <input type="text" name="agent_id" value="{{ $csv[1][3] }}">
    <input type="text" name="transaction" value="{{ $transaction }}">

    <br />
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>


<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#booking_pcm_upload_final_process").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "booking_pcm_upload_final_process",
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
