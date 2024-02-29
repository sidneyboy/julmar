@if ($search_per == 'driver')
    <label>Driver</label>
    <select name="logistics_id" class="form-control select2bs4" style="width:100%;" required>
        <option value="" default>SELECT</option>
        @foreach ($logistics_upload as $data)
            <option value="{{ $data->logistics_id }}">
                {{ $data->date . ' - ' . $data->logistics_driver->load_sheet_driver->full_name }}</option>
        @endforeach
    </select>
@else
    <label>Invoice</label>
    <input type="text" class="form-control" style="text-transform: uppercase" required name="delivery_receipt" placeholder="SEARCH DR/INVOICE">
    {{-- <select name="sales_invoice_id" class="form-control select2bs4" style="width:100%;" required>
        <option value="" default>SELECT</option>
        @foreach ($logistics_upload as $data)
            <option value="{{ $data->sales_invoice_id }}">
                {{ $data->sales_invoice->delivery_receipt }}</option>
        @endforeach
    </select> --}}
@endif
