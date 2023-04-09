<form id="van_selling_generate_final_summary">
    <div class="form-group">
        <label>Delivery Receipt:</label>
        <input type="texxt" name="delivery_receipt" class="form-control" required placeholder="Ex... VS-PFC-0001"
            style="text-transform: uppercase;">
    </div>
    <div class="table table-responsive">
        <table class="table table-hovered table-bordered table-sm table-striped" id="example2">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Desc</th>
                    <th>Type</th>
                    <th>R-QTY</th>
                    <th>QTY</th>
                    <th>U/P</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $data)
                    <tr>
                        <td>{{ $data->associatedModel->sku_code }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->associatedModel->sku_type }}</td>
                        <td style="text-align: right">{{ $data->associatedModel->sku_ledger_latest->running_balance }}
                        </td>
                        <td style="text-align: right">{{ $data->quantity }}</td>
                        <td>
                            <input type="hidden" name="quantity[{{ $data->id }}]" value="{{ $data->quantity }}">
                            <input type="hidden" name="running_balance[{{ $data->id }}]"
                                value="{{ $data->associatedModel->sku_ledger_latest->running_balance }}">
                            <input type="text" name="unit_price[{{ $data->id }}]" style="text-align: right" class="form-control form-control-sm"
                                value="{{ $data->price }}" onkeypress="return isNumberKey(event)">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <input type="hidden" name="principal_id" value="{{ $principal_id }}">
    <button type="submit" class="btn btn-info btn-sm float-right">Final Summary</button>

</form>


<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#van_selling_generate_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "van_selling_generate_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                if (data == 'quantity_is_greater') {
                    $('#loader').hide();
                    Swal.fire(
                        'ERROR INPUT',
                        'QUANTITY IS GREATER THAN RUNNING BALANCE',
                        'error'
                    )

                } else if (data == 'existing') {
                    $('#loader').hide();
                    Swal.fire(
                        'CANNOT PROCEED',
                        'EXISTING DELIVERY RECEIPT',
                        'error'
                    )

                } else {
                    $('#van_selling_generate_final_summary_page').html(data);
                    $('#loader').hide();
                }
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
