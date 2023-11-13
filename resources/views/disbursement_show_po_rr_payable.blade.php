<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Payable Amount</label>
            <input type="text" class="form-control" style="text-align: right"
                value="{{ number_format($amount_payable, 2, '.', ',') }}" name="amount_payable" required
                onkeypress="return isNumberKey(event)">

            <input type="hidden" value="{{ $amount_payable }}" name="original_amount_payable">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">EWT Amount</label>
            <input type="text" class="form-control" style="text-align: right"
                value="{{ number_format($ewt_amount, 2, '.', ',') }}" name="ewt_amount" required
                onkeypress="return isNumberKey(event)">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Net Payable Amount</label>
            <input type="text" class="form-control" style="text-align: right"
                value="{{ number_format($amount_payable - $ewt_amount, 2, '.', ',') }}" name="net_payable_amount"
                required onkeypress="return isNumberKey(event)">
        </div>
    </div>
    <div class="col-md-3">
        <label for="">Amount Paid</label>
        <input type="text" class="form-control" style="text-align: right" required name="amount"
            onkeypress="return isNumberKey(event)">
    </div>
</div>
