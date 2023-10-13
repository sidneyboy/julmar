@if ($report == 'Sales Register')
    <table class="table table-bordered table-sm table-striped" id="example1" style="width:100%;font-size:13px;">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Principal</th>
                <th>Description</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Gross Sales</th>
                <th>Total Disc</th>
                <th>Sales Return</th>
                <th>Net Sales</th>
                <th>U/C</th>
                <th>Gross Cost of Sales</th>
                <th>Cost of Return</th>
                <th>Cost of Sales</th>
                <th>Net Profit</th>
                <th>Salesman</th>
                <th>Sales Area</th>
                <th>KOB</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_invoice as $data)
                @foreach ($data->sales_invoice_details as $details)
                    <tr>
                        <td>{{ $data->delivery_receipt }}</td>
                        <td>{{ $data->principal->principal }}</td>
                        <td>{{ $details->sales_invoice_sku->description }}</td>
                        <td>{{ $details->sales_invoice_sku->sku_type }}</td>
                        <td style="text-align: right">{{ $details->quantity }}</td>
                        <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                        <td style="text-align: right">
                            @php
                                $gross_sales = $details->quantity * $details->unit_price;
                                $sum_gross_sales[] = $gross_sales;
                                echo number_format($gross_sales, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $total_discount = $details->total_discount_per_sku;
                                echo number_format($total_discount, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $sales_return = 0;
                                echo number_format($sales_return, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $net_sales = $details->quantity * $details->unit_price - $total_discount;
                                $sum_net_sales[] = $net_sales;
                                echo number_format($net_sales, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($details->sales_invoice_sku->sku_price_details_unit_cost->unit_cost, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right">
                            @php
                                $gross_cost_of_sales = $details->quantity * $details->sales_invoice_sku->sku_price_details_unit_cost->unit_cost;
                                $sum_gross_cost_of_sales[] = $gross_cost_of_sales;
                                echo number_format($gross_cost_of_sales, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $cost_of_return = $details->sales_invoice_sku->sku_ledger_get_average_cost->running_amount / $details->sales_invoice_sku->sku_ledger_get_average_cost->running_balance;
                                echo number_format($cost_of_return, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $net_cost_of_sales = $details->quantity * $details->sales_invoice_sku->sku_price_details_unit_cost->unit_cost - $cost_of_return;
                                $sum_net_cost_of_sales[] = $net_cost_of_sales;
                                echo number_format($net_cost_of_sales, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $net_profit = $net_sales - $net_cost_of_sales;
                                $sum_net_profit[] = $net_profit;
                                echo number_format($net_profit, 2, '.', ',');
                            @endphp
                        </td>
                        <td>{{ $data->sales_invoice_agent->full_name }}</td>
                        <td>{{ $data->sales_invoice_customer->location->location  }}</td>
                        <td>{{ $data->sales_invoice_customer->kind_of_business }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@elseif($report == 'Accounts Receivable')
    <table class="table table-bordered table-sm table-striped"style="width:100%;font-size:15px;">
        <thead>
            <tr>
                <th>Reference</th>
                <th>DR</th>
                <th>CR</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts_receivable as $data)
                <tr>
                    <td>
                        @if ($data->transaction == 'sales invoice')
                            {{ $data->sales_invoice->delivery_receipt }}
                        @elseif($data->transaction == 'collection receipt')
                            {{ $data->sales_invoice_collection_receipt->official_receipt }}
                        @elseif($data->transaction == 'migration')
                            Migration
                        @endif
                    </td>
                    <td style="text-align: right">{{ number_format($data->debit_record, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->credit_record, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->running_balance, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@elseif($report == 'Principal Sales')
    <table class="table table-bordered table-sm table-striped"style="width:100%;font-size:15px;">
        <thead>
            <tr>
                <th>Reference</th>
                <th>DR</th>
                <th>CR</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($principal_sales as $data)
                <tr>
                    <td>
                        @if ($data->transaction == 'sales invoice')
                            {{ $data->sales_invoice->delivery_receipt }}
                        @elseif($data->transaction == 'migration')
                            Migration
                        @endif
                    </td>
                    <td style="text-align: right">{{ number_format($data->debit_record, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->credit_record, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->running_balance, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@elseif($report == 'Cost of Sales')
    <table class="table table-bordered table-sm table-striped"style="width:100%;font-size:15px;">
        <thead>
            <tr>
                <th>Reference</th>
                <th>DR</th>
                <th>CR</th>
                <th>Running Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cost_of_sales as $data)
                <tr>
                    <td>
                        @if ($data->transaction == 'sales invoice')
                            {{ $data->sales_invoice->delivery_receipt }}
                        @elseif($data->transaction == 'migration')
                            Migration
                        @endif
                    </td>
                    <td style="text-align: right">{{ number_format($data->debit_record, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->credit_record, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->running_balance, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: false,
            ordering: false,
            info: false,
            searching: false,
            dom: 'Bfrtip',
            buttons: [
                // 'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                // 'pdfHtml5'
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
