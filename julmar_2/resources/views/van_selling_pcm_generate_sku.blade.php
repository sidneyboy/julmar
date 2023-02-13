<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Select Sku:</label>
            <select name="sku" style="width:100%;" id="" required class="form-control select2">
                <option value="" default>Select</option>
                @if ($pcm_type != 'customer')
                    @foreach ($van_selling_ledger as $data)
                        <option
                            value="{{ $data->sku_code . ',' . $data->description . ',' . $data->id . ',' . $data->principal . ',' . 1 }}">
                            {{ $data->sku_code . ' - ' . $data->description . ' - ' . $data->sku_type }}
                        </option>
                    @endforeach
                @else
                    @foreach ($van_selling_ledger as $data)
                        <option
                            value="{{ $data->sku_code . ',' . $data->description . ',' . $data->id . ',' . $data->skuPrincipal->principal . ',' . $data->principal_id }}">
                            {{ $data->sku_code . ' - ' . $data->description . ' - ' . $data->sku_type }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Quantity:</label>
            <input type="number" class="form-control" required name="quantity">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Select Remarks:</label>
            <select name="remarks" style="width:100%;" id="" required class="form-control select2">
                <option value="" default>Select</option>
                <option value="RGS">RGS</option>
                <option value="BO">BO</option>
            </select>
        </div>
    </div>
</div>

<script>
    $('.select2').select2();

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
