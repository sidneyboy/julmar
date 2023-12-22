<form id="invoice_cost_adjustments_show_summary">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>SKU Type</th>
                    <th>Qty Received</th>
                    <th>Unit Cost</th>
                    <th>Adjusted Unit Cost</th>
                    <th>Original Freight</th>
                    <th>New Freight</th>
                    <th style="text-align: center;"><input type="checkbox" onclick="toggle(this);" class="big-checkbox" />
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sku_add_details as $data)
                    <tr>
                        <td style="text-transform: uppercase;">{{ $data->sku->sku_code }}</td>
                        <td style="text-transform: uppercase;">{{ $data->sku->description }}</td>
                        <td style="text-transform: uppercase;">{{ $data->sku->sku_type }}</td>
                        <td>
                            {{ $quantity = $data->quantity - $data->quantity_returned }}</td>
                        <td style="text-align: right;">
                            {{ number_format($data->unit_cost, 2, '.', ',') }}
                            <input type="hidden" name="unit_cost[{{ $data->sku->id }}]" value="{{ $data->unit_cost }}">
                        </td>
                        <td><input type="text" class="form-control form-control-sm"
                                name="unit_cost_adjustment[{{ $data->sku->id }}]"
                                onkeypress="return isNumberKey(event)"></td>
                        <td style="text-align: right">{{ $data->freight }}
                            <input type="hidden" name="freight[{{ $data->sku->id }}]" value="{{ $data->freight }}">
                        </td>
                        <td><input type="text" class="form-control form-control-sm"
                                name="new_freight[{{ $data->sku->id }}]" value="0"
                                onkeypress="return isNumberKey(event)"></td>
                        <td>
                            <center>
                                <input type="checkbox" name="checkbox_entry[]" value="{{ $data->sku->id }}"
                                    class="big-checkbox" />
                            </center>
                            <input type="hidden" value="{{ $data->sku->description }}"
                                name="description[{{ $data->sku->id }}]">
                            <input type="hidden" value="{{ $quantity }}" name="quantity[{{ $data->sku->id }}]">
                            <input type="hidden" value="{{ $data->sku->sku_code }}"
                                name="code[{{ $data->sku->id }}]">

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <input type="hidden" value="{{ $received_id }}" name="received_id">
    {{-- <input type="hidden" value="{{ $principal_name }}" name="principal_name">
    <input type="hidden" value="{{ $principal_id }}" name="invoice_cost_principal_id">
    <input type="hidden" value="{{ $purchase_id }}" name="purchase_id">
    <input type="hidden" value="{{ $dr_si }}" name="dr_si"> --}}

    <div class="row">
        <div class="col-md-6">
            <label>Particulars</label>
            <input type="text" class="form-control" name="particulars" required>
        </div>
        <div class="col-md-6">
            <label for="">Transaction Date</label>
            <input type="date" class="form-control" name="transaction_date" required>
        </div>
    </div>
    <br />
    <button class="float-right btn btn-info btn-sm " type="submit" style="font-weight: bold;">Generate</button>
</form>

<script>
    function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $("#invoice_cost_adjustments_show_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "invoice_cost_adjustments_show_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#show_invoice_cost_adjustments_summary').html(data);
                $('#loader').hide();
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
