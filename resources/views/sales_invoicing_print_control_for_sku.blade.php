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
  height: 330px;
}


.page-footer, .page-footer-space {
  height: 180px;

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
  tfoot {display: table-footer-group;}
  thead {display: table-header-group;} 
  button {display: none;}


  html, body {
        width: 5.5in; /* was 8.5in */
        height: 8.5in; /* was 5.5in */
        display: block;
        font-family: "Calibri";
        /*font-size: auto; NOT A VALID PROPERTY */
    }

    @page {
        size: 5.5in 8.5in /* . Random dot? */;
    }

}



  </style>
</head>

<body>
<table class="table table-bordered table-hovered">
    <thead>
      <tr>
        <th colspan="5">SKU CONTROL</th>
      </tr>
      <tr>
        <th colspan="5">SALES ORDER #: {{ $sales_order_printed[0]->sales_order_number }}</th>
      </tr>
      <tr>
        <th colspan="5" style="text-transform: uppercase;">SALESMAN : {{ $sales_order_printed[0]->salesman->full_name }}</th>
      </tr>
      <tr>
        <th style="text-align: center;">CODE</th>
        <th style="text-align: center;">DESCRIPTION</th>
        <th style="text-align: center;">UOM</th>
        <th style="text-align: center;">QTY</th>
        <th style="text-align: center;">NET AMOUNT
          
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach($select_sku_group_by as $sku_group)
      <tr>
        <td style="text-align: center;">
          {{ $sku_group->sku->sku_code }}
          
        </td>
        <td style="text-align: center;">
          {{ $sku_group->sku->description }}
          
        </td>
        <td style="text-align: center;">
          {{ $sku_group->sku->unit_of_measurement }}
          
        </td>
        <td style="text-align: center;">
          {{ $sku_quantity_array[$sku_group->sku_id] }}
         
        </td>
        <td style="text-align: right;">
          @php
          $sku_total_amount_array[] = $sku_final_amount_per_sku[$sku_group->sku_id];
          @endphp
          {{  number_format($sku_final_amount_per_sku[$sku_group->sku_id],2,".",",")  }}
          
        </td>
      </tr>
      @endforeach
      <tr>
        <td colspan="4" style="text-align: center;font-weight: bold;">TOTAL</td>
        <td style="text-align: right;font-weight: bold;">
          {{ number_format(array_sum($sku_total_amount_array),2,".",",") }}
          
        </td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: center;font-weight: bold;">TOTAL CUSTOMER DISCOUNT</td>
        <td style="text-align: right;font-weight: bold;">
          ({{ number_format($total_customer_discount_amount,2,".",",") }})
          
        </td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
        <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sku_total_amount_array) - $total_customer_discount_amount,2,".",",") }}</td>
       
      </tr>
    </tbody>
  </table>
</body>

</html>