<link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">
<div class="row">
    <div class="col-12">
        <center>
            <h2 class="page-header">
                JULMAR COMMERCIAL. INC,
            </h2>
        </center>
    </div>
    <!-- /.col -->
</div>
<!-- info row -->
<div class="row invoice-info">
    <div class="col-sm-12 invoice-col">
        <center>
            <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
            <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
        </center>
        <br />
        <center>
            <span style="font-weight: bold;font-size:18px;text-transform: uppercase;">{{ $bodega_out->remarks }} #:
                {{ $bodega_out->id }} ({{ $bodega_out->principal->principal }}) </span><br />
            <span style="font-size:15px;">
                <br />
                @php
                    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                @endphp


                <center>
                    {!! $generator->getBarcode($bodega_out->id, $generator::TYPE_CODE_128) !!}
                    <p>{{ $bodega_out->id }}</p>
                </center>

    </div>
</div>
<br />

<div class="container">
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Out From</th>
                <th>Out QTY</th>
                <th>In To</th>
                <th>In QTY</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bodega_out_details as $details)
                <tr>
                    <td>{{ $details->out_from->sku_code }} - {{ $details->out_from->description }}</td>
                    <td>{{ $details->out_from_quantity }}</td>
                    <td>{{ $details->in_to->sku_code }} - {{ $details->in_to->description }}</td>
                    <td>{{ $details->in_to_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
