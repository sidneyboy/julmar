        <link rel="stylesheet" href="{{ asset('/adminLte/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('/adminLte/dist/css/adminlte.min.css') }}">
<style type="text/css" media="print">
@page {
size: auto;   /* auto is the initial value */
margin: 10;  /* this affects the margin in the printer settings */
}
</style>
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <br /><br /><br />
    <div class="row">
      <div class="col-12">
        <center>
        <h2 class="page-header">
        <img src="{{ asset('/adminLte/julmar.png') }}" style="width:50px;" alt=""> JULMAR COMMERCIAL. INC,
        </h2>
        <h5>
        St Ignatius St., Brgy. Kauswagan<br />
        Cagayan de Oro City, Misamis Oriental<br>
        TELEPHONE NO: 881-9973 / 09177058232<br>
        </h5><br /><br />
        
        <h4 style="text-align: center;font-weight: bold;">CUSTOMER ACCOUNT <i style="color:green">({{ $select_customer_ledger[0]->principal->principal }})</i></h4>
        </center>
      </div>
      <!-- /.col -->
    </div><br />
    <!-- info row -->
    <div class="row invoice-info" style="width:70%;margin-left: 20%;margin-right: 20%;">
      <div class="col-sm-6 invoice-col">
        <span style="text-transform: uppercase;">Customer Profile </span>
        <address style="text-transform: uppercase;">
          <strong>Credit Line Amount - {{ number_format($select_customer_data->credit_line_amount,2,".",",")  }}</strong><br>
          <strong>Accounts Receivable - {{ number_format($accounts_receivable_end->accounts_receivable_end,2,".",",") }}</strong><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-6 invoice-col">
        <span style="text-transform: uppercase;">Delivery Receipt </span>
        <address style="text-transform: uppercase;">
          <strong>Total Amount - </strong><br /><br />
          <strong>Credit Line Amount - {{ number_format($select_customer_data->credit_line_amount,2,".",",")}}</strong><br>
          <strong>Less: A/R - {{  number_format($accounts_receivable_end->accounts_receivable_end,2,".",",")  }}</strong><br>
          <strong>Maximum New Invoice - 
              @php    
                $maximum_new_invoice = $select_customer_data->credit_line_amount - $accounts_receivable_end->accounts_receivable_end;
                echo number_format($maximum_new_invoice,2,".",",");
              @endphp
          </strong><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-6 invoice-col">
        <span style="text-transform: uppercase;">Accounts Receivable Ledger </span>
        <address style="text-transform: uppercase;">
          @if($select_customer_principal_code != '')
            <strong>Store Code: {{ $select_customer_principal_code->store_code }}</strong><br>
          @else

          @endif
        </address>
      </div>
      
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Table row --><br />
    <div class="row">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th style="text-transform: uppercase;text-align: center;">Store</th>
            <th style="text-transform: uppercase;text-align: center;">Payment ID</th>
            <th style="text-transform: uppercase;text-align: center;">Principal</th>
            <th style="text-transform: uppercase;text-align: center;">DR</th>
            <th style="text-transform: uppercase;text-align: center;">Store Code</th>
            <th style="text-transform: uppercase;text-align: center;">SO #</th>
            <th style="text-transform: uppercase;text-align: center;">Trans Ref #</th>
            <th style="text-transform: uppercase;text-align: center;">AR Prev</th>
            <th style="text-transform: uppercase;text-align: center;">Sales</th>
            <th style="text-transform: uppercase;text-align: center;">Bo</th>
            <th style="text-transform: uppercase;text-align: center;">Rgs</th>
            <th style="text-transform: uppercase;text-align: center;">Adjustments</th>
            <th style="text-transform: uppercase;text-align: center;">Payment</th>
            <th style="text-transform: uppercase;text-align: center;">AR End</th>
            <th style="text-transform: uppercase;text-align: center;">Credit Line Amount</th>
            <th style="text-transform: uppercase;text-align: center;">Update Credit Line Amount</th>
            <th style="text-transform: uppercase;text-align: center;">Balance</th>
          </tr>
        </thead>
        <tbody>
          @foreach($select_customer_ledger as $data)
            <tr>
              <td style="text-align: center;font-weight: bold">
                {{ $data->customer->store_name }}
              </td>
              <td style="text-align: center;font-weight: bold">
                {{ $data->customer->payment_id }}
              </td>
              <td style="text-align: center;font-weight: bold;text-transform: uppercase;">
                {{ $data->principal->principal }}
              </td>
              <td style="text-align: center;font-weight: bold;text-transform: uppercase;">
                {{ $data->delivery_receipt }}
              </td>
              <td style="text-align: center;font-weight: bold;text-transform: uppercase;">
                @if($select_customer_principal_code != '')
                  {{ $select_customer_principal_code->store_code }}
                @else
                  ALL
                @endif
              </td>
              <td style="text-align: center;font-weight: bold">
                {{ $data->sales_order_number }}
              </td>

              <td style="text-align: center;font-weight: bold;text-transform: uppercase;">
                {{ $data->transaction_reference }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->accounts_receivable_previous,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->sales,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->bo,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->rgs,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->adjustments,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->payment,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->accounts_receivable_end,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->credit_line_amount,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->update_credit_line_amount,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold">
                {{ number_format($data->credit_line_balance,2,".",",") }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <br /><br />
    
    {{-- <div class="row invoice-info" style="width:100%;text-align: center;">
      <div class="col-sm-4 invoice-col">
        <span style="">
          Prepared By: <br /><br /><br />
          <u style="font-weight: bold;">{{ $prepared_by }}</u>
        </span>
      </div>
      <div class="col-sm-4 invoice-col">
        <span style="">
          Noted By: <br /><br /><br />
          <u style="font-weight: bold;">AGUSTIN R. HERRERA</u>
          <p>Operations Manager North - Min</p>
        </span>
      </div>
      <div class="col-sm-4 invoice-col">
        <span style="">
          Approved By: <br /><br /><br />
          <u style="font-weight: bold;">JEFFERSON T. LIMCHU</u><br />
          <p>Group Manager</p>
        </span>
      </div>
    </div> --}}
    
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
{{-- <script type="text/javascript">
window.addEventListener("load", window.print());
</script> --}}