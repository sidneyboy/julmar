@if ($disbursement == 'payment to principal')
    <div class="row">
        <div class="col-md-4">
            <label for="">Principal:</label>
            <select name="principal_id" class="form-control" required>
                <option value="" default>Select</option>
                @foreach ($principal as $data)
                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="">EWT Rate</label>
            <select name="ewt" class="form-control" required>
                <option value="" default>Select</option>
                @foreach ($ewt_rate as $data_ewt)
                    <option value="{{ $data_ewt->ewt_rate }}">{{ $data_ewt->ewt_rate / 100 }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label>Purchase Discount</label>
            <input type="text" class="form-control" required name="purchase_discount"  onkeypress="return isNumberKey(event)">
        </div>
    </div>
@elseif ($disbursement == 'collection')
    <label for="">Customer</label>
    <select name="customer_id" class="form-control select2bs4" style="width:100%;" required>
        @foreach ($customer as $data)
            <option value="{{ $data->id }}">{{ $data->store_name }}</option>
        @endforeach
    </select>
@elseif($disbursement == 'others')
    <div class="row">
        <div class="col-md-6">
            <label for="">Chart of Account</label>
            <select name="description" class="form-control select2bs4" style="width:100%;" required>
                <option value="" default>Select</option>
                <option value="PAYROLL">PAYROLL</option>
                <option value="WATER UTILITIES">WATER UTILITIES</option>
                <option value="ELECTRICITY">ELECTRICITY</option>
                <option value="COMMUNICATION ALLOWANCES">COMMUNICATION ALLOWANCES</option>
                {{-- @foreach ($transaction_entry as $data)
                    <option value="{{ $data->id . '|' . $data->account_name }}">{{ $data->account_name }}</option>
                @endforeach --}}
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Bank</label>
            <select name="cash_in_bank_id" class="form-control" required>
                <option value="" default>Select</option>
                @foreach ($transaction_cash_in_bank as $data)
                    <option value="{{ $data->id }}">{{ $data->account_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
@elseif($disbursement == 'unidentified_chart_of_account')
    <div class="row">
        <div class="col-md-12">
            <label for="">Bank</label>
            <select name="cash_in_bank_id" class="form-control" required>
                <option value="" default>Select</option>
                @foreach ($transaction_cash_in_bank as $data)
                    <option value="{{ $data->id }}">{{ $data->account_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endif

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
</script>
