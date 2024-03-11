<label>Sales Order</label>
<select class="form-control select2bs4" name="customer_id" style="width:100%;" required>
    <option value="" default>SELECT CUSTOMER</option>
    @foreach ($sales_order as $data)
            <option value="{{ $data->customer_id }}">{{ $data->customer->store_name }}</option>
    @endforeach
</select>
