<form id="sales_order_upload_save">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="2" style="text-align: center;">
          {{ $store_name }}
          <input type="hidden" name="sales_order_number" value="{{ $sales_order_number }}">
          <input type="hidden" name="customer_id" value="{{ $customer_id }}">
          <input type="hidden" name="agent_id" value="{{ $agent_id }}">
          <input type="hidden" name="principal_id" value="{{ $principal_id }}">
          <input type="hidden" name="mode_of_transaction" value="{{ $mode_of_transaction }}">
          <input type="hidden" name="sku_type" value="{{ $sku_type }}">
          <input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
          <input type="hidden" name="store_code" value="{{ $customer_principal_code->store_code }}">
        </th>
        <th style="text-align: center;">
          {{ $delivery_receipt }}
        </th>
        <th style="text-align: center;">
          {{ $location }}
        </th>
         <th style="text-align: center;">
          {{ $customer_principal_code->store_code }}
        </th>
        <th style="text-align: center;">
          {{ $principal }}
        </th>
        <th style="text-align: center;">
          {{ $mode_of_transaction }}
        </th>
        <th  style="text-align: center;text-transform: uppercase;">
          {{ $sku_type }}
        </th>
      </tr>
      <tr>
        <th style="text-align: center;">CODE</th>
        <th style="text-align: center;">DESCRIPTION</th>
        <th style="text-align: center;">FINAL QUANTITY</th>
        <th style="text-align: center;">PRICE</th>
        <th style="text-align: center;">AMOUNT</th>
        @if(array_sum($line_discount_rate_1) != 0)
          <th style="text-align: center;">LINE DISCOUNT 1</th>
        @endif
        @if(array_sum($line_discount_rate_2) != 0)
          <th style="text-align: center;">LINE DISCOUNT 2</th>
        @endif
        @if(array_sum($line_discount_rate_1) AND array_sum($line_discount_rate_2) != 0)
          <th style="text-align: center;">SUB - TOTAL</th>
        @elseif(array_sum($line_discount_rate_1) != 0)
          <th style="text-align: center;" colspan="2">SUB - TOTAL</th>
        @elseif(array_sum($line_discount_rate_2) != 0)
          <th style="text-align: center;" colspan="2">SUB - TOTAL</th>
        @else
          <th style="text-align: center;" colspan="3">SUB - TOTAL</th>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach($sku_data as $data)
          <tr>
            <td>
              {{ $sku_code[$data->id] }}
              <input type="hidden" name="sku[]" value="{{ $data->id }}">
            </td>
            <td>{{ $description[$data->id] }}</td>
            <td style="text-align: center">
              @php
                $sum_quantity[] = $final_quantity[$data->id];
              @endphp
              {{ $final_quantity[$data->id] }}
               <input type="hidden" name="quantity[{{ $data->id }}]" value="{{ $final_quantity[$data->id] }}">
               <input type="hidden" name="sku_type_per_sku[{{ $data->id }}]" value="{{ $data->sku_type }}">
               <input type="hidden" name="category_id[{{ $data->id }}]" value="{{ $data->category_id }}">
            </td>
            <td style="text-align: right;">
              @if($customer_principal_price->price_level == 'price_1')
                @php  
                  $price = $data->sku_price_details_one->price_1;
                @endphp
              @elseif($customer_principal_price->price_level == 'price_2')
                @php  
                  $price = $data->sku_price_details_one->price_2;
                @endphp
              @elseif($customer_principal_price->price_level == 'price_3')
                @php  
                  $price = $data->sku_price_details_one->price_3;
                @endphp
              @elseif($customer_principal_price->price_level == 'price_4')
                @php  
                  $price = $data->sku_price_details_one->price_4;
                @endphp
              @else
                @php  
                  $price = $data->sku_price_details_one->price_5;
                @endphp
              @endif
               <input type="hidden" name="price[{{ $data->id }}]" value="{{ $price }}">
              {{ number_format($price,2,".",",") }}
            </td>
            <td style="text-align: right;">
              @php
                $amount = $price * $final_quantity[$data->id];
                $sum_amount[] = $amount;
                echo number_format($amount,2,".",",")
              @endphp
              <input type="hidden" name="amount[{{ $data->id }}]" value="{{ $amount }}">
            </td>
             @if(array_sum($line_discount_rate_1) != 0)
                <td style="text-align: right;">
                  @php
                    $line_discount_1 = $amount * $line_discount_rate_1[$data->id] / 100;
                    $sum_line_discount_1_per_sku[] = $line_discount_1;
                    echo number_format($line_discount_1,2,".",",");
                  @endphp
                </td>
              @else 
                @php
                  $line_discount_1 = 0;
                  $sum_line_discount_1_per_sku[] = $line_discount_1;
                @endphp
              @endif


              @if(array_sum($line_discount_rate_2) != 0)
                <td style="text-align: right;">
                  @php
                    $line_discount_2 = ($amount - $line_discount_1) * $line_discount_rate_2[$data->id] / 100;
                    $sum_line_discount_2_per_sku[] = $line_discount_2;
                    echo number_format($line_discount_2,2,".",",");
                  @endphp
                </td>
              @else 
                @php
                  $line_discount_2 = 0;
                  $sum_line_discount_2_per_sku[] = $line_discount_2;
                @endphp
              @endif

            
              <td colspan="3" style="text-align: right">
                  @php
                    $sub_total = $amount - $line_discount_1 - $line_discount_2;
                    $sum_sub_total[] = $sub_total;
                  @endphp
                  {{  number_format($sub_total,2,".",",") }}
                  <input type="hidden" name="line_discount_1[{{ $data->id }}]" value="{{ $line_discount_1 }}">
                  <input type="hidden" name="line_discount_2[{{ $data->id }}]" value="{{ $line_discount_2 }}">
                  <input type="hidden" name="line_discount_rate_1[{{ $data->id }}]" value="{{ $line_discount_rate_1[$data->id] }}">
                  <input type="hidden" name="line_discount_rate_2[{{ $data->id }}]" value="{{ $line_discount_rate_2[$data->id] }}">
                  <input type="hidden" name="sub_total[{{ $data->id }}]" value="{{ $sub_total }}">
              </td>
          </tr>
      @endforeach
      <tr>
        <td colspan="4">TOTAL</td>
        <td style="text-align: right;font-weight: bold">{{  number_format(array_sum($sum_amount),2,".",",") }}</td>
        
        @if(array_sum($line_discount_rate_1) != 0)
        <td style="text-align: right;font-weight: bold">
          {{  number_format(array_sum($sum_line_discount_1_per_sku),2,".",",") }}
        </td>
        @endif
        
        @if(array_sum($line_discount_rate_2) != 0)
        <td style="text-align: right;font-weight: bold">
          {{  number_format(array_sum($sum_line_discount_2_per_sku),2,".",",") }}
        </td>
        @endif
        
        @if(array_sum($line_discount_rate_1) AND array_sum($line_discount_rate_2) != 0)
        <td style="text-align: right;font-weight: bold">
          {{  number_format(array_sum($sum_sub_total),2,".",",") }}
        </td>
        @elseif(array_sum($line_discount_rate_1) != 0)
        <td style="text-align: right;font-weight: bold" colspan="2">
          {{  number_format(array_sum($sum_sub_total),2,".",",") }}
        </td>
        @elseif(array_sum($line_discount_rate_2) != 0)
        <td style="text-align: right;font-weight: bold" colspan="2">
          {{  number_format(array_sum($sum_sub_total),2,".",",") }}
        </td>
        @else
        <td style="text-align: right;font-weight: bold" colspan="3">
          {{  number_format(array_sum($sum_sub_total),2,".",",") }}
        </td>
        @endif
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered table-hover table-sm">
    <thead>
      <tr>
        <td style="text-align: right;">QUANTITY:</td>
        <td>{{ array_sum($sum_quantity) }}</td>
        <td style="text-align: right;">TOTAL DR AMOUNT:</td>
        <td></td>
        <td style="text-align: right;">
          @php
          $total_dr_amount = array_sum($sum_amount);
          // $total_dr_amount_array[] = $total_dr_amount;
          @endphp
          {{ number_format($total_dr_amount,2,".",",") }}
        </td>
      </tr>
      <tr>
        <td style="text-align: right;"></td>
        <td></td>
        <td style="text-align: right;">TOTAL CATEGORY DISC:</td>
        <td></td>
        <td style="text-align: right;">
          @php
          $total_category_discount_amount = array_sum($sum_line_discount_1_per_sku) + array_sum($sum_line_discount_2_per_sku);
          echo number_format($total_category_discount_amount,2,".",",");
          @endphp
        </td>
      </tr>
      <tr>
        <td style="text-align: right;"></td>
        <td></td>
        <td style="text-align: right;">NET AMOUT</td>
        <td></td>
        <td style="text-align: right;">
          @php
          $total_for_dr_and_category_amount = $total_dr_amount - $total_category_discount_amount;
          @endphp
          {{ number_format($total_for_dr_and_category_amount,2,".",",") }}
          <input type="hidden" name="total_category_discount_amount" value="{{ $total_category_discount_amount }}">
        </td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td style="text-align: right;">LESS: CUSTOMER DISCOUNT:</td>
        <td></td>
        <td></td>
      </tr>
      @if($customer_discount == 0)
      <tr>
        <td style="text-align: right;"></td>
        <td></td>
        <td style="text-align: right;">CUSTOMER DISC</td>
        <td></td>
        <td style="text-align: right;">
          @php
          $total_for_dr_and_category_amount = $total_dr_amount - $total_category_discount_amount;
          @endphp
          {{ number_format($total_for_dr_and_category_amount,2,".",",") }}
          <input type="hidden" name="total_category_discount_amount" value="{{ $total_category_discount_amount }}">
        </td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td><span class="float-right">TOTAL CUSTOMER DISC: </span></td>
        <td></td>
        <td style="text-align: right;">
          @php
          $total_customer_discount_amount = array_sum($deducted_total_history);
          $total_category_discount_per_sku_array[] = $total_customer_discount_amount;
          @endphp
          <input type="hidden" name="customer_discount_rate[]" value="{{ 0 }}">
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
        <td></td>
        <td></td>
        <td style="text-align: right;"><span class="float-right">CUSTOMER DISC {{ $customer_discount[$i] / 100 }}</span></td>
        <td style="text-align: right;">
          @php
          $deducted_total_dummy = $deducted_total;
          $less_percentage_by = ($customer_discount[$i] / 100);
          $deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
          $answer = round($deducted_total_dummy * $less_percentage_by,2);
          $deducted_total_history[] = $answer;
          @endphp
          {{ number_format($answer,2,".",",") }}
          <input type="hidden" name="customer_discount_rate[]" value="{{ $customer_discount[$i] }}">
        </td>
      </tr>
      @endfor
      <tr>
        <td></td>
        <td></td>
        <td style="text-align: right;"><span class="float-right">TOTAL CUSTOMER DISC: </span></td>
        <td></td>
        <td style="text-align: right;">
          @php
          $total_customer_discount_amount = array_sum($deducted_total_history);
          $total_category_discount_per_sku_array[] = $total_customer_discount_amount;
          @endphp
        </td>
      </tr>
      @endif
      <tr>
        <td></td>
        <td></td>
        <td style="text-align: right;"><span class="float-right">TOTAL PAYABLE AMOUNT: </span></td>
        <td></td>
        <td style="text-align: right;">
          @php
          $total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
          @endphp
          {{  number_format($total_payable_amount,2,".",",") }}
          <input type="hidden" name="total_amount" value="{{ $total_payable_amount }}">
          <input type="hidden" name="total_customer_discount_amount" value="{{ $total_customer_discount_amount }}">
        </td>
      </tr>
    </thead>
  </table>
  <table class="table table-bordered table-hover table-sm" style="border:none;">
    <thead>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td></td>
        <td><span class="float-right">VATABLE AMOUNT:</span></td>
        <td style="text-align: right;">
          @php
          $vatable_amount = $total_payable_amount / 1.12;
          @endphp
          {{ number_format($vatable_amount,2,".",",") }}
          <input type="hidden" name="vatable_amount" value="{{ $vatable_amount }}">
        </td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td></td>
        <td><span class="float-right">VAT AMOUNT:</span></td>
        <td style="text-align: right;">
          @php
          $vat_amount = $vatable_amount * 0.12;
          @endphp
          {{ number_format($vat_amount,2,".",",") }}
          <input type="hidden" name="vat_amount" value="{{ $vat_amount }}">
        </td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td></td>
        <td><span class="float-right">TOTAL DR AMOUNT:</span></td>
        <td style="text-align: right;">
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
        <th style="text-align: right;">
          {{ number_format($total_vatable_dr_amount,2,".",",") }}
          <input type="hidden" name="accounts_receivable" value="{{ $total_vatable_dr_amount }}">
        </th>
        <th></th>
        <th></th>
      </tr>
      <tr>
        <th></th>
        <th></th>
        <th style="text-align: center;">VAT PAYABLE </th>
        <th style="text-align: right;">
          {{ number_format($vat_amount,2,".",",") }}
          <input type="hidden" name="vat_amount" value="{{ $vat_amount }}">
        </th>
      </tr>
      <tr>
        <th></th>
        <th></th>
        <th style="text-align: center;">SALES </th>
        <th style="text-align: right;">
          {{ number_format($vatable_amount,2,".",",") }}
          <input type="hidden" name="sales" value="{{ $vatable_amount }}">
        </th>
      </tr>
    </thead>
  </table>

  <div class="form-group">
    <button type="submit" class="btn btn-success btn-block">SUBMIT INVOICE</button>
  </div>

</form>

<script type="text/javascript">
   $("#sales_order_upload_save").on('submit',(function(e){
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
            if(data == 'save'){
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved, Reloading Page!',
                showConfirmButton: false,
                timer: 1500
              })

              location.reload();
            }else{
              Swal.fire(
                'ERROR',
                'SOMETHING WENT WRONG, CONTACT SIDNEY',
                'ERROR'
              )
              $('.loading').hide(); 
            }
          },
        });
    }));

</script>