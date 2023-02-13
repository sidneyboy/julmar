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
        <th  style="width:30%;line-height:0px;text-transform: uppercase;">{{ $sales_order_printed->customer->store_name }}</th>
        <th  style="width:20%;line-height:0px"><span class="float-right">Dr Number:</span></th>
        <th  style="width:30%;line-height:0px">{{ $sales_order_printed->dr }}</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="line-height:0px;"><span class="float-right">Store Code:</span></td>
        <td style="line-height:0px;">{{ $customer_principal_code->store_code }}</td>
        <td style="line-height:0px;"><span class="float-right">DR Date :</span></td>
        <td style="line-height:0px;">{{ $sales_order_printed->date }}</td>
      </tr>
      <tr>
        <td style="line-height:0px;"><span class="float-right">Address:</span></td>
        <td style="line-height:0px;">{{ $sales_order_printed->customer->detailed_location  }}</td>
        <td style="line-height:0px;"><span class="float-right">SO No:</span></td>
        <td style="line-height:0px;">{{ $sales_order_printed->sales_order_number }}</td>
      </tr>
      <tr>
        <td style="line-height:0px;"><span class="float-right">Area:</span></td>
        <td style="line-height:0px;">{{ $sales_order_printed->customer->location->location }}</td>
        <td style="line-height:0px;"><span class="float-right">CUSTOMER PO NO::</span></td>
        <td style="line-height:0px;">N/a</td>
      </tr>
      <tr>
        <td style="line-height:0px;"><span class="float-right">Transaction:</span></td>
        <td style="line-height:0px;">{{ $sales_order_printed->mode_of_transaction }}
        </td>
        <td style="line-height:0px;"><span class="float-right">Salesman:</span></td>
        <td style="line-height:0px;">{{ $agent->full_name}}</td>
      </tr>
      <tr>
        <td style="line-height:0px;"></td>
        <td style="line-height:0px;"></td>
        <td style="line-height:0px;"><span class="float-right">Payment Terms:</span></td>
        <td style="line-height:0px;">{{ $sales_order_printed->customer->credit_term }}</td>
      </tr>
      <tr>
        <td style="line-height:0px;"></td>
        <td style="line-height:0px;"></td>
        <td style="line-height:0px;"><span class="float-right">Due Date:</span></td>
        <td style="line-height:0px;">{{ date('Y-m-d', strtotime($sales_order_printed->date. ' + '. $sales_order_printed->customer->credit_term)) }}</td>
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
        <th style="line-height:15px;text-align: center;">CODE</th>
        <th style="line-height:15px;text-align: center;">DESCRIPTION</th>
        <th style="line-height:15px;text-align: center;">QTY</th>
        <th style="line-height:15px;text-align: center;">PRICE</th>
        <th style="line-height:15px;text-align: center;">AMOUNT</th>
        @if($sales_order_printed->total_line_discount_1 != 0)
        <th style="line-height:15px;text-align: center;">LINE DISC 1</th>
        @endif
        @if($sales_order_printed->total_line_discount_2 != 0)
        <th style="line-height:15px;text-align: center;">LINE DISC 2</th>
        @endif

        @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
          <th style="line-height:15px;text-align: center;">TOTAL DISC</th>
        @endif
      
        @if($sales_order_printed->total_line_discount_1 AND $sales_order_printed->total_line_discount_2 != 0)
        <th style="line-height:15px;text-align: center;">SUB - TOTAL</th>
        @elseif($sales_order_printed->total_line_discount_1 != 0)
        <th style="line-height:15px;text-align: center;" colspan="2">SUB - TOTAL</th>
        @elseif($sales_order_printed->total_line_discount_2 != 0)
        <th style="line-height:15px;text-align: center;" colspan="2">SUB - TOTAL</th>
        @else
        <th style="line-height:15px;text-align: center;" colspan="3">SUB - TOTAL</th>
        @endif
      </tr>
      @foreach($sales_order_printed->sales_order_print_details as $details)
      <tr>
        <td style="line-height:15px;">{{ $details->sku->sku_code }}</td>
        <td style="line-height:15px;">{{ $details->sku->description }}</td>
        <td style="line-height:15px;text-align: right">
          @php
          $sum_quantity[] = $details->quantity;
          @endphp
          {{ $details->quantity }}
        </td>
        <td style="line-height:15px;text-align: right">{{ number_format($details->price,2,".",",") }}</td>
        <td style="line-height:15px;text-align: right">
          @php
          $amount_per_sku = $details->quantity * $details->price;
          $sum_amount_per_sku[] = $amount_per_sku;
          echo number_format($amount_per_sku,2,".",",")
          @endphp
        </td>
        

        @if($sales_order_printed->total_line_discount_1 != 0)
          @if($details->line_discount_1 == 0)
            <td style="line-height:15px;text-align: right;">
              @php
              echo $line_discount_1 = 0;
              @endphp
            </td>
          @else
            <td style="line-height:15px;text-align: right;">
              @php
              $line_discount_1 = $details->line_discount_1;
              echo number_format($line_discount_1,2,".",",");
              @endphp
            </td>
          @endif
        @else
          @php
            $line_discount_1 = 0;
          @endphp
        @endif



        @if($sales_order_printed->total_line_discount_2 != 0)
          @if($details->line_discount_2 == 0)
            <td style="line-height:15px;text-align: right;">
              @php
              echo $line_discount_2 = 0;
              @endphp
            </td>
          @else
            <td style="line-height:15px;text-align: right;">
              @php
              $line_discount_2 = $details->line_discount_2;
              echo number_format($line_discount_2,2,".",",");
              @endphp
            </td>
          @endif
        @else
          @php
            $line_discount_2 = 0;
          @endphp
        @endif



        @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;text-align: right">
            @php
            $total_line_discount_amount = $line_discount_1 + $line_discount_2;
            echo number_format($total_line_discount_amount,2,".",",");
            $total_category_discount_array[] = $total_line_discount_amount;
            @endphp
          </td>
        @else
          @php
            $total_line_discount_amount = 0;
            echo number_format($total_line_discount_amount,2,".",",");
            $total_category_discount_array[] = $total_line_discount_amount;
          @endphp
        @endif

    
        
        <td style="line-height:15px;text-align: right;font-weight: bold;">
          @php
          $final_net_amount_per_sku =  $details->sub_total;
          $final_net_amount_per_sku_array[] = $final_net_amount_per_sku;
          echo number_format($final_net_amount_per_sku,2,".",",");
          @endphp
        </td>
      </tr>
      @endforeach
      <tr>
        <td colspan="4"></td>
        <td style="line-height:15px;text-align: right">{{ number_format(array_sum($sum_amount_per_sku),2,".",",") }}</td>
        @if($sales_order_printed->total_line_discount_1 != 0)
          <td style="line-height:15px;"></td>
        @endif
        @if($sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif
        
        @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;text-align: right;font-weight: bold;color:green;">
            {{  number_format($sales_order_printed->total_line_discount,2,".",",") }}
          </td>
        @endif

        <td style="line-height:15px;text-align: right;font-weight: bold;color:green;">
          {{  number_format(array_sum($sum_amount_per_sku) - $sales_order_printed->total_line_discount,2,".",",") }}
        </td>
      </tr>
      <tr>
        <td colspan="2" style="line-height:15px;font-weight: bold;">&nbsp;</td>
        <td colspan="3" style="line-height:15px;font-weight: bold;"></td>
        <td style="line-height:15px;font-weight: bold;"></td>
        @if($sales_order_printed->total_line_discount_1 != 0)
          <td style="line-height:15px;"></td>
        @endif
        @if($sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif
        
        @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif
      </tr>
      <tr>
        <td colspan="2" style="line-height:15px;font-weight: bold;">&nbsp;</td>
        <td colspan="3" style="line-height:15px;font-weight: bold;"></td>
        <td style="line-height:15px;font-weight: bold;"></td>
        @if($sales_order_printed->total_line_discount_1 != 0)
          <td style="line-height:15px;"></td>
        @endif
        @if($sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif
        
        @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif
      </tr>
      <tr>
        <td  style="line-height:15px;font-weight: bold;"><span class="float-right">QUANTITY:</span></td>
        <td style="line-height:15px;font-weight: bold;">
          @php
          echo array_sum($sum_quantity);
          @endphp
        </td>

        @if($sales_order_printed->total_line_discount_1 != 0)
          <td style="line-height:15px;"></td>
        @endif
        @if($sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif
        
        @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif

        <td colspan="2" style="line-height:15px;font-weight: bold;"><span class="float-right">TTL AMOUNT: </span></td>
        <td></td>
        <td style="line-height:15px;font-weight: bold;">
          @php
          $total_dr_amount = array_sum($total_category_discount_array) + array_sum($final_net_amount_per_sku_array);
          $total_dr_amount_array[] = $total_dr_amount;
          @endphp
          {{ number_format($total_dr_amount,2,".",",") }}
        </td>
      </tr>    
      <tr>
        {{-- <td colspan="2" style="line-height:15px;"></td>
        <td colspan="3" style="line-height:15px;"></td>

        <td colspan="2" style="line-height:15px;font-weight: bold;"><span class="float-right">TTL CAT DISC: </span></td>
        <td style="line-height: 15px;"></td>
        <td style="line-height:15px;font-weight: bold;">
          @php
          $total_category_discount_amount = array_sum($total_category_discount_array);
          $total_category_discount_array[] = $total_category_discount_amount;
          @endphp
          {{ number_format($total_category_discount_amount,2,".",",") }}
        </td> --}}



        <td  style="line-height:15px;font-weight: bold;"></td>
        <td style="line-height:15px;font-weight: bold;"></td>

        @if($sales_order_printed->total_line_discount_1 != 0)
          <td style="line-height:15px;"></td>
        @endif
        @if($sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif
        
        @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif

        <td colspan="2" style="line-height:15px;font-weight: bold;"><span class="float-right">TTL CAT DISC: </span></td>
        <td></td>
        <td style="line-height:15px;font-weight: bold;">
          @php
          $total_category_discount_amount = array_sum($total_category_discount_array);
          $total_category_discount_array[] = $total_category_discount_amount;
          @endphp
          {{ number_format($total_category_discount_amount,2,".",",") }}
        </td>


























      </tr>
      <tr>

        <td  style="line-height:15px;font-weight: bold;"></td>
        <td style="line-height:15px;font-weight: bold;"></td>

        @if($sales_order_printed->total_line_discount_1 != 0)
          <td style="line-height:15px;"></td>
        @endif
        @if($sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif
        
        @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
          <td style="line-height:15px;"></td>
        @endif

        <td colspan="2" style="line-height:15px;font-weight: bold;"><span class="float-right">NET AMOUNT: </span></td>
        <td></td>
        <td style="line-height:15px;font-weight: bold;text-decoration:overline;">
          @php
          $total_for_dr_and_category_amount = $total_dr_amount - $total_category_discount_amount;
          @endphp
          {{ number_format($total_for_dr_and_category_amount,2,".",",") }}
          
        </td>
























      </tr>
     {{--  <tr>
        <td colspan="2" style="line-height:15px;"></td>
        <td colspan="3" style="line-height:15px;"></td>
        <td colspan="2" style="line-height:15px;font-weight: bold;"><span class="float-right">LESS: CUSTOMER DISCOUNT</span></td>
        <td style="line-height:15px;"></td>
        <td style="line-height:15px;"></td>
      </tr> --}}
        @if($customer_discount_counter == 0)
                <tr>
                  <td colspan="2" style="line-height:15px;"></td>
                  <td colspan="3" style="line-height:15px;"></td>
                  @if($sales_order_printed->total_line_discount_1 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  @if($sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  
                  @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  <td colspan="3" style="line-height:15px;font-weight: bold;"><span class="float-right">CUSTOMER DISC</span></td>
                  
                  <td style="line-height:15px;font-weight: bold;">
                    @php
                     echo $answer = 0.00;
                     $deducted_total_history[] = $answer;
                    @endphp
                  </td>
                  <td style="line-height:15px;"></td>

                </tr>
                <tr>
                 <td  style="line-height:15px;font-weight: bold;"></td>
                  <td style="line-height:15px;font-weight: bold;"></td>
                  <td></td>

                  @if($sales_order_printed->total_line_discount_1 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  @if($sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  
                  @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif

                  <td style="line-height:15px;font-weight: bold;"><span class="float-right">TOTAL CUSTOMER DISC: </span></td>
                  <td style="line-height:15px;"></td>
                  <td style="line-height:15px;font-weight: bold;">
                    @php
                    $total_customer_discount_amount = array_sum($deducted_total_history);
                    $total_category_discount_per_sku_array[] = $total_customer_discount_amount;
                    @endphp
                    
                    {{ number_format($total_customer_discount_amount,2,".",",") }}
                  </td>


                </tr>
                <tr>
                  <td  style="line-height:15px;font-weight: bold;"></td>
                  <td style="line-height:15px;font-weight: bold;"></td>
                  <td></td>

                  @if($sales_order_printed->total_line_discount_1 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  @if($sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  
                  @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif

                  <td  style="line-height:15px;font-weight: bold;"><span class="float-right">TOTAL PAYABLE AMOUNT: </span></td>
                  <td style="line-height:15px;font-weight: bold;">
                    
                  </td>
                  <td style="line-height:15px;font-weight: bold;text-decoration:overline;">
                    @php
                    $total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
                    @endphp
                    {{  number_format($total_payable_amount,2,".",",") }}
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
                  <td  style="line-height:15px;font-weight: bold;"></td>
                  <td style="line-height:15px;font-weight: bold;"></td>
                  <td></td>

                  @if($sales_order_printed->total_line_discount_1 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  @if($sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  
                  @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif



                  <td style="line-height:15px;font-weight: bold;"><span class="float-right">CUSTOMER DISC {{ $customer_discount_rate[$i] / 100 }} </span></td>
                  
                  <td style="line-height:15px;font-weight: bold;">
                    @php
                    $deducted_total_dummy = $deducted_total;
                    $less_percentage_by = ($customer_discount_rate[$i] / 100);
                    $deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
                    $answer = round($deducted_total_dummy * $less_percentage_by,2);
                    $deducted_total_history[] = $answer;
                    echo number_format($answer,2,".",",");
                    @endphp
                  </td>
                   <td style="line-height:15px;"></td>
                </tr>
              @endfor
              <tr>
               <td  style="line-height:15px;font-weight: bold;"></td>
                  <td style="line-height:15px;font-weight: bold;"></td>
                  <td></td>

                  @if($sales_order_printed->total_line_discount_1 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  @if($sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  
                  @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif


                <td style="line-height:15px;font-weight: bold;"><span class="float-right">TOTAL CUSTOMER DISC: </span></td>
                <td style="line-height:15px;"></td>
                <td style="line-height:15px;font-weight: bold;">
                  @php
                  $total_customer_discount_amount = array_sum($deducted_total_history);
                  $total_category_discount_per_sku_array[] = $total_customer_discount_amount;
                  @endphp
                  <input type="hidden" name="total_customer_discount_amount" value="{{ $total_customer_discount_amount }}">
                  {{ number_format($total_customer_discount_amount,2,".",",") }}
                </td>
              </tr>
              <tr>
                <td  style="line-height:15px;font-weight: bold;"></td>
                  <td style="line-height:15px;font-weight: bold;"></td>
                  <td></td>

                  @if($sales_order_printed->total_line_discount_1 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  @if($sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif
                  
                  @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
                    <td style="line-height:15px;"></td>
                  @endif

                <td style="line-height:15px;font-weight: bold;"><span class="float-right">TOTAL PAYABLE AMOUNT: </span></td>
                <td style="line-height:15px;font-weight: bold;">
                  
                </td>
                <td style="line-height:15px;font-weight: bold;text-decoration:overline;">
                  @php
                  $total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
                  @endphp
                  {{  number_format($total_payable_amount,2,".",",") }}
                  <input type="hidden" name="total_customer_payable_amount" value="{{ $total_payable_amount }}">
                  
                </td>
              </tr>
        @endif
   
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
        RECEIVED FROM JULMAR COMMERCIAL, INC. (<b>{{ $sales_order_printed->principal->principal }}</b>)<br />
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
  <input type="hidden" id="sales_order_printed_id" value="{{ $sales_order_printed->id }}">
</form>


<script src="{{ asset('adminLte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
// window.print();
// window.onafterprint = function(){
//    window.close();
// }
</script>