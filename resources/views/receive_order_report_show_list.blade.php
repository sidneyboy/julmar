<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm" style="font-size:15px;">
        <thead>
            <tr>
                <th>Received #</th>
                <th>Principal</th>
                <th>PO #</th>
                <th>Gross Purchase</th>
                <th>Total Discount</th>
                <th>Total BO Discount</th>
                <th>Vatable Purchase</th>
                <th>Vat</th>
                <th>Freight</th>
                <th>Total Final Cost</th>
                <th>Total Other Discount</th>
                <th>Net Payable</th>
                <th>Custodian</th>
                <th>Finalized</th>
                <th>Branch</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($received_purchase_order as $data)
                <tr>
                    <td><a target="_blank" href="{{ url('received_order_report_show_details',['id' => $data->id]) }}">{{ $data->id }}</a></td>
                    <td>{{ $data->principal->principal }}</td>
                    <td>{{ $data->purchase_order->purchase_id }}</td>
                    <td style="text-align: right">{{ number_format($data->gross_purchase,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->total_less_discount,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->bo_discount,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->vatable_purchase,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->vat,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->freight,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->total_final_cost,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->total_less_other_discount,2,".",",") }}</td>
                    <td style="text-align: right">{{ number_format($data->net_payable,2,".",",") }}</td>
                    <td>{{ $data->scanned_by_data->name }}</td>
                    <td>{{ $data->finalized_data->name }}</td>
                    <td>{{ $data->branch }}</td>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>