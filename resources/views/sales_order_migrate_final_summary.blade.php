<form id="save_form">
      <center>
        <h4>JULMAR COMMERCIAL INC.</h4>
        <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
        <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
      </center>
        <br />
        <h5 style="text-align: center;font-weight: bold;">Delivery Receipt</h5>

        <table class="table table-borderless" style="border:none;"> {{-- class='table table-borderless' --}}
          <thead>
            <tr>
              <th  style="width:20%;line-height:0px"><span class="float-right">Bill To:</span></th>
              <th  style="width:30%;line-height:0px;text-transform: uppercase;">{{ $store_name }}</th>
              <th  style="width:20%;line-height:0px"><span class="float-right">Dr Number:</span></th>
              <th  style="width:30%;line-height:0px">{{ $delivery_receipt }}</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="line-height:0px;"><span class="float-right">Store Code:</span></td>
              <td style="line-height:0px;">{{ $store_code }}</td>
              <td style="line-height:0px;"><span class="float-right">DR Date :</span></td>
              <td style="line-height:0px;">{{ $date }}</td>
            </tr>
            <tr>
              <td style="line-height:0px;"><span class="float-right">Address:</span></td>
              <td style="line-height:0px;">{{ ucfirst($detailed_location) }}</td>
              <td style="line-height:0px;"><span class="float-right">SO No:</span></td>
              <td style="line-height:0px;">{{ $sales_order_number }}</td>
            </tr>
            <tr>
              <td style="line-height:0px;"><span class="float-right">Area:</span></td>
              <td style="line-height:0px;">{{ ucfirst($store_location) }}</td>
              <td style="line-height:0px;"><span class="float-right">CUSTOMER PO NO::</span></td>
              <td style="line-height:0px;">N/a</td>
            </tr>
            <tr>
              <td colspan="4"></td>
            </tr>
            <tr>
              <td style="line-height:0px;"><span class="float-right">Transaction:</span></td>
              <td style="line-height:0px;">{{ $method }}

              </td>
              <td style="line-height:0px;"><span class="float-right">Salesman:</span></td>
              <td style="line-height:0px;">{{ $salesman }}</td>
            </tr>
            <tr>
              <td style="line-height:0px;"></td>
              <td style="line-height:0px;"></td>
              <td style="line-height:0px;"><span class="float-right">Payment Terms:</span></td>
              <td style="line-height:0px;">{{ $credit_term_days }}</td>
            </tr>
            <tr>
              <td style="line-height:0px;"></td>
              <td style="line-height:0px;"></td>
              <td style="line-height:0px;"><span class="float-right">Due Date:</span></td>
              <td style="line-height:0px;">{{ $due_date }}</td>
            </tr>
          </tbody>
        </table>

        <input type="hidden" name="store_code" value={{ $store_code }}>
        <input type="hidden" name="sales_order_number" value="{{ $sales_order_number }}">
        <input type="hidden" name="sales_order_id" value="{{ $sales_order_id }}">
        <input type="hidden" name="principal_id" value="{{ $principal_id }}">
        <input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
        <input type="hidden" name="mode_of_transaction" value="{{ $method }}">
        <input type="hidden" name="price_level" value="{{ $price_level }}">
        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
        <input type="hidden" name="agent_id" value="{{ $agent_id }}">
        <input type="hidden" name="store_name" value="{{ $store_name }}">
        <input type="hidden" name="detailed_location" value="{{ $detailed_location }}">
        <input type="hidden" name="store_location" value="{{ $store_location }}">
        <input type="hidden" name="salesman" value="{{ $salesman }}">
        <input type="hidden" name="credit_term_days" value="{{ $credit_term_days }}">
        <input type="hidden" name="credit_line_amount" value="{{ $credit_line_amount }}">
        <input type="hidden" name="credit_line_balance" value="{{ $credit_line_balance }}">
        <input type="hidden" name="accounts_receivable_end" value="{{ $accounts_receivable_end }}">

    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
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
              <th style="text-align: center;color:green;">Total<br />Category<br />Disc</th>
              <th style="text-align: center;color:green;">Net<br />Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach(array_combine($sku_id, $sku_code) as $sku_data_id => $sku_data_code)
            @if($final_ordered_quantity[$sku_data_code] != 0)
            <tr>
              <td style="text-align: center;">
                {{ $sku_data_code }}
                <input type="hidden" name="sku_code[]" value={{ $sku_data_code }}>
              </td>
              <td style="text-align: center;">
                {{ $description[$sku_data_code] }}
                <input type="hidden" name="description[{{ $sku_data_code }}]" value="{{ $description[$sku_data_code] }}">
              </td>
              <td style="text-align: center;">
                {{ $final_ordered_quantity[$sku_data_code] }}
                <input type="hidden" name="final_ordered_quantity_to_print[{{ $sku_data_code }}]" value="{{ $final_ordered_quantity[$sku_data_code] }}">
              </td>
              <td style="text-align: right;">
                {{ number_format($price[$sku_data_code],2,".",",") }}
                <input type="hidden" name="price_to_print[{{ $sku_data_code }}]" value="{{ $price[$sku_data_code] }}">
              </td>
              <td style="text-align: right;">
                @php
                $total_amount_price_x_quantity = $price[$sku_data_code] * $final_ordered_quantity[$sku_data_code];
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
                <input type="hidden" name="category_discount_rate_1[{{ $sku_data_id }}]" value="{{ $cd_rate_1[$sku_data_code] }}">
                <input type="hidden" name="category_discount_rate_2[{{ $sku_data_id }}]" value="{{ $cd_rate_2[$sku_data_code] }}">
                <input type="hidden" name="category_discount_rate_3[{{ $sku_data_id }}]" value="{{ $cd_rate_3[$sku_data_code] }}">
                <input type="hidden" name="category_discount_rate_4[{{ $sku_data_id }}]" value="{{ $cd_rate_4[$sku_data_code] }}">

                <input type="hidden" name="sku_id[]" value="{{ $sku_data_id }}">
                <input type="hidden" name="category_id[{{ $sku_data_id }}]" value="{{ $category_id[$sku_data_id] }}">
                <input type="hidden" name="sku_type[{{ $sku_data_id }}]" value="{{ $sku_type[$sku_data_id] }}">
                <input type="hidden" name="final_ordered_quantity_to_save[{{ $sku_data_id }}]" value="{{ $final_ordered_quantity[$sku_data_code] }}">

                <input type="hidden" name="final_amount_per_sku[{{ $sku_data_id }}]" value="{{ $final_net_amount_per_sku }}">

                <input type="hidden" name="final_unit_cost_ledger[{{ $sku_data_id }}]" value="{{ $final_unit_cost_from_ledger[$sku_data_id] }}">
                <input type="hidden" name="price_per_sku[{{ $sku_data_id }}]" value="{{ $price[$sku_data_code] }}">
                <input type="hidden" name="final_category_discount_amount_per_sku[{{ $sku_data_id }}]" value="{{ $final_category_discount_amount_per_sku }}">
              </td>
            </tr>
            @else
            @endif
            
            
            @endforeach
            <tr>
              <td colspan="4"></td>
              
              <td style="text-align: right;font-weight: bold;color:green;">{{ number_format(array_sum($total_amount_price_x_quantity_array),2,".",",")  }}</td>
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
              <td style="text-align: right;font-weight: bold;color:green;">
                {{  number_format(array_sum($total_category_discount_array),2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold;color:green;">
                {{  number_format(array_sum($final_net_amount_per_sku_array),2,".",",") }}
                
              </td>
            </tr>
            {{-- <tr>
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
              <td style="text-align:center;font-weight: bold;">Total<br />Customer<br />Disc</td>
              <td></td>
            </tr> --}}
            {{-- @php
            $total = array_sum($final_net_amount_per_sku_array);
            $taas = $total;
            $taas_history = [];
            @endphp
            @for ($i=0; $i < $customer_discount_counter; $i++)
            <tr>
              
              <td colspan="5" style="text-align: center;  ">Disc Rate {{ $customer_discount[$i]/100 }}</td>
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
              @php
              $taas_dummy = $taas;
              $less_percentage_by_taas = ($customer_discount[$i] / 100);
              $taas = $taas_dummy - ($taas_dummy * $less_percentage_by_taas);
              $answer = round($taas_dummy * $less_percentage_by_taas,2);
              $taas_history[] = $answer;
              @endphp
              <td style="text-align: right;font-weight: bold;">
                {{ number_format($answer,2,".",",") }}
              </td>
              <td style="text-align: right;font-weight: bold;">
                {{ number_format($taas_dummy,2,".",",") }}
              </td>
              
            </tr>
            @endfor --}}
            {{-- <tr>
              <td colspan="5" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
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
              <td style="text-align: right;font-weight: bold;color:green;">{{ number_format(array_sum($taas_history),2,".",",") }} </td>
              <td style="text-align: right;font-weight: bold;color:green;">{{ number_format(array_sum($final_net_amount_per_sku_array) - array_sum($taas_history),2,".",",")  }}</td>
              <td style="text-align: right;font-weight: bold;color:green;">{{ number_format(array_sum($final_net_amount_per_sku_array),2,".",",")  }}</td>
            </tr> --}}
          </tbody>
        </table>
    </div>

    <table class="table table-borderless" style="border:none;">
        <thead>
          <tr>
            <td style="line-height:0px;font-weight: bold;"><span class="float-right">QUANTITY:</span></td>
            <td style="line-height:0px;font-weight: bold;">
              @php
              $sumArray = array();
              foreach ($sku_code as $key => $data){
              $sumArray[] += $final_ordered_quantity[$data];
              }
              echo array_sum($sumArray);
              @endphp
            </td>
            <td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL DR AMOUNT: </span></td>
            <td style="line-height: 0px;"></td>
            <td style="line-height:0px;font-weight: bold;">
              @php
              $total_dr_amount = array_sum($total_category_discount_array) + array_sum($final_net_amount_per_sku_array);
              $total_dr_amount_array[] = $total_dr_amount;
              @endphp
              {{ number_format($total_dr_amount,2,".",",") }}
            </td>
          </tr>
          <tr>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL CATEGORY DISC: </span></td>
            <td style="line-height: 0px;"></td>
            <td style="line-height:0px;font-weight: bold;">
              @php
              $total_category_discount_amount = array_sum($total_category_discount_array);
              $total_category_discount_array[] = $total_category_discount_amount;
              @endphp
              <input type="hidden" name="total_category_discount_amount" value="{{ $total_category_discount_amount }}">
              {{ number_format($total_category_discount_amount,2,".",",") }}
            </td>
          </tr>
          <tr>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;font-weight: bold;"><span class="float-right">NET AMOUNT</span></td>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;font-weight: bold;text-decoration:overline;">
              @php
              $total_for_dr_and_category_amount = $total_dr_amount - $total_category_discount_amount;
              @endphp
              {{ number_format($total_for_dr_and_category_amount,2,".",",") }}
              
            </td>
          </tr>
          <tr>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;font-weight: bold;"><span class="float-right">LESS: CUSTOMER DISCOUNT</span></td>
            <td style="line-height:0px;"></td>
          </tr>
          @if($customer_discount_counter == 0)
              <tr>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;font-weight: bold;"><span class="float-right">CUSTOMER DISC</span></td>
                
                <td style="line-height:0px;font-weight: bold;">
                  @php
                   echo $answer = 0.00;
                   $deducted_total_history[] = $answer;
                  @endphp
                  <input type="hidden" name="customer_discount_rate[]" value="{{ 0 }}">
                  <input type="hidden" name="customer_discount_to_print[]" value="{{ 0 }}">
                  <input type="hidden" name="customer_discount_counter" value="{{ 0 }}">
                </td>
              </tr>
              <tr>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL CUSTOMER DISC: </span></td>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;font-weight: bold;">
                  @php
                  $total_customer_discount_amount = array_sum($deducted_total_history);
                  $total_category_discount_per_sku_array[] = $total_customer_discount_amount;
                  @endphp
                  <input type="hidden" name="total_customer_discount_amount" value="{{ $total_customer_discount_amount }}">
                  {{ number_format($total_customer_discount_amount,2,".",",") }}
                </td>
              </tr>
              <tr>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL PAYABLE AMOUNT: </span></td>
                <td style="line-height:0px;font-weight: bold;">
                  
                </td>
                <td style="line-height:0px;font-weight: bold;text-decoration:overline;">
                  @php
                  $total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
                  @endphp
                  {{  number_format($total_payable_amount,2,".",",") }}
                  <input type="hidden" name="total_customer_payable_amount" value="{{ $total_payable_amount }}">
                  
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
                  <td style="line-height:0px;"></td>
                  <td style="line-height:0px;"></td>
                  <td style="line-height:0px;font-weight: bold;"><span class="float-right">CUSTOMER DISC {{ $customer_discount[$i] / 100 }}</span></td>
                  
                  <td style="line-height:0px;font-weight: bold;">
                    @php
                    $deducted_total_dummy = $deducted_total;
                    $less_percentage_by = ($customer_discount[$i] / 100);
                    $deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
                    echo $answer = round($deducted_total_dummy * $less_percentage_by,2);
                    $deducted_total_history[] = $answer;
                    @endphp
                    <input type="hidden" name="customer_discount_rate[]" value="{{ $customer_discount[$i] }}">
                    <input type="hidden" name="customer_discount_to_print[]" value="{{ $customer_discount[$i] }}">
                    <input type="hidden" name="customer_discount_counter" value="{{ $customer_discount_counter }}">
                  </td>
                </tr>
              @endfor
              <tr>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL CUSTOMER DISC: </span></td>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;font-weight: bold;">
                  @php
                  $total_customer_discount_amount = array_sum($deducted_total_history);
                  $total_category_discount_per_sku_array[] = $total_customer_discount_amount;
                  @endphp
                  <input type="hidden" name="total_customer_discount_amount" value="{{ $total_customer_discount_amount }}">
                  {{ number_format($total_customer_discount_amount,2,".",",") }}
                </td>
              </tr>
              <tr>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;"></td>
                <td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL PAYABLE AMOUNT: </span></td>
                <td style="line-height:0px;font-weight: bold;">
                  
                </td>
                <td style="line-height:0px;font-weight: bold;text-decoration:overline;">
                  @php
                  $total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
                  @endphp
                  {{  number_format($total_payable_amount,2,".",",") }}
                  <input type="hidden" name="total_customer_payable_amount" value="{{ $total_payable_amount }}">
                  
                </td>
              </tr>
          @endif
         
        </thead>
    </table>

    <br />
    <table class="table table-borderless" style="border:none;">
        <thead>
          <tr>
            <td style="line-height:0px;font-weight: bold;"><span class="float-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
            <td style="line-height:0px;font-weight: bold;">
              
            </td>
            <td style="line-height:0px;font-weight: bold;"><span class="float-right">VATABLE AMOUNT </span></td>
            <td style="line-height: 0px;"></td>
            <td style="line-height:0px;font-weight: bold;">
              @php
                $vatable_amount = $total_payable_amount / 1.12;
              @endphp 
              {{ number_format($vatable_amount,2,".",",") }}
              <input type="hidden" name="vatable_amount" value="{{ $vatable_amount }}">
            </td>
          </tr>
          <tr>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;font-weight: bold;"><span class="float-right">VAT AMOUNT</span></td>
            <td style="line-height: 0px;"></td>
            <td style="line-height:0px;font-weight: bold;">
              @php
                $vat_amount = $vatable_amount * 0.12;
              @endphp
              {{ number_format($vat_amount,2,".",",") }}
              <input type="hidden" name="vat_amount" value="{{ $vat_amount }}">
            </td>
          </tr>
          <tr>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL DR AMOUNT</span></td>
            <td style="line-height:0px;"></td>
            <td style="line-height:0px;font-weight: bold;text-decoration:overline;">
              @php
              $total_vatable_dr_amount = $vatable_amount + $vat_amount;
              @endphp
              {{ number_format($total_vatable_dr_amount,2,".",",") }}
              
            </td>
          </tr>
        
        </thead>
    </table>  

    <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th colspan="4" style="text-align: center;font-weight: bold;">SALES TRANSACTION JOURNAL ENTRY</th>
          </tr>
          <tr>
            <th></th>
            <th style="text-align: center;">DEBIT</th>
            <th></th>
            <th style="text-align: center;">CREDIT</th>
          </tr>
          <tr>
            <th style="text-align: center;text-transform: uppercase;">ACCOUNTS RECEIVABLE - {{ $store_name }}</th>
            <th style="text-align: right;">{{ number_format($total_vatable_dr_amount,2,".",",") }}</th>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th style="text-align: center;">VAT PAYABLE </th>
            <th style="text-align: right;">{{ number_format($vat_amount,2,".",",") }}</th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th style="text-align: center;">SALES </th>
            <th style="text-align: right;">{{ number_format($vatable_amount,2,".",",") }}</th>
          </tr>
        </thead>
    </table>

    <div class="container float-left" style="width:50%;" >
        <i>RECEIVED FROM JULMAR COMMERCIAL, INC. (GREEN CROSS DIVISION)<br />
        THE FOLLOWING MERCHANDISE AS ORDERED ABOVE IN GOOD ORDER<br />
        AND MERCHANTIBLE CONDITION</i>
    </div>
    <table class="table table-borderless" style="border:none;">
        <thead>
          <tr>
            <th>Prepared By:</th>
            <th>Released By:</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Delivered By:</th>
            <th>Received By/Customer:</th>
          </tr>
          <tr>
            <tr>
              <td><u>{{ $employee_name->name }}</u></td>
              <td>_______________________________</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>_______________________________</td>
              <td>_______________________________</td>
            </tr>
          </tr>
        </thead>
    </table>
      
    <input type="submit" value="SALES ORDER SAVED / PRINT" class="btn btn-block btn-success" />
</form>

<script type="text/javascript">
  $("#save_form").on('submit',(function(e){
        e.preventDefault();
         $('.loading').show();
          $.ajax({
            url: "sales_order_upload_save",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              console.log(data);

              if (data == 'Sales Invoice Control') {
                Swal.fire(
                  'Printing ' + data,
                  '',
                  'success'
                  )
                  // $('.loading').hide();
                  $('#sales_order_migrate_final_summary_page').hide();
                  $('#sales_order_migrate_summary_page').hide();
                  jQuery('#upload_agent_sales_order').trigger('click');
              return false;
              }else if(data == 'exceeding credit limit'){
                Swal.fire(
                  'Cannot Save, Credit Limit Exceeded ',
                  '',
                  'error'
                  )
              }else{
                Swal.fire(
                  'Continue printing ' + data + ' orders',
                  '',
                  'success'
                  )
                  // $('.loading').hide();
                  $('#sales_order_migrate_final_summary_page').hide();
                  $('#sales_order_migrate_summary_page').hide();
                  jQuery('#upload_agent_sales_order').trigger('click');
              return false;
              }

             
            },
          });
      }));
</script>