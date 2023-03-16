<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th></th>
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
            <th style="text-align: right">₱ {{ number_format($amount,2,".",",") }}</th>
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
            <th style="text-align: right">₱ {{ number_format($amount,2,".",",") }}</th>
            <th style="text-transform: uppercase">{{ $credit }}</th>
            <th style="text-align: right">₱ {{ number_format($amount,2,".",",") }}</th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th style="text-align: center;" colspan="2">TOTAL PAYABLE</th>
            <th style="background-color:yellow;text-align:right">₱ {{ number_format($amount,2,".",",") }}</th>
        </tr>
        <tr>
            <th colspan="5" style="text-transform: uppercase">REMARKS: {{ $remarks }}</th>
        </tr>
        <tr>
            <th colspan="3"></th>
            <th>CHECK #</th>
            <th>{{ $check_deposit_slip }}</th>
        </tr>
        <tr>
            <th colspan="3"></th>
            <th>CV #</th>
            <th>{{ $cv_number }}</th>
        </tr>
    </thead>
</table>