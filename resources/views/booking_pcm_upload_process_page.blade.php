<form id="booking_pcm_upload_final_process">
    @csrf
    <input type="text" name="delivery_receipt" placeholder="Input Delivery Receipt if none this textbox can be a remark"
        class="form-control" required>
    <br />
    <table class="table table-responsive">
        <table class="table table-bordered table-hover table-striped table-sm" style="font-size:13px;">
            @for ($i = 0; $i <= 2; $i++)
                <tr>
                    <th style="text-align: center;">{{ $csv[$i][0] }}</th>
                    <th style="text-align: center;">{{ $csv[$i][1] }}</th>
                    <th style="text-align: center;">{{ $csv[$i][2] }}</th>
                    <th style="text-align: center;">{{ $csv[$i][3] }}</th>
                    <th style="text-align: center;">{{ $csv[$i][4] }}</th>
                    @if (isset($csv[$i][5]))
                        <th style="text-align: center;">{{ $csv[$i][5] }}</th>
                    @else
                        <th style="text-align: center;"></th>
                    @endif
                </tr>
            @endfor
            @for ($sku_details = 3; $sku_details < count($csv); $sku_details++)
                <tr>
                    <td style="text-align: center;">{{ $id[$sku_details][0] }}</td>
                    <td style="text-align: center;">{{ $code[$sku_details][1] }}</td>
                    <td style="text-align: center;">{{ $description[$sku_details][2] }}</td>
                    <td style="text-align: center;">{{ $sku_type[$sku_details][3] }}</td>
                    <td style="text-align: center;">{{ $quantity[$sku_details][4] }}
                        <input type="hidden" name="quantity[{{ $id[$sku_details][0] }}]"
                            value="{{ $quantity[$sku_details][4] }}">
                    </td>
                </tr>
            @endfor
        </table>
    </table>

    <input type="hidden" name="principal_id" value="{{ $csv[1][2] }}">
    <input type="hidden" name="sku_type" value="{{ $csv[3][3] }}">
    <input type="hidden" name="pcm_number" value="{{ $csv[0][5] }}">
    <input type="hidden" name="customer_id" value="{{ $csv[0][1] }}">
    <input type="hidden" name="agent_id" value="{{ $csv[1][3] }}">
    <input type="hidden" name="transaction" value="{{ $transaction }}">


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
        $.ajax({
            url: "booking_pcm_upload_final_process",
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
