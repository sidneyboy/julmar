<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Julmar</title>
</head>

<body>
    <div class="container-fluid">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <th>Date</th>
                <th>Principal</th>
                <th>Description</th>
                <th>Type</th>
                <th>Transaction</th>
                <th>Beginning</th>
                <th>Quantity</th>
                <th>Ending</th>
                <th>U/P</th>
                <th>Sub-Total</th>
            </thead>
            <tbody>
                @foreach ($sku_ledger as $data)
                    <tr>
                        <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                        <td>{{ $data->principal->principal }}</td>
                        <td>{{ $data->sku->description }}</td>
                        <td>{{ $data->sku->sku_type }}</td>
                        <td>{{ Str::ucfirst($data->transaction) }}</td>
                        <td style="text-align: right">{{ $data->beginning_inventory }}</td>
                        <td style="text-align: right">{{ $data->quantity }}</td>
                        <td style="text-align: right">{{ $data->ending_inventory }}</td>
                        <td style="text-align: right">
                            {{ number_format($data->unit_price, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right">
                            @php
                                $sub_total = $data->unit_price * $data->ending_inventory;
                                $sum[] = $sub_total;
                                echo number_format($sub_total, 2, '.', ',');
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="8">Total</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum), 2, '.', ',') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
