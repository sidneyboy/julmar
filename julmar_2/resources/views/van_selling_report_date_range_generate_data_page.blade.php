<form id="van_selling_report_date_range_generate_sku_movement">
    @csrf
    <div class="table table-responsive">
        <table id="table" class="table-sm" data-show-columns="true">
            <thead class="thead-light">
                <tr>
                    <th>PRINCIPAL</th>
                    <th>CODE</th>
                    <th>DESCRIPTION</th>
                    <th>REFERENCE</th>
                    <th>BUTAL EQUIVALENT</th>
                    <th>QTY CASE</th>
                    <th>SKU TYPE</th>
                    <th>BEG</th>
                    <th>T - VAN LOAD</th>
                    <th>T - SALES</th>
                    <th>INVENTORY ADJUSTMENTS</th>
                    <th>TOTAL PCM</th>
                    <th>END</th>
                    <th>U/P</th>
                    <th>RUNNING BALANCE</th>
                    <th>
                        <label for="car">CHECK</label>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (count($van_selling_ledger) != 0)
                    @foreach ($van_selling_ledger as $key => $data)
                        <tr>
                            <td>{{ $data->principal }}</td>
                            <td>
                                <a href="{{ url('van_selling_report_date_range_itemized',$data->sku_code . ',' . $customer_id . ',' . $date_from . ',' . $date_to) }}"
                                    target="_blank">{{ $data->sku_code }}</a>
                                <input type="hidden" name="sku_code" value="{{ $data->sku_code }}">
                                <input type="hidden" name="sku_code_for_movement[]" value="{{ $data->sku_code }}">
                                <input type="hidden" name="van_selling_upload_ledger_id"
                                    value="{{ $van_selling_ledger_latest_id[$data->sku_code] }}">
                            </td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->reference }}</td>
                            <td>{{ $data->butal_equivalent }}</td>
                            <td>
                                @if ($data->principal == 'EPI')
                                    NO BUTAL EQUIVALENT
                                @else
                                    {{ number_format(($data->beg + $data->total_van_load - $data->total_sales) / $data->butal_equivalent,2,'.',',') }}
                                @endif
                            </td>
                            <td>{{ $data->sku_type }}</td>
                            <td style="text-align: right">{{ $data->beg }}</td>
                            <td style="text-align: right">{{ $data->total_van_load }}</td>
                            <td style="text-align: right">({{ $data->total_sales }})</td>
                            <td style="text-align: right">
                                @if ($data->total_inventory_adjustments < 0)
                                    ({{ $data->total_inventory_adjustments }})
                                @else
                                    {{ $data->total_inventory_adjustments }}
                                @endif
                            </td>
                            <td style="text-align: right">{{ $data->total_pcm }}</td>
                            <td style="text-align: right">{{ $ending_balance[$data->sku_code] }}</td>
                            <td style="text-align: right;">{{ $unit_price[$data->sku_code] }}</td>
                            <td style="text-align: right;">
                                @php
                                    echo $total_sum = $ending_balance[$data->sku_code] * $unit_price[$data->sku_code];
                                    $total_running_balance[] = $total_sum;
                                @endphp
                            </td>
                            <td>
                                @if ($ending_balance[$data->sku_code] != 0)
                                    <input type="checkbox" name="sku_code_for_transfer_per_sku" class="form-control"
                                        value="{{ $van_selling_ledger_latest_id[$data->sku_code] }}">
                                @else
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    @php
                        $total_running_balance[] = 0;
                    @endphp
                @endif
                <tr>
                    <th style="text-align: center;">TOTAL INVENTORY AMOUNT</th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                    <th style="text-align: right;">{{ round(array_sum($total_running_balance), 2) }}</th>
                    <th colspan="" rowspan="" headers="" scope=""></th>
                </tr>
            </tbody>
        </table>
    </div>
    @if (count($van_selling_ledger) != 0)
        <div class="row">
            <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer_id }}">
            <input type="hidden" value="{{ $date_from }}" id="date_from" name="date_from">
            <input type="hidden" value="{{ $date_to }}" id="date_to" name="date_from">
            <input type="hidden" value="{{ array_sum($total_running_balance) }}" id="inventory_total_sum">
            <div class="col-md-3">
                <button type="submit" class="btn btn-success btn-block">EXPORT DATA AND MOVE SKU PER CUT OFF</button>
                <button type="button" id="click_if_trigger" style="display: none;" class="btn btn-info btn-block"
                    onclick="exportTableToCSV('{{ $store_name }} INVENTORY REPORT {{ $date_from }} TO {{ $date_to }}.csv')">{{ $store_name }}</button>
            </div>
            <div class="col-md-3">
                <button type="button" id="van_selling_report_date_range_generate_clearing"
                    class="btn btn-primary btn-block">TRANSFER WHOLE INVENTORY</button>
            </div>
            <div class="col-md-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" style="width:100%;" data-toggle="modal"
                    data-target="#exampleModal">
                    TRANSFER INVENTORY PER PRINCIPAL
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">SELECT SKU PRINCIPAL</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <select name="principal" id="principal" class="form-control select2">
                                    <option value="" default>SELECT</option>
                                    @foreach ($principal as $data)
                                        <option value="{{ $data->principal }}">{{ $data->principal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" id="van_selling_report_date_range_generate_clearing_per_principal"
                                    class="btn btn-info">PROCEED</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <button type="button" id="van_selling_report_date_range_generate_clearing_per_sku"
                    class="btn btn-warning btn-block">TRANSFER INVENTORY PER SKU</button>
            </div>
        </div>
    @endif
</form>

<script>
    $('.select2').select2()

    $("#van_selling_report_date_range_generate_clearing").on('click', (function(e) {
        e.preventDefault();
        $('.loading').show();
        var date_from = $('#date_from').val();
        var van_selling_upload_ledger_id = $('input[name=van_selling_upload_ledger_id]').map(function() {
            return this.value;
        }).get();
        var date_to = $('#date_to').val();
        var customer_id = $('#customer_id').val();

        $.ajax({
            url: "van_selling_report_date_range_generate_clearing",
            type: "POST",
            data: 'date_from=' + date_from + '&date_to=' + date_to + '&customer_id=' + customer_id +
                '&van_selling_upload_ledger_id=' + van_selling_upload_ledger_id,
            success: function(data) {
                if (data == 'no_sda') {
                    Swal.fire(
                      'NO SDA LEDGER DATA FOUND',
                      'CANNOT PROCEED!!',
                      'error'
                      )
                      $('.loading').hide(); 
                }else{
                    $('.loading').hide();
                    $('#van_selling_report_date_range_itemized_page').show();
                    $('#van_selling_report_date_range_itemized_page').html(data);
                }
                
            },
        });
    }));

    $("#van_selling_report_date_range_generate_clearing_per_principal").on('click', (function(e) {
        e.preventDefault();
        $('#exampleModal').modal('toggle'); //or  $('#IDModal').modal('hide');
        // return false;
        $('.loading').show();
        var date_from = $('#date_from').val();
        var van_selling_upload_ledger_id = $('input[name=van_selling_upload_ledger_id]').map(function() {
            return this.value;
        }).get();
        var date_to = $('#date_to').val();
        var customer_id = $('#customer_id').val();
        var principal = $('#principal').val();

        $.ajax({
            url: "van_selling_report_date_range_generate_clearing_per_principal",
            type: "POST",
            data: 'date_from=' + date_from + '&date_to=' + date_to + '&customer_id=' + customer_id +
                '&van_selling_upload_ledger_id=' + van_selling_upload_ledger_id +
                '&principal=' + principal,
            success: function(data) {
                if (data == 'no_sda') {
                    Swal.fire(
                      'NO SDA LEDGER DATA FOUND',
                      'CANNOT PROCEED!!',
                      'error'
                      )
                      $('.loading').hide(); 
                }else{
                    $('.loading').hide();
                    $('#van_selling_report_date_range_itemized_page').show();
                    $('#van_selling_report_date_range_itemized_page').html(data);
                }
            },
        });
    }));

    $("#van_selling_report_date_range_generate_clearing_per_sku").on('click', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var customer_id = $('#customer_id').val();
        var sku_code_for_transfer_per_sku = [];
        $("input:checkbox[name='sku_code_for_transfer_per_sku']:checked").each(function() {
            sku_code_for_transfer_per_sku.push($(this).val());
        });


        $.ajax({
            url: "van_selling_report_date_range_generate_clearing_per_sku",
            type: "POST",
            data: 'date_from=' + date_from + '&date_to=' + date_to + '&customer_id=' + customer_id +
                '&sku_code_for_transfer_per_sku=' + sku_code_for_transfer_per_sku,
            success: function(data) {
                 if (data == 'no_sda') {
                    Swal.fire(
                      'NO SDA LEDGER DATA FOUND',
                      'CANNOT PROCEED!!',
                      'error'
                      )
                      $('.loading').hide(); 
                }else if(data == 'checkbox_error'){
                    Swal.fire(
                      'SELECT SKU FIRST. CLICK CHECKBOX',
                      'CANNOT PROCEED!!',
                      'error'
                      )
                      $('.loading').hide(); 
                }else{
                    $('.loading').hide();
                    $('#van_selling_report_date_range_itemized_page').show();
                    $('#van_selling_report_date_range_itemized_page').html(data);
                }
            },
        });
    }));


    $("#example1").DataTable();
    $('#example2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });

    $("#van_selling_report_date_range_generate_sku_movement").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "van_selling_report_date_range_generate_sku_movement",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                // if (data == 'saved') {
                    
                // }

                Swal.fire(
                        'INVENTORY MOVEMENT SUCCESSFUL',
                        '',
                        'success'
                    );
                    $('.loading').hide();
                    $('#click_if_trigger').click();
            },
        });
    }));

    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {
            type: "text/csv"
        });

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }

    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("#table tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push(cols[j].innerText);

            csv.push(row.join(","));
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
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
</script>
