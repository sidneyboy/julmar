<form id="warehouse_bo_final_summary">
    <label for="">Agent</label>
    <select name="agent_id" class="form-control select2bs4" required>
        <option value="" default>Select</option>
        @foreach ($agent as $data)
            <option value="{{ $data->id }}">{{ $data->full_name }}</option>
        @endforeach
    </select>
    <br />
    <div class="table table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
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
                    <tr>
                        <td>{{ $data->sku->skuPrincipal->principal }}</td>
                        <td>{{ $data->sku->sku_code }}</td>
                        <td>{{ $data->sku->description }}</td>
                        <td>{{ $data->sku->sku_type }}</td>
                        <td>
                            <input type="hidden" value="{{ $data->id }}" name="id[]">
                            <input type="number" min="0" class="form-control form-control-sm" required
                                name="bo_quantity[{{ $data->id }}]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <button class="btn btn-sm float-right btn-info">Final Summary</button>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#warehouse_bo_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "warehouse_bo_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#warehouse_bo_final_summary_page').html(data);
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
