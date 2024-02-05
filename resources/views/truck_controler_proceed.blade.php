<form action="truck_load_controler_print" method="post" target="_blank">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-striped table-sm table-hover" style="width:100%;" id="example1">
            <thead>
                <tr>
                    <th colspan="2">Prepared By: </th>
                    <th colspan="10">{{ strtoupper($logistics->user->name) }}</th>
                </tr>
                <tr>
                    <th colspan="2">Driver & Helper: </th>
                    <th colspan="10">{{ strtoupper($logistics->load_sheet_driver->full_name) }},
                        {{ strtoupper($logistics->helper_1) }}, {{ strtoupper($logistics->helper_2) }}</th>
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
                @foreach ($logistics->logistics_invoices as $details)
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
                        <th style="text-align: right">{{ $details->weight }}
                            <input type="hidden" name="sales_invoice_id[]" value="{{ $details->sales_invoice_id }}">
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="form-group">
        <input type="hidden" name="logistics_id" value="{{ $logistics->id }}">
        <button class="btn btn-sm float-right btn-success" id="submit" type="submit">Print Control</button>
    </div>
</form>


<script>
    $("#submit").change(function() {
        location.reload();
    });
</script>
