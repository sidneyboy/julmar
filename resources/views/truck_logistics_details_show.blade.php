<table class="table table-bordered table-sm table-striped table-hover" style="font-size:13px;">
    <thead>
        <tr>
            <th style="text-align: center;">Mode of Transaction</th>
            <th style="text-align: center;">Delivery Receipt</th>
            <th style="text-align: center;">Principal</th>
            <th style="text-align: center;">Sku Type</th>
            <th style="text-align: center;">Store Name</th>
            <th style="text-align: center;">Amount</th>
            <th style="text-align: center;">Delivery Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logistics_details as $details)
            <tr>
                <td>{{ $details->sales_invoice->mode_of_transaction }}</td>
                <td>{{ $details->sales_invoice->delivery_receipt }}</td>
                <td>{{ $details->sales_invoice->principal->principal }}</td>
                <td>{{ $details->sales_invoice->sku_type }}</td>
                <td>{{ $details->sales_invoice->customer->store_name }}</td>
                <td>{{ number_format($details->sales_invoice->total, 2, '.', ',') }}</td>
                <td>
                    <input type="date" name="delivery_date[{{ $details->id }}]" class="form-control form-control-sm">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
