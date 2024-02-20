<label for="">SELECT INVOICE</label>
<select name="sales_invoice_id[]" class="form-control select2bs4" style="width:100%;" multiple required>
    @foreach ($logistics_invoice as $data)
        <option value="{{ $data->sales_invoice_id }}">{{ $data->sales_invoice_transfer->delivery_receipt }}</option>
    @endforeach
</select>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
