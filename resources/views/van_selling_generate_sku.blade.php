<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <label>Customer:</label>
            <select class="form-control select2bs4" name="customer" required style="width:100%;">
                <option value="" default>SELECT CUSTOMER</option>
                @foreach ($customer as $data)
                    <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label>Sku:</label>
            <select class="form-control select2bs4" name="sku" id="sku" required style="width:100%;">
                <option value="" default>Select</option>
                @foreach ($sku as $data)
                    <option value="{{ $data->id }}">{{ $data->sku_code . ' - ' . $data->description ." - ". $data->sku_type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label>Quantity:</label>
            <input type="number" min="1" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="col-md-12">
           <br />
            <button type="submit" class="btn btn-info btn-sm float-right">Proceed</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
