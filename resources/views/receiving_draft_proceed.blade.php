<form id="receiving_draft_final_saved">
    <div class="form-group">
        <label for="">Purchase Order Number</label>
        <select name="purchase_id" class="form-control" required>
            <option value="" default>Select</option>
            @foreach ($purchase_order as $data)
                <option value="{{ $data->id }}">{{ $data->purchase_id }}</option>
            @endforeach
        </select>
    </div>
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Received</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receiving_draft as $data)
                    <tr>
                        <td>{{ $data->sku->sku_code }}</td>
                        <td>{{ $data->sku->description }}</td>
                        <td><input type="number" min="0" class="form-control form-control-sm"
                                name="quantity_received[{{ $data->id }}]"></td>
                        <td>
                            <select name="remarks[{{ $data->id }}]" class="form-control form-control-sm" required>
                                <option value="" default>Select</option>
                                <option value="received">Received</option>
                                <option value="not_complete">Not Complete</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br />
    <input type="hidden" value="{{ $session_id }}" name="session_id">
    <button class="btn btn-sm float-right btn-success" type="submit">Submit as Draft</button>
</form>

<script>
    $("#receiving_draft_final_saved").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $.ajax({
            url: "receiving_draft_final_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'saved') {
                    Swal.fire(
                        'Success',
                        'Draft Successfully Saved',
                        'success'
                    );

                    location.reload();
                }
            },
        });
    }));
</script>
