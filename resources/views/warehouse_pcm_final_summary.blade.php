<form id="warehouse_pcm_save">
    <div class="row">
        <div class="col-md-6">
            <div class="table table-responsive">
                <table class="table table-bordered table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Desc</th>
                            <th>QTY</th>
                            <th>U/P</th>
                            <th>Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($type == 'rgs')
                            @foreach ($pcm->return_good_stock_details as $data)
                                @if ($data->remarks == 'scanned')
                                    <tr style="background:yellowgreen">
                                        <td style="font-size:11px;">[<span
                                                style="color:green">{{ $data->sku->sku_code }}</span>] -
                                            {{ $data->sku->description }}
                                        </td>
                                        <td style="text-align: right">{{ $data->quantity }}</td>
                                        <td style="text-align: right">{{ number_format($data->unit_price, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $total = $data->quantity * $data->unit_price;
                                                $sum_total[] = $total;
                                                echo number_format($data->unit_price, 2, '.', ',');
                                            @endphp
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td style="font-size:11px;">[<span
                                                style="color:green">{{ $data->sku->sku_code }}</span>] -
                                            {{ $data->sku->description }}
                                        </td>
                                        <td style="text-align: right">
                                            {{ $data->quantity }}
                                            {{-- @php
                                                $sum_quantity[] = $data->quantity;
                                            @endphp --}}
                                        </td>
                                        <td style="text-align: right">
                                            {{ number_format($data->unit_price, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $total = $data->quantity * $data->unit_price;
                                                $sum_total[] = $total;
                                                echo number_format($total, 2, '.', ',');
                                            @endphp
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            @foreach ($pcm->bad_order_details as $data)
                                @if ($data->remarks == 'scanned')
                                    <tr style="background:yellowgreen">
                                        <td style="font-size:11px;">[<span
                                                style="color:green">{{ $data->sku->sku_code }}</span>] -
                                            {{ $data->sku->description }}
                                        </td>
                                        <td style="text-align: right">{{ $data->quantity }}</td>
                                        <td style="text-align: right">
                                            {{ number_format($data->unit_price, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $total = $data->quantity * $data->unit_price;
                                                $sum_total[] = $total;
                                                echo number_format($data->unit_price, 2, '.', ',');
                                            @endphp
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td style="font-size:11px;">[<span
                                                style="color:green">{{ $data->sku->sku_code }}</span>] -
                                            {{ $data->sku->description }}
                                        </td>
                                        <td style="text-align: right">
                                            {{ $data->quantity }}
                                            {{-- @php
                                        $sum_quantity[] = $data->quantity;
                                    @endphp --}}
                                        </td>
                                        <td style="text-align: right">
                                            {{ number_format($data->unit_price, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $total = $data->quantity * $data->unit_price;
                                                $sum_total[] = $total;
                                                echo number_format($total, 2, '.', ',');
                                            @endphp
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="1">Total</th>
                            <th style="text-align: right"></th>
                            <th></th>
                            <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <table class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Desc</th>
                        <th>QTY</th>
                        <th>U/P</th>
                        <th>Sub-Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $data)
                        <tr>
                            <td style="font-size:11px;">[<span
                                    style="color:green">{{ $data->associatedModel->sku->sku_code }}</span>] -
                                {{ $data->associatedModel->sku->description }}</td>
                            <td style="text-align: right">
                                {{ $data->quantity }}
                                @php
                                    $sum_cart_quantity[] = $data->quantity;
                                @endphp
                            </td>
                            <td style="text-align: right">{{ number_format($data->price, 2, '.', ',') }}
                            </td>
                            <td style="text-align: right">
                                @php
                                    $cart_total = $data->quantity * $data->price;
                                    $sum_cart_total[] = $cart_total;
                                    echo number_format($cart_total, 2, '.', ',');
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="1">Total</th>
                        <th style="text-align: right"></th>
                        <th></th>
                        <th style="text-align: right">{{ number_format(array_sum($sum_cart_total), 2, '.', ',') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <input type="hidden" value="{{ $type }}" name="type">
    <input type="hidden" value="{{ $id }}" name="id">

    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>
<script>
    $("#warehouse_pcm_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "warehouse_pcm_save",
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
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                location.reload();
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
