<form id="bo_allowance_adjustments_show_summary">
    <div class="form-group">
        <label for="">Bo Cost Adjustment</label>
        <input type="text" class="form-control form-control-sm" name="unit_cost_adjustment">
    </div>
    
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Sku Type</th>
                    <th>Qty Received</th>
                    <th>Final Unit Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sku_add_details as $data)
                    <tr>
                        <td style="text-transform: uppercase;">{{ $data->sku->sku_code }}</td>
                        <td style="text-transform: uppercase;">{{ $data->sku->description }}</td>
                        <td style="text-transform: uppercase;">{{ $data->sku->sku_type }}</td>
                        <td>
                            @php
                                $quantity = $data->quantity - $data->quantity_returned;
                            @endphp
                            {{ $quantity }}
                        </td>
                        <td style="text-align: right;">{{ number_format($data->final_unit_cost, 2, '.', ',') }}
                            <input type="hidden" value="{{ $data->sku->description }}"
                                name="description[{{ $data->sku->id }}]">
                            <input type="hidden" value="{{ $data->sku->unit_of_measurement }}"
                                name="unit_of_measurement[{{ $data->sku->id }}]">
                            <input type="hidden" value="{{ $quantity }}" name="quantity[{{ $data->sku->id }}]">
                            <input type="hidden" value="{{ $data->sku->sku_code }}"
                                name="code[{{ $data->sku->id }}]">
                            <input type="hidden" value="{{ $data->final_unit_cost }}"
                                name="unit_cost[{{ $data->sku_id }}]">
                            <input type="hidden" value="{{ $data->sku->category_id }}"
                                name="category_id[{{ $data->sku_id }}]">
                            <input type="hidden" value="{{ $data->sku->sku_type }}"
                                name="sku_type[{{ $data->sku_id }}]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <input type="hidden" value="{{ $received_id }}" name="received_id">
    <input type="hidden" value="{{ $principal_name }}" name="principal_name">
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <input type="hidden" value="{{ $purchase_id }}" name="purchase_id">
    <input type="hidden" value="{{ $dr_si }}" name="dr_si">

    <label>Particulars</label>
    <input type="text" class="form-control" name="particulars" required><br />

    <button class="float-right btn btn-info btn-sm" type="submit">Generate</button>
</form>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $("#bo_allowance_adjustments_show_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "bo_allowance_adjustments_show_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                $('#show_bo_allowance_adjustments_summary').show();
                $('#show_bo_allowance_adjustments_summary').html(data);
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
