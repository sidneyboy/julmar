<div class="table table-responsive">
    <table class="table table-bordered table-sm table-hover">
        <thead>
            <tr>
                <td colspan="5">{{ $van_selling->customer->store_name }} <span
                        style="color:green;font-weight:bold">[{{ $van_selling->delivery_receipt }}]</span></td>
            </tr>
            <tr>
                <th>Desc</th>
                <th>Sku Type</th>
                <th>Quantity</th>
                <th>U/P</th>
                <th>Sub-Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($van_selling->vs_withdrawal_details as $data)
                <tr>
                    <td><span style="color:green;font-weight:bold;">{{ $data->sku->sku_code }}</span> -
                        {{ $data->sku->description }}</td>
                    <td>{{ $data->sku->sku_type }}</td>
                    <td style="text-align:right">{{ $data->quantity }}</td>
                    <td style="text-align:right">{{ number_format($data->unit_price, 2, '.', ',') }}</td>
                    <td style="text-align:right;">
                        @php
                            $total = $data->quantity * $data->unit_price;
                            $sum_quantity[] = $data->quantity;
                            $sum_total[] = $total;
                            echo number_format($total, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th></th>
                <th style="text-align: right">{{ array_sum($sum_quantity) }}</th>
                <th></th>
                <th style="text-align:right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
            </tr>
        </tfoot>
    </table>
</div>


<form method="post" action="{{ route('van_selling_invoice_print') }}">
    @csrf
    <input type="hidden" name="vs_withdrawal_id" value="{{ $van_selling->id }}">
    <button type="submit" id="reload" class="btn btn-block btn-success">PRINT VAN SELLING INVOICE</button>
</form>
