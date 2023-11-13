<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Payable Amount</label>
            <input type="text" class="form-control" style="text-align: right"
                value="{{ number_format($amount_payable, 2, '.', ',') }}" disabled>
            <input type="hidden" value="{{ $amount_payable }}" name="amount_payable">
            <input type="hidden" value="{{ $amount_payable }}" name="original_amount_payable">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">EWT Amount</label>
            <input type="text" class="form-control" style="text-align: right"
                value="{{ number_format($ewt_amount, 2, '.', ',') }}" disabled>

            <input type="hidden" value="{{ $ewt_amount }}" name="ewt_amount">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Net Payable Amount</label>
            <input type="text" class="form-control" style="text-align: right"
                value="{{ number_format($amount_payable - $ewt_amount, 2, '.', ',') }}" disabled>

            <input type="hidden" value="{{ $amount_payable - $ewt_amount }}" name="net_payable_amount">
        </div>
    </div>
    <div class="col-md-3">
        <label for="">Amount Paid</label>
        <input type="text" class="form-control" style="text-align: right" required name="amount_paid"
            onkeypress="return isNumberKey(event)">
    </div>
</div>
