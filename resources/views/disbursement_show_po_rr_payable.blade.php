<div class="form-group">
    <label for="">Payable Amount</label>
    <input type="text" class="form-control" style="text-align: right" value="{{ number_format($amount_payable,2,".",",")  }}" name="amount_payable" required onkeypress="return isNumberKey(event)">

    <input type="hidden" value="{{ $amount_payable }}" name="original_amount_payable">
</div>
