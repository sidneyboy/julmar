<label for="">Sales Invoice</label>
<select name="sales_invoice_id" class="form-control select2bs4" style="width:100%;">
    <option value="" default>Select</option>
    @foreach ($sales_invoice as $sales_invoice_data)
        <option value="{{ $sales_invoice_data->id }}">{{ $sales_invoice_data->delivery_receipt }}</option>
    @endforeach
</select>


<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
</script>
