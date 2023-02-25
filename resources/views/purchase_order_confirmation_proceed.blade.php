<div class="table table-responsive">
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Desc</th>
                <th>Quantity</th>
                <th>Confirmed Quantity</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase_order->purchase_order_details as $data)
                <tr>
                    <td>{{ $data->sku->sku_code }} - {{ $data->sku->description }}</td>
                    <td>{{ $data->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>