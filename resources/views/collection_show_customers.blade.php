<div class="row">
    <div class="col-md-6">
        <label for="">Customer</label>
        <select name="customer_id" class="form-control select2bs4" style="width:100%;" required>
            <option value="" default>Select Agent Customer</option>
            @foreach ($customer as $data)
                <option value="{{ $data->customer_id }}">{{ $data->customer->store_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label for="">Transaction</label>
        <select name="transaction" class="form-control" style="width:100%;" required>
            <option value="" default>Select</option>
            <option value="collection">COLLECTION</option>
            <option value="post_rgs">POST RGS</option>
            <option value="post_bo">POST BO</option>
        </select>
    </div>
</div>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
