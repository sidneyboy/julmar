<form id="invoice_out_saved">
    {{-- <div class="row">
        <div class="col-md-12">
          
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-hover table-sm table-striped">
                <thead>
                    <tr>
                        <th colspan="4">Scanned By Custodian</th>
                    </tr>
                    <tr>
                        <th>Principal</th>
                        <th>Code</th>
                        <th>Desc</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $data)
                        <tr>
                            <td>{{ $data->associatedModel->sku->skuPrincipal->principal }}</td>
                            <td>{{ $data->associatedModel->sku->sku_code }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->quantity }}
                                <input type="hidden" name="principal_id[]" value="{{ $data->associatedModel->sku->principal_id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}
    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <th colspan="4">Invoice</th>
            </tr>
            <tr>
                <th>Principal</th>
                <th>Code</th>
                <th>Desc</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice_data as $data)
                @if ($data->remarks == 'scanned')
                    <tr style="background: yellowgreen">
                        <td>{{ $data->principal }}</td>
                        <td>{{ $data->sku_code }}</td>
                        <td>{{ $data->description }}</td>
                        <td style="text-align: right">{{ $data->total_quantity }}
                            <input type="hidden" name="principal_id[]" value="{{ $data->sku->principal_id }}">
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $data->principal }}</td>
                        <td>{{ $data->sku_code }}</td>
                        <td>{{ $data->description }}</td>
                        <td style="text-align: right">{{ $data->total_quantity }}
                            <input type="hidden" name="principal_id[]" value="{{ $data->sku->principal_id }}">
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <input type="hidden" name="sales_representative" value="{{ $sales_representative }}">

    @foreach ($customer as $customer_data)
        <input type="hidden" name="customer_data[]" value="{{ $customer_data }}">
    @endforeach
    <br />
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#invoice_out_saved").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "invoice_out_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                location.reload();

            },
            error: function(error) {
                $('#loader').hide();
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
