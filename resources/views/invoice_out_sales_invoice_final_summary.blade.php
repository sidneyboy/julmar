<form id="invoice_out_sales_invoice_saved">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th>Principal</th>
                    <th>Desc</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice_details as $data)
                    @if ($data->remarks == 'scanned')
                        <tr style="background-color:yellowgreen">
                            <td>{{ $data->sku->skuPrincipal->principal }}</td>
                            <td>[{{ $data->sku->sku_code }}] -
                                {{ $data->sku->description }}
                            </td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $data->sku->skuPrincipal->principal }}</td>
                            <td>[{{ $data->sku->sku_code }}] -
                                {{ $data->sku->description }}
                            </td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <input type="hidden" value="{{ $rep_dr }}" name="rep_dr">
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#invoice_out_sales_invoice_saved").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "invoice_out_sales_invoice_saved",
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
