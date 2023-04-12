<label for="">SKU</label>
<select name="sku_barcode" id="sku_barcode" class="form-control select2bs4" style="width:100%;">
    <option value="" default>Select</option>
    @foreach ($purchase_order_details as $details)
        <option value="{{ $details->sku->barcode }}">[<span
                style="color:green;">{{ $details->sku->sku_code }}</span>] - {{ $details->sku->description }}</option>
    @endforeach
</select>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
