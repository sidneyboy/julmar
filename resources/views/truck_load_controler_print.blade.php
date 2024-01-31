<link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">
<div class="container-fluid">
    <table class="table table-bordered table-striped table-sm table-hover" style="width:100%;margin-top:20px;" id="example1">
        <thead>
            <tr>
                <th colspan="2">Prepared By: </th>
                <th colspan="10">{{ strtoupper($logistics_invoices[0]->logistics->user->name) }}</th>
            </tr>
            <tr>
                <th colspan="2">Driver & Helper: </th>
                <th colspan="10">{{ strtoupper($logistics_invoices[0]->logistics->load_sheet_driver->full_name) }},
                    {{ strtoupper($logistics_invoices[0]->logistics->helper_1) }},
                    {{ strtoupper($logistics_invoices[0]->logistics->helper_2) }}</th>
            </tr>
            <tr>
                <th>DATE</th>
                <th>SALES AREA</th>
                <th>SALESMAN</th>
                <th>INVOICE</th>
                <th>NAME OF OUTLET</th>
                <th>ADDRESS</th>
                <th>CASE</th>
                <th>BUTAL</th>
                <th>CONVERSION</th>
                <th>AMOUNT</th>
                <th>TRANSACTION</th>
                <th>TOTAL WEIGHT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logistics_invoices as $details)
                <tr>
                    <td>{{ date('F j, Y', strtotime($details->created_at)) }}</td>
                    <td>{{ $details->sales_invoice->customer->location_details->barangay }}</td>
                    <td>{{ $details->sales_invoice->agent->full_name }}</td>
                    <td>{{ $details->sales_invoice->delivery_receipt }}</td>
                    <td>{{ $details->sales_invoice->customer->store_name }}</td>
                    <td>{{ $details->sales_invoice->customer->detailed_location }}</td>
                    <td style="text-align: right">{{ $details->case }}</td>
                    <td style="text-align: right">{{ $details->butal }}</td>
                    <td style="text-align: right">{{ $details->conversion }}</td>
                    <td style="text-align: right">{{ number_format($details->amount,2,".",",") }}</td>
                    <td>{{ $details->sales_invoice->customer->mode_of_transaction }}</td>
                    <th style="text-align: right">{{ $details->weight }}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
