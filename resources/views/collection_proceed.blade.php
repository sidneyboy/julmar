<center>
    <h3 style="font-weight: bold;">COLLECTION RECEIPT</h3>
</center>
<br />
<form id="collection_final_summary">
    <table class="table table-bordered table-sm table-striped">
        <tr>
            <th>SALES AGENT</th>
            <th>{{ $sales_invoice[0]->sales_invoice_agent->full_name }}</th>
            <th>DATE</th>
            <th>{{ $date }}</th>
        </tr>
        <tr>
            <th>CUSTOMER NAME</th>
            <th>{{ $sales_invoice[0]->sales_invoice_customer->store_name }}</th>
            <th>CHECK REF./CASH</th>
            <th><input type="text" style="text-transform: uppercase" class="form-control form-control-sm" required
                    name="check_ref_cash"></th>
        </tr>
        <tr>
            <th>OFFICIAL RECEIPT NO.</th>
            <th><input type="text" style="text-transform: uppercase" class="form-control form-control-sm" required
                    name="official_receipt_no"></th>
            <th>BANK</th>
            <th>
                <select name="bank" class="form-control form-control-sm" required style="width:100%;">
                    <option value="" default>Select</option>
                    {{-- <option value="BDO">BDO</option>
                    <option value="BPI">BPI</option>
                    <option value="METRO BANK">METRO BANK</option>
                    <option value="FIRST VALLEY BANK">FIRST VALLEY BANK</option>
                    <option value="OTHERS">OTHERS</option> --}}
                    @foreach ($get_bank->chart_of_accounts_details as $data)
                        <option value="{{ $data->id . '|' . $data->account_name }}">{{ $data->account_name }}</option>
                    @endforeach
                </select>
            </th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th>PAYMENT DATE</th>
            <th><input type="date" class="form-control form-control-sm" name="payment_date" required>
            </th>
        </tr>
    </table>


    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th style="text-align: center">DRIVER</th>
                    <th style="text-align: center">DELIVERED DATE</th>
                    <th style="text-align: center">INVOICE NO</th>
                    <th style="text-align: center">PRINCIPAL</th>
                    <th style="text-align: center">BALANCE</th>
                    <th style="text-align: center">COLLECTION</th>
                    <th style="text-align: center">AGING</th>
                    <th style="text-align: center">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice as $data)
                    <tr>
                        <td>
                            @if (!isset($data->logistics_invoices->logistics_driver))
                                Not yet updated
                            @else
                                {{ $data->logistics_invoices->logistics_driver->driver }}
                            @endif
                        </td>
                        <td>
                            @if (!isset($data->delivered_date))
                                Not yet updated
                            @else
                                {{ $data->delivered_date }}
                            @endif
                        </td>
                        <td>
                            <button value="{{ $data->id }}" name="button"
                                class="btn btn-block btn-sm btn-info show_dr">{{ $data->delivery_receipt }}</button>
                        </td>
                        <td>{{ $data->principal->principal }}</td>
                        <td style="text-align: right">
                            @php
                                $outstanding_balance = $data->total - $data->total_returned_amount - $data->total_payment;
                                echo number_format($outstanding_balance, 2, '.', ',');
                            @endphp
                            <input type="hidden" value="{{ round($outstanding_balance, 2) }}"
                                name="outstanding_balance[{{ $data->id }}]">
                        </td>
                        <td>
                            <input style="text-align: right" type="text"
                                class="form-control form-control-sm amount_collected" min="0"
                                name="amount_collected[{{ $data->id }}]" onkeypress="return isNumberKey(event)">
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
                            <input type="text" class="form-control form-control-sm"
                                name="remarks[{{ $data->id }}]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="collection_sales_invoice_show_copy_page"></div>


    <input type="hidden" value="{{ $disbursement }}" name="disbursement">
    <input type="hidden" value="{{ $customer_id }}" name="customer_id">

    <button class="btn btn-sm float-right btn-info" type="submit">Proceed</button>
</form>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $(".show_dr").click(function() {
        // alert($('.show_dr').val());
        var sales_invoice_id = $(this).val();
        $.post({
            type: "POST",
            url: "/collection_sales_invoice_show_copy",
            data: 'sales_invoice_id=' + sales_invoice_id,
            success: function(data) {
                $('#collection_sales_invoice_show_copy_page').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $("#collection_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "collection_final_summary",
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
