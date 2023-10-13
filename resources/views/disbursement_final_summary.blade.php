@if ($disbursement == 'payment to principal')
    <center>
        <h3 style="font-weight: bold;">PRINCIPAL PAYMENT</h3>
    </center><br />
    <form id="disbursement_saved">
        {{-- <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr>
                <th style="text-align: center;text-transform:uppercase">{{ $po_rr }}</th>
                <th colspan="3" style="text-align: center;text-transform:uppercase">{{ $title }}</th>
                <th>{{ date('F j, Y', strtotime($date)) }}</th>
            </tr>
            <tr>
                <th style="text-align: center">PAYEE</th>
                <th style="text-transform: uppercase;text-align:center;" colspan="3">{{ $payee }}</th>
                <th style="text-align: center">AMOUNT PAID</th>
            </tr>
            <tr>
                <th>AMOUNT IN WORDS</th>
                <th style="text-transform:uppercase;" colspan="3">{{ $amount_in_words }}</th>
                <th style="text-align: right">₱ {{ number_format($amount, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th>PARTICULARS</th>
                <th>DEBIT</th>
                <th>AMOUNT</th>
                <th>CREDIT</th>
                <th>AMOUNT</th>
            </tr>
            <tr>
                <th style="text-transform: uppercase">{{ $particulars }}</th>
                <th style="text-transform: uppercase">{{ $debit }}</th>
                <th style="text-align: right">₱ {{ number_format($amount, 2, '.', ',') }}</th>
                <th style="text-transform: uppercase">{{ $credit }}</th>
                <th style="text-align: right">₱ {{ number_format($amount, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th colspan="2"></th>
                <th style="text-align: center;" colspan="2">TOTAL PAYABLE</th>
                <th style="background-color:yellow;text-align:right">₱ {{ number_format($amount, 2, '.', ',') }}</th>
            </tr>
            <tr>
                <th colspan="5" style="text-transform: uppercase">REMARKS: {{ $remarks }}</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th>CHECK #</th>
                <th style="text-align: right">{{ $check_deposit_slip }}</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th>CV #</th>
                <th style="text-align: right">{{ $cv_number }}</th>
            </tr>
        </thead>
    </table> --}}
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <td style="text-align: center">{{ $principal_name->principal }}</td>
                    <th>Date</th>
                    <td style="text-align: center">{{ $date }}</td>
                </tr>
                <tr>
                    <th>PO / RR</th>
                    <td style="text-align: center">{{ $po_rr }}</td>
                    <th>CV No.</th>
                    <td style="text-align: center">{{ $cv_number }}</td>
                </tr>
            </thead>
        </table>

        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th style="text-align: center;">Total PO/RR Amount</th>
                    <th style="text-align: center;">Amount Paid</th>
                    <th style="text-align: center;">Outstanding Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: right">{{ number_format($amount_payable, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($amount, 2, '.', ',') }}</td>
                    <td style="text-align: right">
                        @php
                            $outstanding_balance = $amount_payable - $amount;
                            echo number_format($outstanding_balance, 2, '.', ',');
                        @endphp
                        <input type="hidden" value="{{ $outstanding_balance }}" name="outstanding_balance">
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>

                    <th style="text-align: center;">DR</th>
                    <th style="text-align: center;">CR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">AP -
                        {{ $principal_name->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($amount, 2, '.', ','); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">CASH IN BANK
                        {{ $bank }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($amount, 2, '.', ','); ?></td>
                </tr>
            </tbody>
        </table>

        <input type="hidden" name="disbursement" value="{{ $disbursement }}">
        <input type="hidden" name="po_rr_id" value="{{ $po_rr_id }}">
        <input type="hidden" name="bank" value="{{ $bank }}">
        <input type="hidden" name="check_deposit_slip" value="{{ $check_deposit_slip }}">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="amount_payable" value="{{ $amount_payable }}">
        <input type="hidden" name="outstanding_balance" value="{{ $outstanding_balance }}">
        <input type="hidden" name="cv_number" value="{{ $cv_number }}">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="particulars" value="{{ $particulars }}">
        <input type="hidden" name="cv_number" value="{{ $cv_number }}">
        <input type="hidden" name="principal_id" value="{{ $principal_id }}">


        <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
    </form>

    <script>
        $("#disbursement_saved").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "disbursement_saved",
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
    </center><br />

    <form id="disbursement_saved">
        @csrf
        <table class="table table-bordered table-sm table-striped">
            <tr>
                <th>SALES AGENT</th>
                <th>{{ $sales_invoice[0]->sales_invoice_agent->full_name }}
                    <input type="hidden" name="agent_id" value="{{ $sales_invoice[0]->sales_invoice_agent->id }}">
                </th>
                <th>DATE</th>
                <th>{{ $date }}</th>
            </tr>
            <tr>
                <th>CUSTOMER NAME</th>
                <th>{{ $sales_invoice[0]->sales_invoice_customer->store_name }}</th>
                <th>CHECK REF./CASH</th>
                <th>{{ $check_ref_cash }}
                    <input type="hidden" name="check_ref_cash" value="{{ $check_ref_cash }}">
                </th>
            </tr>
            <tr>
                <th>OFFICIAL RECEIPT NO.</th>
                <th>{{ $official_receipt_no }}
                    <input type="hidden" name="official_receipt_no" value="{{ $official_receipt_no }}">
                </th>
                <th>BANK</th>
                <th>
                    {{ $bank }}
                    <input type="hidden" name="bank" value="{{ $bank }}">
                </th>
            </tr>
            <tr>
                <th colspan="2"></th>
                <th>PAYMENT DATE</th>
                <th>{{ $payment_date }}
                    <input type="hidden" name="payment_date" value="{{ $payment_date }}">
                </th>
            </tr>
        </table>

        <div class="table table-responsive">
            <table class="table table-bordered table-sm table-striped">
                <thead>
                    <tr>
                        <th style="text-align: center">INVOICE NO</th>
                        <th style="text-align: center">PRINCIPAL</th>
                        <th style="text-align: center">A/R BALANCE</th>
                        <th style="text-align: center">AMOUNT COLLECTED</th>
                        <th style="text-align: center">OUTSTANDING BALANCE</th>
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

                                <input type="hidden" name="outstanding_balance[{{ $data->id }}]"
                                    value="{{ $outstanding_balance }}">
                            </td>
                            <td style="text-align:right">
                                @php
                                    $sum_amount_collected[] = $amount_collected[$data->id];
                                    echo number_format($amount_collected[$data->id], 2, '.', ',');
                                @endphp
                                <input type="hidden" name="amount_collected[{{ $data->id }}]"
                                    value="{{ $amount_collected[$data->id] }}">


                            </td>
                            <td style="text-align: right">
                                @php
                                    $new_outstanding_balance = $outstanding_balance - $amount_collected[$data->id];
                                    echo number_format($new_outstanding_balance, 2, '.', ',');
                                @endphp

                                <input type="hidden" name="new_outstanding_balance[{{ $data->id }}]"
                                    value="{{ $new_outstanding_balance }}">

                            </td>
                            <td>
                                {{ $remarks[$data->id] }}
                                <input type="hidden" name="remarks[{{ $data->id }}]"
                                    value="{{ $remarks[$data->id] }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3"></th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_amount_collected), 2, '.', ',') }}
                        </th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <input type="hidden" value="{{ $disbursement }}" name="disbursement">
        <input type="hidden" value="{{ $customer_id }}" name="customer_id">

        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>

                    <th style="text-align: center;">DR</th>
                    <th style="text-align: center;">CR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">CASH IN BANK -
                        {{ $bank }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_amount_collected), 2, '.', ','); ?></td>
                    <td><input type="hidden" name="debit_record" value="{{ array_sum($sum_amount_collected) }}">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">ACCOUNTS RECEIVABLE -
                        {{ $sales_invoice[0]->sales_invoice_customer->store_name }}</td>
                    <td><input type="hidden" name="credit_record" value="{{ array_sum($sum_amount_collected) }}">
                    </td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_amount_collected), 2, '.', ','); ?></td>
                </tr>
            </tbody>
        </table>

        <button class="btn btn-sm float-right btn-success">Submit</button>
    </form>

    <script>
        $("#disbursement_saved").on('submit', (function(e) {
            e.preventDefault();
            $('#loader').show();
            $.ajax({
                url: "disbursement_saved",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#loader').hide();
                    // Swal.fire({
                    //     position: 'top-end',
                    //     icon: 'success',
                    //     title: 'Your work has been saved',
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // });

                    // location.reload();
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
@endif
