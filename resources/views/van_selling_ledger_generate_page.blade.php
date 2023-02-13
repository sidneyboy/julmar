<div class="table table-responsive">
    <table id="table" class="table-sm" data-show-columns="true">
        <thead class="thead-light">
            <tr>
                <th style="text-align: center;">DR</th>
                <th style="text-align: center;">DATE</th>
                <th style="text-align: center;">PRINCIPAL</th>
                <th style="text-align: center;">STORE NAME</th>
                <th style="text-align: center;">TRANSFERED/TERMINATE</th>
                <th style="text-align: center;">NEW VL</th>
                <th style="text-align: center;">COLLECTED</th>
                <th style="text-align: center;">CM</th>
                <th style="text-align: center;">ADJUSTMENTS</th>
                <th style="text-align: center;">RUNNING BALANCE</th>
                <th style="text-align: center;">SHOULD BE</th>
                <th style="text-align: center;">ACTUAL STOCKS ON HAND</th>
                <th style="text-align: center;">CHARGE PYT</th>
                <th style="text-align: center;">(OVER) / SHORT</th>
                <th style="text-align: center;">OUTSTANDING BALANCE</th>
                <th style="text-align: center;">USER</th>
                <th>REMARKS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ar_ledger as $data)
                <tr>
                    <td>
                        @if (is_null($data->van_selling_print_id))
                            {{ 'NONE' }}
                        @else
                            {{ $data->van_selling_printed->delivery_receipt }}
                        @endif
                    </td>
                    <td>{{ $data->date }}</td>
                    <td>
                        @if ($data->collection != 0)
                            COLLECTION
                        @elseif($data->should_be != 0)
                            BEGINNING
                        @elseif($data->actual_stocks_on_hand)
                            ACTUAL STOCKS ON HAND
                        @elseif($data->cm_amount)
                            CREDIT MEMO
                        @elseif($data->clearing)
                            CLEARING (TRANSFER OF STOCKS / TERMINATED / RETURN PREVIEWS)
                        @elseif($data->principal_id != '')
                            {{ $data->principal->principal }}
                        @elseif($data->inventory_adjustments != 0 or $data->inventory_adjustments != '')
                            ACTUAL STOCKS ON HAND EVERY CUT OFF
                        @elseif($data->adjustments != 0 or $data->adjustments != '')
                            ADJUSTMENTS
                        @elseif($data->amount != 0)
                            INVENTORY ADJUSTMENT VAN LOAD
                        @else
                            CHARGE PAYMENT
                        @endif
                    </td>
                    <td>{{ $data->customer->store_name }}</td>
                    <td style="text-align: right;font-weight: bold;">
                        {{ number_format($data->clearing, 2, '.', ',') }}</td>
                    <td style="text-align: right;font-weight: bold;color:green;">
                        {{ number_format($data->amount, 2, '.', ',') }}</td>
                    <td style="text-align: right;font-weight: bold;color:red">
                        {{ number_format($data->collection, 2, '.', ',') }}</td>
                    <td style="text-align: right;font-weight: bold;color:orangered">
                        {{ number_format($data->cm_amount, 2, '.', ',') }}
                    </td>
                    <td style="text-align: right;font-weight: bold;color:darkgoldenrod">
                        {{ number_format($data->adjustments, 2, '.', ',') }}</td>
                    <td style="text-align: right;font-weight: bold;color:blue;">
                        @php
                            $running_balance = $data->running_balance;
                            echo number_format($running_balance, 2, '.', ',');
                        @endphp
                    </td>
                    <td style="text-align: right;font-weight: bold;">
                        {{ number_format($data->should_be, 2, '.', ',') }}</td>
                    <td style="text-align: right;font-weight: bold;color:lightseagreen">
                        {{ number_format($data->actual_stocks_on_hand, 2, '.', ',') }}</td>
                    <td style="text-align: right;font-weight: bold;color:red;">
                        {{ number_format($data->charge_payment, 2, '.', ',') }}</td>
                    <td style="text-align: right;font-weight: bold;">
                        {{ number_format($data->over_short, 2, '.', ',') }}</td>
                    <td style="text-align: right;font-weight: bold;color:blue;">
                        @php
                            $outstanding_balance = $data->outstanding_balance;
                            echo number_format($outstanding_balance, 2, '.', ',');
                        @endphp
                    </td>
                    <td style="text-transform: uppercase;">{{ $data->user->name }}</td>
                    <td>{{ $data->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table><br />
    <!-- Button trigger modal -->
    <button onclick="ExportToExcel('xlsx')" class="btn btn-success float-left">Export table to excel</button>
    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#exampleModal">
        DELETE AGENT AR LEDGER
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADMIN/AUDIT HEAD/OM ACCESS KEY:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="password" id="access_key" class="form-control" required>
                    <input type="hidden" id="customer_id" class="form-control" value="{{ $customer_id }}" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit_to_delete" class="btn btn-primary">Proceed To Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript">
    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('table');
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: "sheet1"
        });
        return dl ?
            XLSX.write(wb, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            }) :
            XLSX.writeFile(wb, fn || ('VS-ARLEDGER.' + (type || 'xlsx')));
    }


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

    $('#submit_to_delete').on('click', function(e) {
        var access_key = $('#access_key').val();
        var customer_id = $('#customer_id').val();
        $('.loading').show();
        $.post({
            type: "POST",
            url: "/van_selling_ledger_delete_agent_data",
            data: 'access_key=' + access_key + '&customer_id=' + customer_id,
            success: function(data) {

                console.log(data);
                if (data == 'no_input') {
                    $('.loading').hide();
                    Swal.fire(
                        'ENTER ACCESS KEY!!',
                        'CANNOT PROCEED!!',
                        'error'
                    )
                } else if (data == 'nothing_to_delete') {
                    $('.loading').hide();
                    Swal.fire(
                        'NOTHING TO DELETE!!',
                        'CANNOT PROCEED!!',
                        'error'
                    )
                } else {
                    $('.loading').hide();
                    location.reload();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>
