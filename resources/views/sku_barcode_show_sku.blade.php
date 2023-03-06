<form action="sku_barcode_save" method="post">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <label for="">SKU</label>
            <select name="sku_code" style="width:100%;" class="form-control select2bs4" required>
                <option value="" default>Select</option>
                @foreach ($sku as $data)
                    <option value="{{ $data->sku_code }}">{{ $data->sku_code . '-' . $data->description }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="">SKU Type</label>
            <select name="sku_type" style="width:100%;" class="form-control" required>
                <option value="" default>Select</option>
                <option value="Case">Case</option>
                <option value="Butal">Butal</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="">Barcode</label>
            <input type="text" class="form-control" required name="barcode">
        </div>
        <div class="col-md-12">
            <br />
            <button class="btn btn-sm float-right btn-success">Submit SKU Barcode</button>
        </div>
    </div>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
