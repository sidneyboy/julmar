<form id="warehouse_pcm_final_summary">
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Quantity</th>
                    <th>U/P</th>
                    <th>Sub-Total</th>
                </tr>
            </thead>
            <tbody>
                @if ($type == 'rgs')
                    @foreach ($pcm->return_good_stock_details as $data)
                        <tr>
                            <td>[<span style="color:green">{{ $data->sku->sku_code }}</span>] -
                                {{ $data->sku->description }}
                            </td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                            <td style="text-align: right">{{ number_format($data->unit_price, 2, '.', ',') }}</td>
                            <td style="text-align: right">
                                @php
                                    $total = $data->quantity * $data->unit_price;
                                    $sum_total[] = $total;
                                    echo number_format($data->unit_price, 2, '.', ',');
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                @else
                    @foreach ($pcm->bad_order_details as $data)
                        <tr>
                            <td>[<span style="color:green">{{ $data->sku->sku_code }}</span>] -
                                {{ $data->sku->description }}
                            </td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                            <td style="text-align: right">{{ number_format($data->unit_price, 2, '.', ',') }}</td>
                            <td style="text-align: right">
                                @php
                                    $total = $data->quantity * $data->unit_price;
                                    $sum_total[] = $total;
                                    echo number_format($data->unit_price, 2, '.', ',');
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-sm float-right btn-dark" id="scan_barcode" style="display:none">SCAN BARCODE</a>
            <a class="btn btn-sm float-right btn-warning" id="select_sku">SELECT SKU</a>
        </div>
    </div>
    <div class="row" id="show_sku" style="display:none">
        <div class="col-md-6">
            <label for="">Quantity:</label>
            <input type="number" min="1" class="form-control" name="sku_quantity" id="sku_quantity">
        </div>
        <div class="col-md-6">
            <label for="">SKU:</label>
            <select name="sku_barcode" id="sku_barcode" class="form-control select2bs4">
                <option value="" default>Select</option>
                @foreach ($pcm_details as $data)
                    <option value="{{ $data->sku_id }}">[<span
                            style="font-weight: bold;color:green">{{ $data->sku->sku_code }}</span>] -
                        {{ $data->sku->description }}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="row" id="show_barcode">
        <div class="col-md-6">
            <label for="">Quantity:</label>
            <input type="number" min="1" class="form-control" name="quantity" id="quantity">
        </div>
        <div class="col-md-6">
            <label for="">Barcode:</label>
            <input type="text" class="form-control" id="barcode" name="barcode">
        </div>

    </div>
    <input type="hidden" value="{{ $type }}" name="type">
    <input type="hidden" value="{{ $id }}" name="id">
    <br />
    <button class="btn btn-sm float-right btn-info">Proceed</button>
</form>

<script>
    $("#select_sku").click(function() {
        $('#show_barcode').hide();
        $('#select_sku').hide();
        $('#show_sku').show();
        $('#scan_barcode').show();
        $('#quantity').val('');
        $('#barcode').val('');
    });

    $("#scan_barcode").click(function() {
        $('#show_barcode').show();
        $('#select_sku').show();
        $('#show_sku').hide();
        $('#scan_barcode').hide();
        $('#sku_quantity').val('');
        $("#sku_barcode").val('').trigger('change');
    });


    $("#warehouse_pcm_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "warehouse_pcm_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'invalid') {
                    Swal.fire(
                        'Cannot Proceed',
                        'Invalid Bardcode',
                        'error'
                    )
                    $('#loader').hide();
                } else {
                    $('#quantity').val('');
                    $('#barcode').val('');
                    $('#quantity').focus();
                    $('#warehouse_pcm_final_summary_page').html(data);
                    $('#loader').hide();
                    $('#scan_barcode').click();
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
