<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">
    <title>Document</title>
</head>

<body>
    <br />
    <div class="container">
        <table class="table table-bordered table-sm table-striped" style="text-align: center;">
            <thead>
                <tr>
                    <td colspan="4">DRIVER'S CLEARANCE</td>
                </tr>
                <tr>
                    <td>DRIVER'S NAME</td>
                    <td>{{ $logistics->driver }}</td>
                    <td>DATE ARRIVAL</td>
                    <td>{{ $logistics->arrival_date }}</td>
                </tr>
                <tr>
                    <td>HELPER</td>
                    <td>{{ $logistics->helper_1 }}</td>
                    <td>TIME ARRIVAL:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>HELPER</td>
                    <td>{{ $logistics->helper_2 }}</td>
                    <td>NOTE BY</td>
                    <td>{{ strtoupper($logistics->sg_arrival_noted_by) }}</td>
                </tr>
                <td colspan="3">WAREHOUSE IN CHARGE</td>
                <td>ACCOUNTING</td>
            </thead>
            <tbody>
                @foreach ($logistics->logistics_details as $item)
                    <tr>
                        <td>{{ $item->principal->principal }}</td>
                        <td>{{ strtoupper($custodian[$item->principal_id]) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td>REMARKS</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>CLEARED TO DISPATCH</td>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>



    </div>
</body>

</html>
