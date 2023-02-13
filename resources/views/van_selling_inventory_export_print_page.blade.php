<!DOCTYPE html>
<html>
<link rel="stylesheet" href="{{ asset('/adminLte/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('/adminLte/dist/css/adminlte.min.css') }}">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<head>
<style type="text/css">
/* Styles go here */

.page-header, .page-header-space {
  height: 315px;
}

.page-footer, .page-footer-space {
  height: 170px;

}

.page-footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  border-top: 1px solid black; /* for demo */
  background: yellow; /* for demo */
}

.page-header {
  position: fixed;
  top: 0mm;
  width: 100%;
  border-bottom: 1px solid black; /* for demo */
  background: yellow; /* for demo */
}

.page {
  page-break-after: always;
}

@page {
  margin: 20mm
}

@media print {
   thead {display: table-header-group;} 
   tfoot {display: table-footer-group;}
   
   button {display: none;}
   
   body {margin: 0;}
}
</style>
</head>

<body  onload="myFunction()">

<div class="page-header">
  <center>
  <h4 style="font-weight: bold;">JULMAR COMMERCIAL INC.</h4>
  <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
  <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
  </center>
  <br />
  <h5 style="text-align: center;font-weight: bold;">Delivery Receipt</h5>
  <table class="table table-borderless" style="border:none;"> {{-- class='table table-borderless' --}}
    <thead>
      <tr>
        <th  style="width:20%;line-height:0px"><span class="float-right">Bill To:</span></th>
        <th  style="width:30%;line-height:0px;text-transform: uppercase;">{{ $van_selling->customer->store_name }}</th>
        <th  style="width:20%;line-height:0px"><span class="float-right">Dr Number:</span></th>
        <th  style="width:30%;line-height:0px">{{ $van_selling->delivery_receipt }}</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="line-height:0px;"><span class="float-right">Store Code:</span></td>
        <td style="line-height:0px;">{{ $customer_principal_code->store_code }}</td>
        <td style="line-height:0px;"><span class="float-right">DR Date :</span></td>
        <td style="line-height:0px;">{{ $van_selling->date }}</td>
      </tr>
      <tr>
        <td style="line-height:0px;"><span class="float-right">Address:</span></td>
        <td style="line-height:0px;">{{ $van_selling->customer->detailed_location  }}</td>
        <td style="line-height:0px;"><span class="float-right">SO No:</span></td>
        <td style="line-height:0px;">{{ $van_selling->sales_order_number }}</td>
      </tr>
      <tr>
        <td style="line-height:0px;"><span class="float-right">Area:</span></td>
        <td style="line-height:0px;">{{ $van_selling->customer->location->location }}</td>
        <td style="line-height:0px;"><span class="float-right">CUSTOMER PO NO::</span></td>
        <td style="line-height:0px;">N/a</td>
      </tr>
      <tr>
        <td style="line-height:0px;"><span class="float-right">Transaction:</span></td>
        <td style="line-height:0px;">{{ $van_selling->mode_of_transaction }}
        </td>
       {{--  <td style="line-height:0px;"><span class="float-right">Salesman:</span></td>
        <td style="line-height:0px;">{{ $agent->full_name}}</td> --}}
      </tr>
      <tr>
        <td style="line-height:0px;"></td>
        <td style="line-height:0px;"></td>
        <td style="line-height:0px;"><span class="float-right">Payment Terms:</span></td>
        <td style="line-height:0px;">{{ $van_selling->customer->credit_term }}</td>
      </tr>
      <tr>
        <td style="line-height:0px;"></td>
        <td style="line-height:0px;"></td>
        <td style="line-height:0px;"><span class="float-right">Due Date:</span></td>
        <td style="line-height:0px;">{{ date('Y-m-d', strtotime($van_selling->date. ' + '. $van_selling->customer->credit_term)) }}</td>
      </tr>
    </tbody>
  </table>
</div>



  <table class="table"  style="width:100%;">
   <thead>
      <tr>
        <td colspan="2">
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
   </thead>
   <tbody>
      <tr>
		<th style="text-align: center;">CODE</th>
		<th style="text-align: center;">DESCRIPTION</th>
		<th style="text-align: center;">UOM</th>
		<th style="text-align: center;">FINAL QUANTITY</th>
		<th style="text-align: center;">PRICE</th>
		<th style="text-align: center;">SUB-TOTAL</th>
      </tr>
		@foreach($van_selling->van_selling_printed_details as $data)
		<tr>
			<td>{{ $data->sku->sku_code }}</td>
			<td>{{ $data->sku->description }}</td>
			<td>{{ $data->sku->unit_of_measurement }}</td>
			<td style="text-align: right;">{{ $data->quantity }}</td>
			<td style="text-align: right;">{{ number_format($data->price,2,".",",") }}</td>
			<td style="text-align: right;">
				@php
				$sum_sub_total[] = $data->amount_per_sku;
				echo number_format($data->amount_per_sku,2,".",",");
				@endphp
			</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="5" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
			<td style="text-align: right">
				@php
				echo number_format(array_sum($sum_sub_total),2,".",",");
				@endphp
			</td>
		</tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <!--place holder for the fixed-position footer-->
          <div class="page-footer-space"></div>
        </td>
      </tr>
    </tfoot>
  </table>




  <div class="page-footer">
      <div class="container float-left" style="width:50%;" >
        RECEIVED FROM JULMAR COMMERCIAL, INC. (<b>{{ $van_selling->principal->principal }}</b>)<br />
        THE FOLLOWING MERCHANDISE AS ORDERED ABOVE IN GOOD ORDER<br />
        AND MERCHANTIBLE CONDITION
      </div><br /><br />
      <table class="table table-borderless table-sm">
        <thead>
          <tr>
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr>
            <th>Prepared By:</th>
            <th style="text-transform: uppercase;">{{ $employee_name->name }}</th>
            <th>Released By:</th>
            <th>_______________</th>
            <th>Delivered By:</th>
            <th>_______________</th>
            <th>Received By/Customer:</th>
            <th>_______________</th>
          </tr>
        </thead>
      </table>
  </div>


<form>
  <input type="hidden" id="van_selling_id" value="{{ $van_selling->id }}">
</form>


<script src="{{ asset('adminLte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
window.print();
window.onafterprint = function(){
   window.close();
}
</script>