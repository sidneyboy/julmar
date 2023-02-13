<div class="table table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Agent</th>
                <th>Store Name</th>
                <th>Principal</th>
                <th>Code</th>
                <th>Desc</th>
                <th>OS Qty</th>
                <th>OS U/P</th>
                <th>OS Sub Total</th>
                <th>OS Date</th>
                <th>Served Qty</th>
                <th>Served U/P</th>
                <th>Served Sub Total</th>
                <th>Served Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($van_selling_os_report as $data)
                <tr>
                    <td>{{ $data->customer->store_name }}</td>
                    <td>{{ $data->store_name }}</td>
                    <td>{{ $data->principal }}</td>
                    <td>{{ $data->sku_code }}</td>
                    <td>{{ $data->description }}</td>
                    <td>{{ $data->quantity }}</td>
                    <td>{{ $data->os_unit_price }}</td>
                    <td>{{ $data->os_sub_total }}</td>
                    <td>{{ $data->os_date }}</td>
                    <td>{{ $data->served_quantity }}</td>
                    <td>{{ $data->served_unit_price }}</td>
                    <td>{{ $data->served_sub_total }}</td>
                    <td>{{ $data->served_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>