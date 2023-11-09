<table class="table table-bordered table-hover table-striped table-sm">
    <thead>
        <tr>
            <th>Date of Invoice</th>
            <th>Store Name</th>
            <th>Delivery Receipt</th>
            <th>Total Amount</th>
            <th>Aging</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales_invoice as $data)
            <tr>
                <td>{{ $data->sales_invoice_printed }}</td>
                <td>{{ $data->customer->store_name }}</td>
                <td>{{ $data->delivery_receipt }}</td>
                <td style="text-align: right">
                    @php
                        $total_amount = $data->total_amount - $data->total_returned_amount;
                        if ($total_amount > 0) {
                            echo number_format($total_amount, 2, ',', '.');
                        } else {
                            echo number_format($total_amount * -1, 2, ',', '.');
                        }
                    @endphp
                </td>
                <td style="text-align: center;">
                    @if (!isset($data->delivered))
                        @php
                            $aging = 0;
                        @endphp
                    @else
                        @php
                            $now = time(); // or your date as well
                            $your_date = strtotime($data->delivered_date);
                            $datediff = $now - $your_date;

                            $aging = round($datediff / (60 * 60 * 24));
                        @endphp
                    @endif

                    @if ($aging <= 15)
                        <span style="font-size:14px;" class="badge badge-success">{{ $aging }}</span>
                    @elseif($aging <= 30)
                        <span style="font-size:14px;" class="badge badge-warning">{{ $aging }}</span>
                    @elseif($aging > 30)
                        <span style="font-size:14px;" class="badge badge-danger">{{ $aging }}</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
