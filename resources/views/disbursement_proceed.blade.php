<form id="disbursement_final_summary">
    @if ($disbursement == 'payment to principal')
        <div class="row">
            <div class="col-md-3">
                <label for="">Title</label>
                <input type="text" class="form-control" required name="title">
            </div>
            <div class="col-md-3">
                <label for="">Purchase Order / RR</label>
                <select name="po_rr_id" class="form-control select2bs4" required style="width:100%;">
                    <option value="" default>Select</option>
                    @foreach ($purchase_order_unpaid as $purchase_order_unpaid_data)
                        <option value="PO - {{ $purchase_order_unpaid_data->id }} | {{ $purchase_order_unpaid_data->purchase_id }}">PO - {{ $purchase_order_unpaid_data->purchase_id }}</option>
                    @endforeach
                    @foreach ($receive_purchase_order_unpaid as $receive_purchase_order_unpaid_data)
                        <option value="RR - {{ $receive_purchase_order_unpaid_data->id }} | {{ $receive_purchase_order_unpaid_data->id }}">RR - {{ $receive_purchase_order_unpaid_data->id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Bank</label>
                <select name="bank" class="form-control" required style="width:100%;">
                    <option value="" default>Select</option>
                    <option value="BDO">BDO</option>
                    <option value="BPI">BPI</option>
                    <option value="METRO BANK">METRO BANK</option>
                    <option value="FIRST VALLEY BANK">FIRST VALLEY BANK</option>
                    <option value="OTHERS">OTHERS</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Check/Deposit #</label>
                <input type="text" class="form-control" name="check_deposit_slip" required>
            </div>
            <div class="col-md-3">
                <label for="">CV #</label>
                <input type="text" class="form-control" required name="cv_number" required>
            </div>
            <div class="col-md-3">
                <label for="">Amount</label>
                <input type="text" class="form-control" required name="amount"
                    onkeypress="return isNumberKey(event)">
            </div>
            <div class="col-md-3">
                <label for="">Amount in Words</label>
                <input type="text" class="form-control" required name="amount_in_words" required>
            </div>
            <div class="col-md-3">
                <label for="">Payee</label>
                <input type="text" class="form-control" required name="payee" required>
            </div>
            <div class="col-md-3">
                <label for="">Debit</label>
                <input type="text" class="form-control" required name="debit" required>
            </div>
            <div class="col-md-3">
                <label for="">Credit</label>
                <input type="text" class="form-control" required name="credit" required>
            </div>
            <div class="col-md-3">
                <label for="">Particulars</label>
                <input type="text" class="form-control" required name="particulars" required>
            </div>
            <div class="col-md-3">
                <label for="">Remarks</label>
                <input type="text" class="form-control" required name="remarks" required>
            </div>

        </div>

        <br />
        <input type="hidden" value="{{ $disbursement }}" name="disbursement">
        <input type="hidden" value="{{ $principal_id }}" name="principal_id">
        <button class="btn btn-sm btn-info float-right">Final Summary</button>
    @endif
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#disbursement_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "disbursement_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#disbursement_final_summary_page').html(data);
                $('#loader').hide();
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
