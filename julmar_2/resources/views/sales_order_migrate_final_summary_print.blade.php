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
  height: 300px;
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
      <table class="table table-borderless table-sm" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <td style="text-align: left;font-weight: bold;"><h3><b><img src="{{ asset('/adminLte/julmar.png') }}" style="width:50px;" alt="">JULMAR COMMERCIAL. INC,</b></h3></td>
            <td style="font-weight: bold;text-align:center;" colspan="2"><h3><b>DELIVERY RECEIPT</b></h3></td>
          </tr>
          <tr>
            <td style="text-align: left"><h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5></td>
            <td style="text-align: right;"><h5>Invoice Number:</h5></td>
            <td style="text-align: left;"><h5>{{ $delivery_receipt }}</h5></td>
          </tr>
          <tr>
            <td style="text-align: left"><h6>Tel No: 881-9973 / 09177058232</h6></td>
            <td style="text-align: right;"><h6>Dr Date:</h6></td>
            <td style="text-align: left;"><h6>{{ $date }}</h6></td>
          </tr>
          <tr>
            <td style="text-align: left"><i><b><h6>Bill To:</h6></b></i></td>
            <td colspan="2" style="text-align: center"><h6><b>SALESMAN: {{ $salesman }}</b></h6></td>
          </tr>
          <tr>
            <td style="text-align: left;text-transform: uppercase;font-weight: bold"><h6><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $store_name
             }}</b></h6></td>
             <td style="text-align: right;"><h6>Store Code:</h6></td>
             <td><h6>{{ $store_code }}</h6></td>
          </tr>
          <tr>
            <td style="text-transform: uppercase;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $detailed_location }}</h6></td>
            <td style="text-align: right;"><h6>Payment Terms</h6></td>
            <td><h6>{{ $due_date }}</h6></td>
          </tr>
          <tr>
            <td style="text-transform: uppercase;"><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $store_location }}</h6></td>
            <td colspan="2" style="text-align: center;"><h6><b>{{ $mode_of_transaction }}</b></h6></td>

          </tr>
        </thead>
        <tbody>
         
        </tbody>
      </table>
    </div>

  <table class="table table-sm table-borderless">
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
        <th style="text-align: center;">Code</th>
        <th style="text-align: center;">Description</th>
        <th style="text-align: center;">Quantity</th>
        <th style="text-align: center;">Price</th>
        <th style="text-align: center;">Amount</th>
        @foreach($sku_code as $sku_data_code)
        @if($cd_rate_1[$sku_data_code] == 0)
        @php
        break;
        @endphp
        @else
        <th style="text-align: center;">Cat Disc<br >1</th>
        @endif
        @if($cd_rate_2[$sku_data_code] == 0)
        @php
        break;
        @endphp
        @else
        <th style="text-align: center;">Cat Disc<br >2</th>
        @endif
        @if($cd_rate_3[$sku_data_code] == 0)
        @php
        break;
        @endphp
        @else
        <th style="text-align: center;">Cat Disc<br >3</th>
        @endif
        @if($cd_rate_4[$sku_data_code] == 0)
        @php
        break;
        @endphp
        @else
        <th style="text-align: center;">Cat Disc<br >4</th>
        @endif
        @endforeach
        <th style="text-align: center;">Total<br />Category<br />Disc</th>
        <th style="text-align: center;">Net<br />Amount</th>
      </tr>
        @foreach($sku_code as $sku_data_code)
          <tr>
            <td>{{ $sku_data_code }}</td>
            <td>{{ $description[$sku_data_code] }}</td>
            <td>{{ $final_ordered_quantity_to_print[$sku_data_code] }}</td>
            <td>{{ $price_to_print[$sku_data_code] }}</td>
            <td style="text-align: right;">
              @php
              $total_amount_price_x_quantity = $price_to_print[$sku_data_code] * $final_ordered_quantity_to_print[$sku_data_code];
              $total_amount_price_x_quantity_array[] = $total_amount_price_x_quantity;
              @endphp
              {{ number_format($total_amount_price_x_quantity,2,".",",") }}
            </td>
            @if($cd_rate_1[$sku_data_code] == 0)
            @php
            $category_discount_line_rate_1 = 0;
            @endphp
            @else
            <td style="text-align: right;">
              @php
              $category_discount_rate_1 = $total_amount_price_x_quantity - $total_amount_price_x_quantity * $cd_rate_1[$sku_data_code]/100;
              $category_discount_line_rate_1 = $total_amount_price_x_quantity * $cd_rate_1[$sku_data_code]/100;
              echo number_format($category_discount_line_rate_1,2,".",",");
              @endphp
            </td>
            @endif
            @if($cd_rate_2[$sku_data_code] == 0)
            @php
            $category_discount_line_rate_2 = 0;
            @endphp
            @else
            <td style="text-align: right;">
              @php
              $category_discount_rate_2 = $category_discount_rate_1 - $category_discount_rate_1 * $cd_rate_2[$sku_data_code]/100;
              $category_discount_line_rate_2 = $category_discount_rate_1 * $cd_rate_2[$sku_data_code]/100;
              echo number_format($category_discount_line_rate_2,2,".",",");
              @endphp
            </td>
            @endif
            @if($cd_rate_3[$sku_data_code] == 0)
            @php
            $category_discount_line_rate_3 = 0;
            @endphp
            @else
            <td style="text-align: right;">
              @php
              $category_discount_rate_3 = $category_discount_rate_2 - $category_discount_rate_2 * $cd_rate_3[$sku_data_code]/100;
              $category_discount_line_rate_3 = $category_discount_rate_2 * $cd_rate_3[$sku_data_code]/100;
              echo number_format($category_discount_line_rate_3,2,".",",");
              @endphp
            </td>
            @endif
            @if($cd_rate_4[$sku_data_code] == 0)
            @php
            $category_discount_line_rate_4 = 0;
            @endphp
            @else
            <td style="text-align: right;">
              @php
              $category_discount_rate_4 = $category_discount_rate_3 - $category_discount_rate_3 * $cd_rate_4[$sku_data_code]/100;
              $category_discount_line_rate_4 = $category_discount_rate_3 * $cd_rate_4[$sku_data_code]/100;
              echo number_format($category_discount_line_rate_4,2,".",",");
              @endphp
            </td>
            @endif
            @if($category_discount_line_rate_1 != 0 OR $category_discount_line_rate_2 != 0 OR $category_discount_line_rate_3 != 0 OR $category_discount_line_rate_4 != 0)
            @php
            $final_category_discount_amount_per_sku = $category_discount_line_rate_1 + $category_discount_line_rate_2 + $category_discount_line_rate_3 + $category_discount_line_rate_4;
            $total_category_discount_array[] = $final_category_discount_amount_per_sku;
            @endphp
            <td style="text-align: right;font-weight: bold;">{{ number_format($final_category_discount_amount_per_sku,2,".",",") }}
              
            </td>
            @else
            @php
            $final_category_discount_amount_per_sku = 0;
            $total_category_discount_array[] = 0;
            @endphp
            <td style="text-align: right;font-weight: bold;">{{ number_format($final_category_discount_amount_per_sku,2,".",",") }}
            </td>
            @endif
            <td style="text-align: right;font-weight: bold;">
              @php
              $final_net_amount_per_sku =  $total_amount_price_x_quantity - $final_category_discount_amount_per_sku;
              $final_net_amount_per_sku_array[] = $final_net_amount_per_sku;
              @endphp
               {{ number_format($final_net_amount_per_sku,2,".",",") }}
            </td>
          </tr>
        @endforeach

        <tr>
            <td colspan="4" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
            
            <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($total_amount_price_x_quantity_array),2,".",",")  }}</td>
            @if($category_discount_line_rate_1 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_2 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_3 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_4 != 0)
            <td></td>
            @else
            @endif
            <td style="text-align: right;font-weight: bold;">
              {{  number_format(array_sum($total_category_discount_array),2,".",",") }}
            </td>
            <td style="text-align: right;font-weight: bold;">
              {{  number_format(array_sum($final_net_amount_per_sku_array),2,".",",") }}
              
            </td>
        </tr>
         <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
          <td style="text-align: right;font-weight: bold;">Quantity:</td>
          <td style="text-align: left;font-weight: bold;">
            @php
              $sumArray = array();
              foreach ($sku_code as $key => $data){
              $sumArray[] += $final_ordered_quantity_to_print[$data];
              }
              echo array_sum($sumArray);
            @endphp
          </td>
          <td colspan="3"></td>
            @if($category_discount_line_rate_1 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_2 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_3 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_4 != 0)
            <td></td>
            @else
            @endif
            <td>TOTAL DR AMOUNT:</td>
            <td>
              @php
              $total_dr_amount = array_sum($total_category_discount_array) + array_sum($final_net_amount_per_sku_array);
              $total_dr_amount_array[] = $total_dr_amount;
              @endphp
              {{ number_format($total_dr_amount,2,".",",") }}
            </td>
      </tr>
      <tr> 
          <td colspan="5"></td>
            @if($category_discount_line_rate_1 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_2 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_3 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_4 != 0)
            <td></td>
            @else
            @endif
            <td>TOTAL CATEGORY DISC:</td>
            <td>
               @php
              $total_category_discount_amount = array_sum($total_category_discount_array);
              $total_category_discount_array[] = $total_category_discount_amount;
              @endphp
              {{ number_format($total_category_discount_amount,2,".",",") }}
            </td>
      </tr>
      <tr> 
          <td colspan="5"></td>
            @if($category_discount_line_rate_1 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_2 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_3 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_4 != 0)
            <td></td>
            @else
            @endif
            <td>NET AMOUNT:</td>
            <td>
              @php
                $total_for_dr_and_category_amount = $total_dr_amount - $total_category_discount_amount;
              @endphp
              {{ number_format($total_for_dr_and_category_amount,2,".",",") }}
            </td>
      </tr>
      @if($customer_discount_counter == 0)
          <tr>          
              <td colspan="5"></td>
                @if($category_discount_line_rate_1 != 0)
                <td></td>
                @else
                @endif
                @if($category_discount_line_rate_2 != 0)
                <td></td>
                @else
                @endif
                @if($category_discount_line_rate_3 != 0)
                <td></td>
                @else
                @endif
                @if($category_discount_line_rate_4 != 0)
                <td></td>
                @else
                @endif
                <td>CUSTOMER DISC 0</td>
                <td>
                  @php
                    echo $answer = 0;
                    $deducted_total_history[] = $answer;
                  @endphp
                </td>
          </tr>
  
      @else
        @php
            $total = $total_for_dr_and_category_amount;
            $deducted_total = $total;
            $deducted_total_history = [];
        @endphp
        @for ($i=0; $i < $customer_discount_counter; $i++)
            <tr>          
                <td colspan="5"></td>
                  @if($category_discount_line_rate_1 != 0)
                  <td></td>
                  @else
                  @endif
                  @if($category_discount_line_rate_2 != 0)
                  <td></td>
                  @else
                  @endif
                  @if($category_discount_line_rate_3 != 0)
                  <td></td>
                  @else
                  @endif
                  @if($category_discount_line_rate_4 != 0)
                  <td></td>
                  @else
                  @endif
                  <td>CUSTOMER DISC {{ $customer_discount_to_print[$i] / 100 }}</td>
                  <td>
                    @php
                    $deducted_total_dummy = $deducted_total;
                    $less_percentage_by = ($customer_discount_to_print[$i] / 100);
                    $deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
                    echo $answer = round($deducted_total_dummy * $less_percentage_by,2);
                    $deducted_total_history[] = $answer;
                    @endphp
                  </td>
            </tr>
        @endfor
      @endif
      <tr>
        <td colspan="5"></td>
        @if($category_discount_line_rate_1 != 0)
        <td></td>
        @else
        @endif
        @if($category_discount_line_rate_2 != 0)
        <td></td>
        @else
        @endif
        @if($category_discount_line_rate_3 != 0)
        <td></td>
        @else
        @endif
        @if($category_discount_line_rate_4 != 0)
        <td></td>
        @else
        @endif
        <td>TOTAL CUSTOMER DISC:</td>
        <td>
          @php
          $total_customer_discount_amount = array_sum($deducted_total_history);
          $total_category_discount_per_sku_array[] = $total_customer_discount_amount;
          @endphp
          {{ number_format($total_customer_discount_amount,2,".",",") }}
        </td>
      </tr>
      <tr> 
          <td colspan="5"></td>
            @if($category_discount_line_rate_1 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_2 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_3 != 0)
            <td></td>
            @else
            @endif
            @if($category_discount_line_rate_4 != 0)
            <td></td>
            @else
            @endif
            <td>TOTAL PAYABLE AMOUNT:</td>
            <td>
              @php
              $total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
              @endphp
              {{  number_format($total_payable_amount,2,".",",") }}
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
        <i>RECEIVED FROM JULMAR COMMERCIAL, INC. (GREEN CROSS DIVISION)<br />
        THE FOLLOWING MERCHANDISE AS ORDERED ABOVE IN GOOD ORDER<br />
        AND MERCHANTIBLE CONDITION</i>
      </div><br /><br />
      <table class="table table-borderless table-sm">
        <thead>
          <tr>
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr>
            <th>Prepared By:</th>
            <th>_______________</th>
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








</body>

</html>