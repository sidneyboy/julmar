<form id="purchase_order_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="4">PO #:{{ $po_id }}</th>
                </tr>
                <tr>
                    <th>Desc</th>
                    <th>Principal</th>
                    <th>SKU Type</th>
                    <th>Quantity</th>
                    {{-- <th>Option</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($sku as $data)
                    <tr>
                        <td>{{ $data->attributes[0] }}</td>
                        <td>{{ $principal_name }}</td>
                        <td>{{ $data->attributes[1] }}</td>
                        <td style="text-align: right">{{ number_format($data->quantity) }}
                            @php
                                $sum_quantity[] = $data->quantity;
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th style="text-align: right">{{ array_sum($sum_quantity) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <br />
    <input type="hidden" name="purchase_id" value="{{ $po_id }}">
    <input type="hidden" name="principal_id" value="{{ $principal_id }}">
    <input type="hidden" name="sku_type" value="{{ $sku_type }}">
    <button class="btn btn-sm float-right btn-success">Submit</button>
</form>

<script>
    $("#purchase_order_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "purchase_order_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
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
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>
