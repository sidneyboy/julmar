<div class="table table-responsive">
    <table class="table table-bordered table-striped table-sm table-hover">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Sku Type</th>
                <th>Ordered</th>
                <th>Confirmed</th>
                <th>Received</th>
                <th>Remaining</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase_order_details as $data)
                <tr>
                    <td>{{ $data->sku->sku_code }}</td>
                    <td>{{ $data->sku->description }}</td>
                    <td>{{ $data->sku->sku_type }}</td>
                    <td style="text-align: right">{{ $data->quantity }}</td>
                    <td style="text-align: right">{{ $data->confirmed_quantity }}</td>
                    <td style="text-align: right">{{ $data->received }}</td>
                    <td style="text-align: right">
                        {{ $data->confirmed_quantity - $data->receive }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
