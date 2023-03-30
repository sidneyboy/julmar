<form id="invoice_out_saved">
    <div class="row">
        <div class="col-md-6">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-sm table-striped">
                    <thead>
                        <tr>
                            <th>{{ $invoice_raw->delivery_receipt }}</th>
                            <th>{{ $invoice_raw->principal }}</th>
                            <th>{{ $invoice_raw->customer }}</th>
                        </tr>
                        <tr>
                            <th>Desc</th>
                            <th>SKU Type</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice_data as $data)
                            @if ($data->remarks == 'scanned')
                                <tr style="background:yellowgreen">
                                    <td>[<span style="color:green">{{ $data->sku_code }}</span>] -
                                        {{ $data->description }}
                                    </td>
                                    <td>{{ $data->sku->sku_type }}</td>
                                    <td style="text-align: right">{{ $data->quantity }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>[<span style="color:green">{{ $data->sku_code }}</span>]
                                        -
                                        {{ $data->description }}
                                    </td>
                                    <td>{{ $data->sku->sku_type }}</td>
                                    <td style="text-align: right">{{ $data->quantity }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-sm table-striped">
                    <thead>
                        <tr>
                            <th colspan="3">Custodian Confirmation</th>
                        </tr>
                        <tr>
                            <th>Desc</th>
                            <th>SKU Type</th>
                            <th>Final QTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $cart_data)
                            <tr>
                                <td>[<span style="color:green">{{ $cart_data->associatedModel->sku_code }}</span>] -
                                    {{ $cart_data->name }}
                                </td>
                                <td>{{ $cart_data->associatedModel->sku_type }}</td>
                                <td style="text-align: right">{{ $cart_data->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br />
    <input type="hidden" value="{{ $delivery_receipt }}" name="delivery_receipt">
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#invoice_out_saved").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "invoice_out_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                if (data == 'ledger_error') {
                    Swal.fire(
                        'Cannot Proceed',
                        'Please Contact IT Support',
                        'error'
                    )
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    location.reload();
                }
            },
            error: function(error) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
