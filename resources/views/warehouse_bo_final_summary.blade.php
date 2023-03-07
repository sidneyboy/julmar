<form id="warehouse_bo_saved">
    <div class="table table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th colspan="5">SALES REP: {{ $agent->full_name }}</th>
                </tr>
                <tr>
                    <th>Principal</th>
                    <th>Code</th>
                    <th>Desc</th>
                    <th>Sku Type</th>
                    <th>BO QTY</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($draft as $data)
                    <td>{{ $data->sku->skuPrincipal->principal }}</td>
                    <td>{{ $data->sku->sku_code }}</td>
                    <td>{{ $data->sku->description }}</td>
                    <td>{{ $data->sku->sku_type }}</td>
                    <td>{{ $bo_quantity[$data->id] }}
                        <input type="hidden" value="{{ $data->sku_id }}" name="sku_id[]">
                        <input type="hidden" value="{{ $bo_quantity[$data->id] }}" name="bad_order_quantity[{{ $data->sku_id }}]">
                    </td>
                @endforeach
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>

    <input type="hidden" name="agent_id" value="{{ $agent->id }}">
    <input type="hidden" name="principal_id" value="{{ $draft[0]->sku->principal_id }}">
    <input type="hidden" name="sku_type" value="{{ $draft[0]->sku->sku_type }}">
    <button class="btn btn-sm float-right btn-success">Submit</button>

</form>

<script>
    $("#warehouse_bo_saved").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "warehouse_bo_saved",
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
