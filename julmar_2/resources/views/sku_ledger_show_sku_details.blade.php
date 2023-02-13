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
    <div class="row">
      <div class="col-12">
        <center>
        <h2 class="page-header">
         JULMAR COMMERCIAL. INC,
        </h2>
        </center>
      </div>
      <!-- /.col -->
    </div><br />
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col">
        <center>
        <h5><span style="font-weight: bold;color:blue">{{ $date_from }}</span> to <span style="font-weight: bold;color:blue">{{ $date_to }}</span></h5>
      </div>
    </div>
    <div class="row">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th style="text-align: center;">CODE</th>
            <th style="text-align: center;">DESCRIPTION</th>
            <th style="text-align: center;">IN<br />OUT<br />ADJUSTMENTS</th>
            <th style="text-align: center;">RR<br />DR</th>
            <th style="text-align: center;">SALES<br />ORDER<br />NUMBER</th>
            <th style="text-align: center;">PRINCIPAL<br />INVOICE</th>
            <th style="text-align: center;">QUANTITY</th>
            <th style="text-align: center;">RUNNING<br />BALANCE</th>
            <th style="text-align: center;">UNIT<br />COST</th>
            <th style="text-align: center;">TOTAL<br />COST</th>
            <th style="text-align: center;">ADJUST<br />MENTS</th>
            <th style="text-align: center;">RUNNING<br />TOTAL<br />COST</th>
            <th style="text-align: center;">FINAL<br />UNIT<br />COST</th>
            <th style="text-align: center;">TRANSACTION<br />DATE</th>
            <th style="text-align: center;">TRANSACTED<br />BY</th>
          </tr>
        </thead>
        <tbody>
          @if($counter == 0)
            <tr>
              <td colspan="15" style="color:red;text-align: center;font-webold;">NO TRANSACTION FOUND ON THE SELECTED DATE RANGE</td>
            </tr>
          @else
            @foreach($sku_ledger_details as $data)
              <tr>
                <td style="text-align: center;text-transform: uppercase;">{{ $data->sku->sku_code }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $data->sku->description }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $data->in_out_adjustments }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $data->rr_dr }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $data->sales_order_number }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $data->principal_invoice }}</td>
                <td style="text-align: center;">{{ $data->quantity }}</td>
                <td style="text-align: center;">{{ $data->running_balance }}</td>
                <td style="text-align: right;">{{ number_format($data->unit_cost,2,".",",") }}</td>
                <td style="text-align: right;">{{ number_format($data->total_cost,2,".",",") }}</td>
                <td style="text-align: right;">{{ number_format($data->adjustments,2,".",",") }}</td>
                <td style="text-align: right;">{{ number_format($data->running_total_cost,2,".",",") }}</td>
                <td style="text-align: right;">{{ $data->final_unit_cost }}</td>
                <td style="text-align: center;">{{ $data->transaction_date }}</td>
                <td style="text-align: center;">{{ $data->user->name }}</td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
    <!-- /.row -->
    <br /><br />
    
    {{-- <div class="row invoice-info" style="width:100%;text-align: center;">
      <div class="col-sm-6 invoice-col">
        <span style="text-align: center;">
          Purchased By: <br />
          <u style="font-weight: bold;"></u>
        </span>
      </div>
      <div class="col-sm-6 invoice-col">
        <span style="text-align: center;">
          Prepared By:<br />
          <u style="font-weight: bold;"> {{ $prepared_by->name }}</u>
        </span>
      </div>
    </div>
    <div class="row invoice-info" style="width:100%;text-align: center;">
      <div class="col-sm-12 invoice-col">
        <span style="text-align: center;">
          Date: <br />
          <u style="font-weight: bold;">
          {{ $date }}
          </u>
        </span>
      </div>
    </div> --}}
    
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
window.addEventListener("load", window.print());
</script>