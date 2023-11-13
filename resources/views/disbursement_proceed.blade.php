@if ($disbursement == 'payment to principal')
    <center>
        <h3 style="font-weight: bold;">PRINCIPAL PAYMENT</h3>
    </center>
    <br />
    <form id="disbursement_final_summary">
        <div class="row">
            <div class="col-md-3">
                <label for="">Purchase Order / RR</label>
                <select name="po_rr_id" id="po_rr_id" class="form-control select2bs4" required style="width:100%;">
                    <option value="" default>Select</option>
                    <option value="others-migration">Direct to AP</option>
                    {{-- @foreach ($purchase_order_unpaid as $purchase_order_unpaid_data)
                        <option
                            value="PO - {{ $purchase_order_unpaid_data->id }} | {{ $purchase_order_unpaid_data->purchase_id }}">
                            PO - {{ $purchase_order_unpaid_data->purchase_id }}</option>
                    @endforeach --}}
                    @foreach ($receive_purchase_order_unpaid as $receive_purchase_order_unpaid_data)
                        <option
                            value="RR - {{ $receive_purchase_order_unpaid_data->id }} | {{ $receive_purchase_order_unpaid_data->id }}">
                            RR - {{ $receive_purchase_order_unpaid_data->id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-9">
                <div id="show_po_rr_payable_page"></div>
            </div>
            <div class="col-md-3">
                <label for="">Check/Deposit #</label>
                <input type="text" class="form-control" name="check_deposit_slip" required>
            </div>
            <div class="col-md-3">
                <label for="">CV #</label>
                <input type="text" class="form-control" required name="cv_number" required>
            </div>
            <div class="col-md-3">
                <label for="">Bank</label>
                <select name="bank" class="form-control" required style="width:100%;">
                    <option value="" default>Select</option>
                    <option value="BDO">BDO</option>
                    <option value="BPI">BPI</option>
                    <option value="METRO BANK">METRO BANK</option>
                    <option value="FIRST VALLEY BANK">FIRST VALLEY BANK</option>
                    <option value="OTHERS">OTHERS</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Particulars</label>
                <input type="text" class="form-control" required name="particulars" required>
            </div>
        </div>
        <br />
        <input type="hidden" value="{{ $ewt }}" id="ewt" name="ewt">
        <input type="hidden" value="{{ $disbursement }}" name="disbursement">
        <input type="hidden" value="{{ $principal_id }}" name="principal_id" id="principal_id">
        <button class="btn btn-sm btn-info float-right">Final Summary</button>
    </form>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        $("#po_rr_id").change(function() {
            var po_rr_id = $(this).val();
            var principal_id = $('#principal_id').val();
            var ewt = $('#ewt').val();
            $.post({
                type: "POST",
                url: "/disbursement_show_po_rr_payable",
                data: 'po_rr_id=' + po_rr_id + '&principal_id=' + principal_id + '&ewt=' + ewt,
                success: function(data) {
                    $('#loader').hide();
                    $('#show_po_rr_payable_page').html(data);

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $("#disbursement_final_summary").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "disbursement_final_summary",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#disbursement_final_summary_page').html(data);
                    $('#loader').hide();
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
@elseif($disbursement == 'collection')
    <center>
        <h3 style="font-weight: bold;">COLLECTION RECEIPT</h3>
    </center>
    <br />
    <form id="disbursement_final_summary">
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
                <th><input type="text" style="text-transform: uppercase" class="form-control form-control-sm"
                        required name="check_ref_cash"></th>
            </tr>
            <tr>
                <th>OFFICIAL RECEIPT NO.</th>
                <th><input type="text" style="text-transform: uppercase" class="form-control form-control-sm"
                        required name="official_receipt_no"></th>
                <th>BANK</th>
                <th>
                    <select name="bank" class="form-control form-control-sm" required style="width:100%;">
                        <option value="" default>Select</option>
                        <option value="BDO">BDO</option>
                        <option value="BPI">BPI</option>
                        <option value="METRO BANK">METRO BANK</option>
                        <option value="FIRST VALLEY BANK">FIRST VALLEY BANK</option>
                        <option value="OTHERS">OTHERS</option>
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


        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th style="text-align: center">INVOICE NO</th>
                    <th style="text-align: center">PRINCIPAL</th>
                    <th style="text-align: center">A/R BALANCE</th>
                    <th style="text-align: center">AMOUNT COLLECTED</th>
                    <th style="text-align: center">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice as $data)
                    <tr>
                        <td>{{ $data->delivery_receipt }}</td>
                        <td>{{ $data->principal->principal }}</td>
                        <td style="text-align: right">
                            @php
                                $outstanding_balance = $data->total - $data->total_payment;
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
                        <td>
                            <input type="text" class="form-control form-control-sm"
                                name="remarks[{{ $data->id }}]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

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

        $("#disbursement_final_summary").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "disbursement_final_summary",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data == 'cannot proceed') {
                        $('#loader').hide();
                        Swal.fire(
                            'Cannot Proceed',
                            'One of your collection exceeds the invoice outstanding balance',
                            'error'
                        )
                    } else {
                        $('#disbursement_final_summary_page').html(data);
                        $('#loader').hide();
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
@elseif($disbursement == 'others')
    <center>
        <h3 style="font-weight: bold;">OTHERS</h3>
    </center>
    <br />

    <table class="table table-bordered table-sm table-striped">
        <tr>
            <th>PAYEE</th>
            <td><input style="text-align: center;" type="text" class="form-control form-control-sm"
                    name="payee" required></td>
            <th>DATE</th>
            <td style="text-align: center;">{{ $date }}</td>
        </tr>
        <tr>
            <th>INVOICE NO/REF</th>
            <td><input style="text-align: center;" type="text" class="form-control form-control-sm"
                    name="invoice_no_ref" required></td>
            <th>CHECK REF/CASH</th>
            <td><input style="text-align: center;" type="text" class="form-control form-control-sm"
                    name="check_ref_cash" required></td>
        </tr>
        <tr>
            <th>DESCRIPTION</th>
            <td style="text-align: center;">{{ $description }}</td>
            <th>BANK</th>
            <td><input style="text-align: center;" type="text" class="form-control form-control-sm"
                    name="bank" required></td>
        </tr>
        <tr>
            <th>PERIOD</th>
            <td colspan="3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control form-control-sm" name="date_range" id="reservation">
                </div>
            </td>
        </tr>
    </table>

    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead>
                <tr>
                    <th style="text-align: center;">ACCOUNT NAME</th>
                    <th style="text-align: center;">ACCOUNT CODE</th>
                    <th style="text-align: center;">DR AMOUNT</th>
                    <th style="text-align: center;">CR AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction_entry as $data)
                    <tr>
                        <td>{{ $data->account_name }}</td>
                        <td></td>
                        <td><input type="text" onkeypress="return isNumberKey(event)"
                                class="form-control form-control-sm" name="debit_record[{{ $data->id }}]"></td>
                        <td><input type="text" onkeypress="return isNumberKey(event)"
                                class="form-control form-control-sm" name="credit_record[{{ $data->id }}]"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $('#reservation').daterangepicker()

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
@endif
