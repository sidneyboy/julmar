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
        <th colspan="8" style="text-transform: uppercase;">
          SALESMAN CONTROL:
          
        </th>
        
      </tr>
      <tr>
        <th colspan="8" style="text-transform: uppercase;">
          SALESMAN: {{ $sales_order_printed[0]->salesman->full_name }}
          
        </th>
        
      </tr>
      <tr>
        <th colspan="8" style="text-transform: uppercase;">
          SALES ORDER NUMBER: {{ $sales_order_printed[0]->sales_order_number }}
          
        </th>
        
      </tr>

      <tr>
        <th style="text-align: center;">DR NO</th>
        <th style="text-align: center;">CUSTOMER</th>
        <th style="text-align: center;">TRANSACTION</th>
        <th style="text-align: center;">AMOUNT</th>
        <th style="text-align: center;">CUSTOMER DISC</th>
        <th style="text-align: center;">CATEGORY DISC</th>
        <th style="text-align: center;">NET AMOUNT</th>
        <th style="text-align: center;">DRIVER</th>
      </tr>
    </thead>
    <tbody>
      @foreach($sales_order_printed as $data)
      <tr>
        <td style="text-align: center;">
          {{ $data->delivery_receipt }}
          
        </td>
        <td style="text-align: center;text-transform: uppercase;">
          {{ $data->customer->store_name }}
          
        </td>
        <td style="text-align: center;">
          {{ $data->mode_of_transaction }}
          
        </td>
        <td style="text-align: right;">
          @php
          $total_amount = $data->total_customer_payable_amount + $data->total_category_discount_amount + $data->total_customer_discount_amount;
          $total_amount_array[] = $total_amount;
          @endphp
          {{ number_format($total_amount,2,".",",")  }}
          
        </td>
        <td style="text-align: right;">
          @php
          $total_customer_discount_amount_array[] = $data->total_customer_discount_amount;
          @endphp
          {{ number_format($data->total_customer_discount_amount,2,".",",") }}
          
        </td>
        <td style="text-align: right;">
          @php
          $total_category_discount_amount_array[] = $data->total_category_discount_amount;
          @endphp
          {{ number_format($data->total_category_discount_amount,2,".",",") }}
          
        </td>
        <td style="text-align: right;">
          @php
          $total_payable_amount_array[] = $data->total_customer_payable_amount;
          @endphp
          {{ number_format($data->total_customer_payable_amount,2,".",",") }}
          
        </td>
        <td></td>
      </tr>
      @endforeach
      <tr>
        <td colspan="3" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
        <td style="text-align: right;font-weight: bold;">
          {{ number_format(array_sum($total_amount_array),2,".",",") }}
          
        </td>
        <td style="text-align: right;font-weight: bold;">
          {{ number_format(array_sum($total_customer_discount_amount_array),2,".",",") }}
        
        </td>
        <td style="text-align: right;font-weight: bold;">
          {{ number_format(array_sum($total_category_discount_amount_array),2,".",",") }}
          
        </td>
        <td style="text-align: right;font-weight: bold;">
          {{ number_format(array_sum($total_payable_amount_array),2,".",",") }}
          
        </td>
        <td></td>
      </tr>
    </tbody>
  </table>


</body>

</html>