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
                            <th style="text-align: center;">Desc</th>
                            <th style="text-align: center;">Confirmed QTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase_order_details as $po_data)
                            @if ($po_data->confirmed_quantity > $po_data->receive != 0)
                                @if ($po_data->scanned_remarks == 'scanned')
                                    <tr style="background: #97e47e">
                                        <td><span style="font-weight:bold">{{ $po_data->sku->sku_code }}</span>
                                            -
                                            {{ $po_data->sku->description }}</td>
                                        <td style="text-align: center">
                                            {{ $po_data->confirmed_quantity - $po_data->receive }}
                                            @php
                                                $sum_confirmed_quantity[] = $po_data->confirmed_quantity - $po_data->receive;
                                            @endphp
                                            <input type="hidden" name="confirmed_quantity[{{ $po_data->sku->id }}]" value="{{ $po_data->confirmed_quantity - $po_data->receive }}">
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td><span style="font-weight:bold">{{ $po_data->sku->sku_code }}</span>
                                            -
                                            {{ $po_data->sku->description }}</td>
                                        <td style="text-align: center">{{ $po_data->confirmed_quantity - $po_data->receive }}
                                            @php
                                                $sum_confirmed_quantity[] = $po_data->confirmed_quantity - $po_data->receive;
                                            @endphp
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th style="text-align: center">{{ array_sum($sum_confirmed_quantity) }}</th>
                        </tr>
                    </tfoot>
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
                            <th style="text-align: center;">Desc</th>
                            <th style="text-align: center;">U/C(VAT EXT)</th>
                            <th style="text-align: center;">Freight</th>
                            <th style="text-align: center;">Received</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receiving_draft as $draft_data)
                            <tr>
                                <td><span style="color:red;font-weight:bold">{{ $draft_data->sku->sku_code }}</span>
                                    {{ $draft_data->sku->description }}</td>
                                <td style="text-align: right">{{ number_format($draft_data->unit_cost, 2, '.', ',') }}
                                </td>
                                <td style="text-align: right">{{ number_format($draft_data->freight, 2, '.', ',') }}
                                </td>
                                <td><input style="text-align: center" type="number" min="0"
                                        value="{{ $draft_data->quantity }}" class="form-control form-control-sm"
                                        name="quantity_received[{{ $draft_data->sku_id }}]">
                                    @php
                                        $sum_quantity[] = $draft_data->quantity;
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: center">{{ array_sum($sum_quantity) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <br />
    <input type="hidden" value="{{ $session_id }}" name="session_id">
    <input type="hidden" value="{{ $purchase_order_id }}" name="purchase_order_id">
    <button class="btn btn-sm float-right btn-success" type="submit">Submit as Draft</button>
</form>

<script>
    $("#receiving_draft_final_saved").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "receiving_draft_final_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'saved') {
                    $('#loader').hide();
                    Swal.fire(
                        'Success',
                        'Draft Successfully Saved',
                        'success'
                    );

                    location.reload();
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
