<div class="table table-responsive">
    <table class="table table-bordered table-sm table-striped">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Principal</th>
                <th>Productive Calls</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productive_calls as $data)
                <tr>
                    <td>{{ $data->customer->store_name }}</td>
                    <td>{{ $data->principal->principal }}</td>
                    <td style="text-align: right">{{ $data->count }}
                        @php
                            $sum[] = $data->count;
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: center">TOTAL</td>
                <td style="text-align: right">{{ array_sum($sum) }}</td>
            </tr>
        </tfoot>
    </table>
</div>