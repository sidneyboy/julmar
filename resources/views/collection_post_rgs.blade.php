<center>
    <h3 style="font-weight: bold;">RGS CREDIT MEMO</h3>
</center>
<br />
<form id="collection_post_rgs_final_summary">
    <div class="form-group">
        <select name="cm_id" style="width:100%;" class="form-control select2bs4" required>
            <option value="" default>SELECT RGS CREDIT MEMO</option>
            @foreach ($return_good_stock as $return_good_stock_data)
                <option value="{{ $return_good_stock_data->id }}">
                    {{ str_replace('PCM-RGS-', '', $return_good_stock_data->pcm_number) . ' [₱' . number_format($return_good_stock_data->total_amount, 2, '.', ',') . ']' }}
                </option>
            @endforeach
        </select>
    </div>

    <table class="table table-bordered table-sm table-striped table-hover">
        <thead>
            <th style="text-align: center">INVOICE NO</th>
            <th style="text-align: center">PRINCIPAL</th>
            <th style="text-align: center">BALANCE</th>
            <th style="text-align: center">AGING</th>
            <th style="text-align: center">REMARKS</th>
            <th><input type="checkbox" id="cc" onclick="javascript:checkAll(this)" /></th>
        </thead>
        <tbody>
            @foreach ($sales_invoice as $data)
                <tr>
                    <td>{{ $data->delivery_receipt }}</td>
                    <td>{{ $data->principal->principal }}</td>
                    <td style="text-align: right">
                        @php
                            $outstanding_balance = $data->total - $data->total_returned_amount - $data->total_payment;
                            echo number_format($outstanding_balance, 2, '.', ',');
                        @endphp
                        <input type="hidden" value="{{ round($outstanding_balance, 2) }}"
                            name="outstanding_balance[{{ $data->id }}]">
                    </td>
                    <td style="text-align: center;">
                        @if (!isset($data->delivered))
                            @php
                                $aging = 0;
                            @endphp
                        @else
                            @php
                                $now = time(); // or your date as well
                                $your_date = strtotime($data->delivered_date);
                                $datediff = $now - $your_date;

                                $aging = round($datediff / (60 * 60 * 24));
                            @endphp
                        @endif
                        @if ($aging <= 15)
                            <span style="font-size:14px;" class="badge badge-success">{{ $aging }}</span>
                        @elseif($aging <= 30)
                            <span style="font-size:14px;" class="badge badge-warning">{{ $aging }}</span>
                        @elseif($aging > 30)
                            <span style="font-size:14px;" class="badge badge-danger">{{ $aging }}</span>
                        @endif
                    </td>
                    <td>
                        <input type="text" class="form-control" name="remarks[{{ $data->id }}]">
                    </td>
                    <td>
                        <input type="checkbox" name="sales_invoice_id[]" value="{{ $data->id }}" id="c1" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <input type="hidden" name="agent_id" value="{{ $agent_id }}">
    <input type="hidden" name="customer_id" value="{{ $customer_id }}">

    <button class="btn btn-sm float-right btn-info">Proceed</button>
</form>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    function checkAll(o) {
        var boxes = document.getElementsByTagName("input");
        for (var x = 0; x < boxes.length; x++) {
            var obj = boxes[x];
            if (obj.type == "checkbox") {
                if (obj.name != "check")
                    obj.checked = o.checked;
            }
        }
    }

    $("#collection_post_rgs_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "collection_post_rgs_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                if (data == 'cannot proceed') {
                    Swal.fire(
                        'Cannot Proceed',
                        'One of your collection exceeds the invoice outstanding balance',
                        'error'
                    )
                } else if (data == 'No chart of account') {
                    Swal.fire(
                        'Cannot Proceed',
                        'Please Contact IT Support',
                        'error'
                    )
                } else {
                    $('#collection_final_summary_page').html(data);
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
