<label>Sku:</label>
<select class="form-control select2bs4" name="sku[]" multiple="multiple" required style="width:100%;">
    @foreach ($sku as $data)
        <option value="{{ $data->id }}">{{ $data->sku_code . ' - ' . $data->description . ' - ' . $data->sku_type }}
        </option>
    @endforeach
</select>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
