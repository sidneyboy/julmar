<form id="van_selling_transfer_inventory_save">
    @csrf
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th style="text-align: center">FROM</th>
                <th style="text-align: center">TRANSFER</th>
                <th style="text-align: center">TO</th>
                <th style="text-align: center">TOTAL AMOUNT</th>
            </tr>
            <tr>
                <th style="text-align: center">{{ $from_store_name }}</th>
                <th style="text-align: center">TRANSFER INVENTORY</th>
                <th style="text-align: center">{{ $to_store_name }}</th>
                <th style="text-align: center">{{ number_format($from_transfered_amount, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th colspan="4" style="text-align: center">
                    Remarks: {{ $remarks }}
                    <input type="hidden" name="remarks" value="{{ $remarks }}">
                </th>
            </tr>
        </thead>
    </table>
    <table id="table" class="table-sm" data-show-columns="true">
        <thead class="thead-light">
            <tr>
                <th colspan="9" style="text-align: center;">INVENTORY TO BE TRANSFERED</th>
            </tr>
            <tr>
                <th>CODE</th>
                <th>DESC</th>
                <th>PRINCIPAL</th>
                <th>TYPE</th>
                <th>BUTAL EQUIVALENT</th>
                <th>UOM</th>
                <th>QTY</th>
                <th>U/P</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($van_selling_transfer->van_selling_transfer_details as $details)
                <tr>
                    <td>
                        {{ $details->sku_code }}
                        <input type="hidden" name="sku_code[]" value="{{ $details->sku_code }}">
                    </td>
                    <td>
                        {{ $details->description }}
                        <input type="hidden" name="description[{{ $details->sku_code }}]"
                            value="{{ $details->description }}">
                    </td>
                    <td>
                        {{ $details->principal }}
                        <input type="hidden" name="principal[{{ $details->sku_code }}]"
                            value="{{ $details->principal }}">
                    </td>
                    <td>
                        {{ $details->sku_type }}
                        <input type="hidden" name="sku_type[{{ $details->sku_code }}]"
                            value="{{ $details->sku_type }}">
                    </td>
                    <td style="text-align: right">
                        {{ $details->butal_equivalent }}
                        <input type="hidden" name="butal_equivalent[{{ $details->sku_code }}]"
                            value="{{ $details->butal_equivalent }}">
                    </td>
                    <td>
                        {{ $details->unit_of_measurement }}
                        <input type="hidden" name="unit_of_measurement[{{ $details->sku_code }}]"
                            value="{{ $details->unit_of_measurement }}">
                    </td>
                    <td style="text-align: right">
                        {{ $details->quantity }}
                        <input type="hidden" name="quantity[{{ $details->sku_code }}]"
                            value="{{ $details->quantity }}">
                    </td>
                    <td style="text-align: right">
                        {{ number_format($details->unit_price, 2, '.', ',') }}
                        <input type="hidden" name="unit_price[{{ $details->sku_code }}]"
                            value="{{ $details->unit_price }}">
                    </td>
                    <td style="text-align: right">
                        @php
                            $total = $details->unit_price * $details->quantity;
                            $sum_total[] = $total;
                            echo number_format($total, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="7" style="text-align: center;">GRAND TOTAL</th>
                <th style="text-align: center">SKU COUNT: {{ count($van_selling_transfer->van_selling_transfer_details) }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
            </tr>
        </tbody>
    </table>
    <input type="hidden" value="{{ $to_customer_id }}" name="to_customer_id">
    <input type="hidden" value="{{ $transfer_id }}" name="transfer_id">
    <input type="hidden" value="{{ $from_store_name }}" name="from_store_name">
    <input type="hidden" value="{{ array_sum($sum_total) }}" name="total_transfer">
    <button type="submit" class="btn btn-block btn-success">SUBMIT TRANSFER OF INVENTORY</button>
</form>

<script>
    $("#van_selling_transfer_inventory_save").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_transfer_inventory_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'saved') {
                    Swal.fire(
                        'TRANSFER OF INVENTORY SUCCESSFUL',
                        'GREATE',
                        'success'
                    )
                    location.reload();
                }
            },
        });
    }));

    var $table = $('#table')

    function buildTable($el, cells, rows) {
        var i
        var j
        var row
        var columns = []
        var data = []

        var classes = $('.toolbar input:checked').next().text()

        $el.bootstrapTable('destroy').bootstrapTable({
            columns: columns,
            data: data,
            showFullscreen: true,
            search: true,
            stickyHeader: true,
            stickyHeaderOffsetLeft: parseInt($('body').css('padding-left'), 10),
            stickyHeaderOffsetRight: parseInt($('body').css('padding-right'), 10),
            theadClasses: classes
        })
    }
    $(function() {
        $('.toolbar input').change(function() {
            buildTable($table, 20, 50)
        })
        buildTable($table, 20, 50)
    })
</script>
