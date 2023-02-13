<form action="sku_barcode_save" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <label for="">Select SKU</label>
            <select name="sku_code" class="form-control select2bs4" required>
                <option value="" default>Select</option>
                @foreach ($sku as $data)
                    <option value="{{ $data->sku_code }}">{{ $data->sku_code . '-' . $data->description }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Barcode</label>
            <input type="text" class="form-control" required name="barcode">
        </div>
        {{-- <div class="col-md-12">
            <br />
            <button class="btn btn-sm float-right btn-success">Submit SKU Barcode</button>
        </div> --}}
    </div>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
