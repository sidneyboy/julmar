<div class="table table-responsive">
    @foreach ($truck_and_sales_invoice as $data)
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Ticket No</th>
                    <th>Plate No</th>
                    <th>Driver</th>
                    <th>Assistant</th>
                    <th>Date Assigned</th>
                    <th>Departed</th>
                    <th>Arrived</th>
                </tr>
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->truck->plate_no }}</td>
                    <td>{{ $data->driver }}</td>
                    <td>{{ $data->assistant }}</td>
                    <td>{{ date('Y-m-d', strtotime($data->created_at)) }}</td>
                    <td>{{ $data->departure_date }}</td>
                    <td>{{ $data->arrival_date }}</td>
                </tr>
                <tr>
                    <th>Delivery Receipt</th>
                    <th>Bound To</th>
                    <th>Store Name</th>
                    <th>Principal</th>
                    <th>Sku Type</th>
                    <th  colspan="2" style="text-align: center">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->truck_and_sales_invoice_details as $details)
                    <tr>
                        <td>{{ $details->sales_invoice->delivery_receipt }}</td>
                        <td>{{ $details->sales_invoice->customer->location->location }}</td>
                        <td>{{ $details->sales_invoice->customer->store_name }}</td>
                        <td>{{ $details->sales_invoice->principal->principal }}</td>
                        <td>{{ $details->sales_invoice->sku_type }}</td>
                        <th colspan="2" style="text-align: center">{{ number_format($details->sales_invoice->total,2,".",",") }}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</div>
