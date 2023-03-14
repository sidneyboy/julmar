<form id="disbursement_final_summary">
    @if ($disbursement == 'payment to principal')
        <div class="row">
            <div class="col-md-3">
                <label for="">Purchase Order</label>
                <select name="purchase_id" class="form-control select2bs4" required style="width:100%;">
                    <option value="" default>Select</option>
                    @foreach ($purchase_order as $data)
                        <option value="{{ $data->id }}">{{ $data->purchase_id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Bank</label>
                <select name="bank" class="form-control" required style="width:100%;">
                    <option value="" default>Select</option>
                    <option value="BDO">BDO</option>
                    <option value="BPI">BPI</option>
                    <option value="">UG UBAN PA</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Check/Deposit #</label>
                <input type="text" class="form-control" name="check_deposit_slip" required>
            </div>
            <div class="col-md-3">
                <label for="">Amount</label>
                <input type="text" class="form-control" required name="amount"
                    onkeypress="return isNumberKey(event)">
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
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "disbursement_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#disbursement_final_summary_page').html(data);
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
