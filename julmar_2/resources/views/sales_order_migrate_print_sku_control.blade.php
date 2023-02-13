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
            <th colspan="2">SKU CONTROL</th>
            
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
          <th style="text-align: center;">CODE</th>
          <th style="text-align: center;">DESCRIPTION</th>
          <th style="text-align: center;">UOM</th>
          <th style="text-align: center;">QTY</th>
          <th style="text-align: center;">AMOUNT</th>
        </tr>
        @for ($i=0; $i < $sku_counter; $i++) 
          <tr>
            <td style="text-align: center;">{{ $sku[$i] }}</td>
            <td style="text-align: center;">{{ $description[$i] }}</td>
            <td style="text-align: center;">{{ $unit_of_measurement[$i] }}</td>
            <td style="text-align: center;">{{ $sku_quantity[$i] }}</td>
            <td style="text-align: right;">{{ number_format($sku_final_amount_per_sku[$i],2,".",",") }} </td>
          </tr>
        @endfor
          <tr>
            <td style="text-align: center;" colspan="4">TOTAL</td>
            <td style="text-align: right;font-weight: bold;">{{ number_format($sku_total_amount_array,2,".",",") }}</td>
          </tr>
          <tr>
            <td style="text-align: center;" colspan="4">TOTAL CUSTOMER DISCOUNT</td>
            <td style="text-align: right;font-weight: bold;">{{ number_format($total_customer_discount_amount_array,2,".",",") }}</td>
          </tr>
          <tr>
            <td style="text-align: center;" colspan="4">GRAND TOTAL</td>
            <td style="text-align: right;font-weight: bold;">{{ number_format($grand_total,2,".",",") }}</td>
          </tr>
      </tbody>
    </table>

