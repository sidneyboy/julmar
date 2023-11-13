@if ($disbursement == 'payment to principal')
    <div class="row">
        <div class="col-md-6">
            <label for="">Principal:</label>
            <select name="principal_id" class="form-control" required>
                <option value="" default>Select</option>
                @foreach ($principal as $data)
                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="">EWT Rate</label>
            <select name="ewt" class="form-control" required>
                <option value="" default>Select</option>
                @foreach ($ewt_rate as $data_ewt)
                    <option value="{{ $data_ewt->ewt_rate }}">{{ $data_ewt->ewt_rate / 100 }}</option>
                @endforeach
            </select>
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
    <label for="">Description</label>
    <select name="description" class="form-control select2bs4" style="width:100%;" required>
        <option value="" default>Select</option>
        <option value="payroll">Payroll</option>
        <option value="water utilities">Water Utilities</option>
        <option value="electric utilities">Electricity</option>
        <option value="communication allowance">Communication Allowance</option>
        <option value="per diem">Per Diem</option>
        <option value="cash advance">Cash Advance</option>
    </select>
@endif

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
