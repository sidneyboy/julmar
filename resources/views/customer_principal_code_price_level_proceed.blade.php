<form id="customer_principal_code_price_level_saved">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>CUSTOMER ID</th>
                <th>PRINCIPAL</th>
                <th>PRINCIPAL CODE</th>
                <th>PRINCIPAL PRICE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($principal as $data)
                <tr>
                    <td>{{ $customer_id }}</td>
                    <td>{{ $data->principal }}</td>
                    <td>
                        <input type="text" name="store_code[{{ $data->id }}]" class="form-control" required>
                        <input type="hidden" name="principal_id[]" value="{{ $data->id }}">
                    </td>
                    <td>
                        <select class="form-control" name="price_level[{{ $data->id }}]" required style="width:100%;">
                            <option value="" default>PRICE LEVEL</option>
                            <option value="price_1">PRICE 1</option>
                            <option value="price_2">PRICE 2</option>
                            <option value="price_3">PRICE 3</option>
                            <option value="price_4">PRICE 4</option>
                            <option value="price_5">PRICE 5</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="customer_id" value="{{ $customer_id }}">
            <button type="submit" class="btn btn-success btn-block">SUBMIT CUSTOMER PRINCIPAL CODE</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $("#customer_principal_code_price_level_saved").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "customer_principal_code_price_level_saved",
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
                    title: 'Customer Principal Code & Price Saved!',
                    showConfirmButton: false,
                    timer: 1500
                })

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
