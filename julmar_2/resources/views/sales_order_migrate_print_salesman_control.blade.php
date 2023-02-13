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
  height: 150px;
}


.page-footer, .page-footer-space {
  height: 50px;

}

.page-footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  border-top: 0px;  /*for demo */
  background: yellow;  /*for demo */
}

.page-header {
  position: fixed;
  top: 0mm;
  width: 100%;
  border-bottom: 0px;  /*for demo */
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

.borderless td, .borderless th {
border: none;
}


  </style>
</head>

<body>

    <div class="page-header">
      <table class="table table-bordered" style='width:50%;'>
        <thead>
          <tr>
            <th colspan="2">DR CONTROL</th>
          </tr>
          <tr>
            <th>DATE</th>
            <th>{{ $date }}</th>
          </tr>
          <tr>
            <th>SALES REP NAME</th>
            <th>{{ $salesman }}</th>
          </tr>
        </thead>
      </table>
    </div>

    <table class="table table-bordered table-sm">
      <thead>
         <tr>
          <td colspan="8">
            <!--place holder for the fixed-position header-->
            <div class="page-header-space"></div>
          </td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="text-align: center;">DR NO</td>
          <td style="text-align: center;">CUSTOMER</td>
          <td style="text-align: center;">TRANSACTION</td>
          <td style="text-align: center;">AMOUNT</td>
          <td style="text-align: center;">CUSTOMER DISC</td>
          <td style="text-align: center;">CATEGORY DISC</td>
          <td style="text-align: center;">NET AMOUNT</td>
          <td style="text-align: center;">DRIVER</td>
        </tr>
        @for ($i=0; $i < $delivery_receipt_counter; $i++) 
        <tr>
          <td style="text-align: center;">{{ $delivery_receipt[$i] }}</td>
          <td style="text-align: center;text-transform: uppercase;">{{ $store_name[$i] }}</td>
          <td style="text-align: center;">{{ $mode_of_transaction[$i] }}</td>
          <td style="text-align: right;">{{ number_format($total_amount[$i],2,".",",")  }}</td>
          <td style="text-align: right;">{{ number_format($total_customer_discount_amount[$i],2,".",",")  }}</td>
          <td style="text-align: right;">{{ number_format($total_category_discount_amount[$i],2,".",",")  }}</td>
          <td style="text-align: right;">{{ number_format($total_customer_payable_amount[$i],2,".",",")  }}</td>
          <td style="text-align: right;"></td>
        </tr>
        @endfor
        <tr>
          <td colspan="3" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
          <td style="text-align: right;font-weight: bold;">{{ number_format($total_amount_array,2,".",",")  }}</td>
          <td style="text-align: right;font-weight: bold;">{{ number_format($total_customer_discount_amount_array,2,".",",")  }}</td>
          <td style="text-align: right;font-weight: bold;">{{ number_format($total_category_discount_amount_array,2,".",",")  }}</td>
          <td style="text-align: right;font-weight: bold;">{{ number_format($total_payable_amount_array,2,".",",")  }}</td>
        </tr>
      </tbody>
    </table>

