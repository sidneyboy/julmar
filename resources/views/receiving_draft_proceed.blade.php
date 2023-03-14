<form id="receiving_draft_final_saved">
    <div class="row">
        <div class="col-md-4">
            <div class="table table-responsive">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr>
                            <th colspan="2">Purchase Order (Not Yet Received)</th>
                        </tr>
                        <tr>
                            <th>Desc</th>
                            <th>Ordered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase_order_details as $po_data)
                            @if ($po_data->scanned_remarks == 'scanned')
                                <tr style="background: #97e47e">
                                    <td><span style="font-weight:bold">{{ $po_data->sku->sku_code }}</span>
                                        -
                                        {{ $po_data->sku->description }}</td>
                                    <td>{{ $po_data->confirmed_quantity - $po_data->receive }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td><span style="font-weight:bold">{{ $po_data->sku->sku_code }}</span>
                                        -
                                        {{ $po_data->sku->description }}</td>
                                    <td>{{ $po_data->confirmed_quantity }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8">
            <div class="table table-responsive">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr>
                            <th colspan="5">Scanned SKU(Draft)</th>
                        </tr>
                        <tr>
                            <th>Desc</th>
                            <th>U/C(VAT EXT)</th>
                            <th>Freight</th>
                            <th>Received</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receiving_draft as $draft_data)
                            <tr>
                                <td><span style="color:red;font-weight:bold">{{ $draft_data->sku->sku_code }}</span>
                                    {{ $draft_data->sku->description }}</td>
                                <td style="text-align: right">{{ number_format($draft_data->unit_cost,2,".",",")  }}</td>
                                <td style="text-align: right">{{ number_format($draft_data->freight,2,".",",")  }}</td>
                                <td><input type="number" min="0" class="form-control form-control-sm"
                                    name="quantity_received[{{ $draft_data->id }}]"></td>
                                <td>
                                    <select name="remarks[{{ $draft_data->id }}]" class="form-control form-control-sm"
                                        required>
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
        </div>
    </div>
    <br />
    <input type="hidden" value="{{ $session_id }}" name="session_id">
    <input type="hidden" value="{{ $purchase_order_details[0]->purchase_order_id }}" name="purchase_order_id">
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
                console.log(data);
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
