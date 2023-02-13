<div class="table table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Agent</th>
                <th>Store Name</th>
                <th>Address</th>
                <th>Remarks</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($calls as $data)
                <tr>
                    <td>{{ $data->customer->store_name }}</td>
                    <td>{{ $data->store_name }}</td>
                    <td>{{ $data->address }}</td>
                    <td>{{ $data->remarks }}</td>
                    <td>{{ $data->date }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="5">SUMMARY</th>
            </tr>
            <tr>
                <th colspan="4">PRODUCTIVE</th>
                <th>{{ $productive }}</th>
            </tr>
            <tr>
                <th colspan="4">UNPRODUCTIVE</th>
                <th>{{ $unproductive }}</th>
            </tr>
            <tr>
                <th colspan="4">TOTAL</th>
                <th>{{ $productive + $unproductive }}</th>
            </tr>
        </tbody>
    </table>
</div>
