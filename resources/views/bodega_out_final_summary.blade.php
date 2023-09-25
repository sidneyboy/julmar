<form id="bodega_out_saved">
    @if ($sku_type == 'Case')
        <label>OUT FROM CASE</label>
        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>SKU Type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $sku_add->sku_code }}</td>
                    <td>{{ $sku_add->description }}</td>
                    <td>{{ $convert }}</td>
                    <td>Case
                        <input type="hidden" name="out_from_sku_id" value="{{ $sku_add->id }}">
                        <input type="hidden" name="out_from_quantity" value="{{ $convert }}">
                    </td>
                </tr>
            </tbody>
        </table>

        <label>IN TO BUTAL</label>
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>SKU Type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $equivalents->sku_code }}</td>
                    <td>{{ $equivalents->description }}</td>
                    <td>
                        {{ $equivalents->equivalent_butal_pcs * $convert }}</td>
                    <td>Butal
                        <input type="hidden" name="in_to_sku_id" value="{{ $equivalents->id }}">
                        <input type="hidden" name="in_to_quantity"
                            value="{{ $equivalents->equivalent_butal_pcs * $convert }}">
                    </td>
                </tr>
            </tbody>
        </table>

        <input type="hidden" name="remarks" value="out from case">
    @else
        <label>OUT FROM BUTAL</label>
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>SKU Type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $sku_add->sku_code }}</td>
                    <td>{{ $sku_add->description }}</td>
                    <td>{{ $sku_add->equivalent_butal_pcs * $convert }}</td>
                    <td>Butal
                        <input type="hidden" name="out_from_sku_id" value="{{ $sku_add->id }}">
                        <input type="hidden" name="out_from_quantity" value="{{ $convert }}">
                    </td>
                </tr>
            </tbody>
        </table>

        <label>IN TO CASE</label>
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>SKU Type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $equivalents->sku_code }}</td>
                    <td>{{ $equivalents->description }}</td>
                    <td>{{ $convert }}</td>
                    <td>Case
                        <input type="hidden" name="in_to_sku_id" value="{{ $equivalents->id }}">
                        <input type="hidden" name="in_to_quantity"
                            value="{{ $equivalents->equivalent_butal_pcs * $convert }}">
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="remarks" value="out from butal">
    @endif

    <input type="hidden" name="sku_type" value="{{ $sku_type }}">
    <input type="hidden" name="principal_id" value="{{ $principal_id }}">
    <button class="btn btn-sm float-right btn-success">Submit</button>
</form>


<script>
    $("#bodega_out_saved").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "bodega_out_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                if (data == 'no_inventory_found') {
                    Swal.fire(
                        'Cannot Proceed',
                        'No Inventory Found!',
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
