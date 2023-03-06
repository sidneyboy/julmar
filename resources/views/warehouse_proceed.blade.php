<form id="warehouse_final_summary">
    <div class="table table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th colspan="5">ORIGINAL INVOICE DATA</th>
                </tr>
                <tr>
                    <th>
                        {{ $invoice[0]->customer }}
                    </th>
                    <th>
                        {{ $invoice[0]->delivery_receipt }}
                    </th>
                    <th>
                        {{ strtoupper($invoice[0]->sales_representative) }}
                    </th>
                    <th colspan="2">
                        {{ strtoupper($invoice[0]->principal) }}
                    </th>
                </tr>
                <tr>
                    <th>Code</th>
                    <th>Desc</th>
                    <th>Sku Type</th>
                    <th>Quantity</th>
                    <th>Available Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice as $data)
                    @if ($data->remarks == 'scanned')
                        <tr style="background: #97e47e">
                            <td>{{ $data->sku_code }}</td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->sku_type }}</td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                            <td><input style="text-align: right" type="text" placeholder="Available Quantity"
                                    name="final_quantity[{{ $data->id }}]" onkeypress="return isNumberKey(event)"
                                    class="form-control form-control-sm" required>
                                <input type="hidden" name="id[]" value="{{ $data->id }}">
                            </td>
                        </tr>
                    @else
                        <tr style="background:red;">
                            <td>{{ $data->sku_code }}</td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->sku_type }}</td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                            <td style="text-align: right"><input style="text-align: right" type="hidden" placeholder="Available Quantity"
                                name="final_quantity[{{ $data->id }}]" onkeypress="return isNumberKey(event)"
                                class="form-control form-control-sm" value="0" required>
                                <input type="text" disabled class="form-control form-control-sm">
                                <input type="hidden" name="id[]" value="{{ $data->id }}">
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <button class="btn btn-sm float-right btn-info">Final Summary</button>
</form>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#warehouse_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "warehouse_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#warehouse_final_summar_page').html(data);
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
