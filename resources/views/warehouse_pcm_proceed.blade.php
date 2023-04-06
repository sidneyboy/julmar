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
    <div class="row">
        <div class="col-md-6">
            <label for="">Quantity:</label>
            <input type="text" class="form-control" required name="quantity" id="quantity">
        </div>
        <div class="col-md-6">
            <label for="">Barcode:</label>
            <input type="text" class="form-control" required name="barcode" id="barcode">
        </div>
    </div>
    <input type="hidden" value="{{ $type }}" name="type">
    <input type="hidden" value="{{ $id }}" name="id">
    <br />
    <button class="btn btn-sm float-right btn-info">Proceed</button>
</form>

<script>
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
                }
            },
            error: function(error) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
                $('#loader').hide();
            }
        });
    }));
</script>
