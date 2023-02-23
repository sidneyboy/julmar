<form id="invoice_out_final_summary">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>UOM</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Final Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice_draft_details as $details)
                    @if ($details->scanned_remarks == 'scanned')
                        <tr style="background:#97e47e">
                            <td>{{ $details->sku->sku_code }} - {{ $details->sku->description }}</td>
                            <td>{{ $details->sku->unit_of_measurement }}</td>
                            <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                            <td style="text-align: right">{{ $details->quantity }}</td>
                            <td><input type="number" min="0" style="text-align: center" value="0" required class="form-control form-control-sm"
                                    name="final_quantity[{{ $details->sku_id }}]">
                                <input type="hidden" name="sku_id[]" value="{{ $details->sku_id }}">
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $details->sku->sku_code }} - {{ $details->sku->description }}</td>
                            <td>{{ $details->sku->unit_of_measurement }}</td>
                            <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                            <td style="text-align: right">{{ $details->quantity }}</td>
                            <td><input type="number" min="0" style="text-align: center" value="0" required class="form-control form-control-sm"
                                    name="final_quantity">
                                <input type="hidden" name="sku_id[]" value="{{ $details->sku_id }}">
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <br />
    <input type="hidden" name="invoice_draft_id" value="{{ $invoice_id }}">
    <button class="btn btn-sm float-right btn-info">Proceed to final summary</button>
</form>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $("#invoice_out_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "invoice_out_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);

                $('#invoice_out_final_summary_page').html(data);
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
