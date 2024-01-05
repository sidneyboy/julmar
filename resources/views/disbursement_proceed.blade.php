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
                    @foreach ($get_bank->chart_of_account_bank as $data)
                        <option value="{{ $data->id . '|' . $data->account_name }}">{{ $data->account_name }}</option>
                    @endforeach
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
        <h3 style="font-weight: bold;">REGISTERED CHART OF ACCOUNTS</h3>
    </center>
    <br />

    <form id="disbursement_final_summary">
        @csrf
        <table class="table table-bordered table-sm table-striped">
            <tr>
                <th>PAYEE</th>
                <td><input style="text-align: center;" type="text" class="form-control form-control-sm"
                        name="payee" required value="Julmar Commercial Inc"></td>
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
                        name="bank" value="{{ $transaction_cash_in_bank->account_name }}" required></td>
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
                        <input type="text" class="form-control form-control-sm" name="date_range"
                            id="reservation">
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-group">
            <a id="btn" class="btn float-right btn-danger btn-sm" onclick="removeRow()"
                style="margin-left:10px"> Remove Row </a>
            <a id="btn" class="btn float-right btn-warning btn-sm" onclick="addRow()"> Add Row </a>
        </div>
        <div class="table table-responsive">
            <br />
            <table class="table table-bordered table-hover table-striped table-sm" id="myTable">
                <thead>
                    <tr>
                        <th style="text-align: center;">ACCOUNT NAME</th>
                        <th style="text-align: center;">DR AMOUNT</th>
                        <th style="text-align: center;">CR AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction_entry as $data)
                        <tr>
                            <td>{{ $data->account_name }}
                                <input type="hidden" name="id[]" value="{{ $data->id }}">
                                <input type="hidden" value="{{ $data->account_name }}" name="account_name[]">
                            </td>
                            <td><input style="text-align: center;" type="text" value="0" min="0"
                                    class="form-control form-control-sm" onkeypress="return isNumberKey(event)"
                                    name="debit_record[]"></td>
                            <td><input style="text-align: center;" value="0" min="0" type="text"
                                    onkeypress="return isNumberKey(event)" class="form-control form-control-sm"
                                    name="credit_record[]">
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            {{ $transaction_cash_in_bank->account_name }}
                            <input type="hidden" value="{{ $transaction_cash_in_bank->account_name }}"
                                name="account_name[]">
                            <input type="hidden" name="id[]" value="{{ $transaction_cash_in_bank->id }}">
                        </td>
                        <td><input style="text-align: center;" type="text" value="0" min="0"
                                class="form-control form-control-sm" onkeypress="return isNumberKey(event)"
                                name="debit_record[]"></td>
                        <td><input style="text-align: center;" type="text" value="0" min="0"
                                onkeypress="return isNumberKey(event)" class="form-control form-control-sm"
                                name="credit_record[]">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="hidden" value="{{ $description }}" name="description">
        <input type="hidden" value="{{ $disbursement }}" name="disbursement">
        <button class="btn float-right btn-sm btn-info">Proceed</button>
    </form>

    <script>
        $('#reservation').daterangepicker()

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

        function removeRow() {
            document.getElementById("myTable").deleteRow(1);
        }

        function addRow() {
            const jsonData = {!! json_encode($transaction_insert_entry) !!};

            var table = document.getElementById("myTable");
            var row = table.insertRow(1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);


            var selectBox = document.createElement("select");
            selectBox.classList.add("form-control", "form-control-sm");
            selectBox.name = "new_account_name[]";
            for (var i = 0; i < jsonData.length; i++) {
                var option = document.createElement("option");
                option.value = jsonData[i].id;
                option.text = jsonData[i].account_name;
                selectBox.add(option);
            }
            cell1.appendChild(selectBox);



            cell2.innerHTML =
                "<input style='text-align: center;' value='0' class='form-control form-control-sm' onkeypress='return isNumberKey(event)' name='new_debit_record[]'>";
            cell3.innerHTML =
                "<input style='text-align: center;' value='0' class='form-control form-control-sm' onkeypress='return isNumberKey(event)' name='new_credit_record[]'>";
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;


            return true;
        }
    </script>
@elseif($disbursement == 'unidentified_chart_of_account')
    <center>
        <h3 style="font-weight: bold;">OTHERS</h3>
    </center>
    <br />

    <form id="disbursement_final_summary">
        @csrf
        <table class="table table-bordered table-sm table-striped">
            <tr>
                <th>PAYEE</th>
                <td><input style="text-align: center;" type="text" class="form-control form-control-sm"
                        name="payee" required value="Julmar Commercial Inc"></td>
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
                <td style="text-align: center;">Others</td>
                <th>BANK</th>
                <td><input style="text-align: center;" type="text" class="form-control form-control-sm"
                        name="bank" value="{{ $transaction_cash_in_bank->account_name }}" required></td>
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
                        <input type="text" class="form-control form-control-sm" name="date_range"
                            id="reservation">
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-group">
            <a id="btn" class="btn float-right btn-danger btn-sm" onclick="removeRow()"
                style="margin-left:10px"> Remove Row </a>
            <a id="btn" class="btn float-right btn-warning btn-sm" onclick="addRow()"> Add Row </a>
        </div>
        <br /><br />
        <div class='table table-responsive'>
            <table class="table table-bordered table-hover table-striped table-sm" id="myTable">
                <thead>
                    <tr>
                        <th style="text-align: center;">ACCOUNT NAME</th>
                        <th style="text-align: center;">DR AMOUNT</th>
                        <th style="text-align: center;">CR AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </form>

    <script>
        $('#reservation').daterangepicker()

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

        function removeRow() {
            document.getElementById("myTable").deleteRow(1);
        }

        function addRow() {

            var table = document.getElementById("myTable");
            var row = table.insertRow(1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);


            cell1.innerHTML =
                "<input style='text-align: center;' class='form-control form-control-sm' onkeypress='return isNumberKey(event)' name='account_name[]'>";
            cell2.innerHTML =
                "<input style='text-align: center;' value='0' class='form-control form-control-sm' onkeypress='return isNumberKey(event)' name='new_debit_record[]'>";
            cell3.innerHTML =
                "<input style='text-align: center;' value='0' class='form-control form-control-sm' onkeypress='return isNumberKey(event)' name='new_credit_record[]'>";
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;


            return true;
        }
    </script>
@endif
