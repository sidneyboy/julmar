<form id="disbursement_saved" enctype="multipart/form-data">
    <div class="table table-responsive">
        <table class="table table-sm table-bordered table-hover">
            <thead>
                <tr>
                    <th>Disbursement</th>
                    <th>Bank</th>
                    <th>Check/Deposit #</th>
                    <th>PO #</th>
                    <th>Principal</th>
                    <th>Total Final Cost</th>
                    <th>Total Other Discounts</th>
                    <th>Net Payable</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $disbursement }}</td>
                    <td>{{ $bank }}</td>
                    <td>{{ $check_deposit_slip }}</td>
                    <td>{{ $purchase_order->purchase_id }}</td>
                    <td>{{ $purchase_order->skuPrincipal->principal }}</td>
                    <td style="text-align: right">{{ number_format($purchase_order->total_final_cost, 2, '.', ',') }}
                    </td>
                    <td style="text-align: right">
                        {{ number_format($purchase_order->total_less_other_discount, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($purchase_order->net_payable, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($amount, 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <label for="">Attachment</label>
    <input type="file" class="form-control" name="file" required id="imgInp" accept="image/*">
    <img id="blah" src="#" alt="your image" class="img img-thumbnail"/>
    <br /><br />
    <input type="hidden" name="disbursement" value="{{ $disbursement }}">
    <input type="hidden" name="bank" value="{{ $bank }}">
    <input type="hidden" name="check_deposit_slip" value="{{ $check_deposit_slip }}">
    <input type="hidden" name="purchase_order_id" value="{{ $purchase_order->id }}">
    <input type="hidden" name="principal_id" value="{{ $purchase_order->principal_id }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>


<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }

    $("#disbursement_saved").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "disbursement_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
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
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
