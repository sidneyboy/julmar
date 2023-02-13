


  @if($sales_order_printed->status_cancel != 'cancelled')
   
    

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#exampleModal">
      CANCEL DR
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">OM ACCESS KEY</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="sales_invoicing_cancel_dr">
            <div class="modal-body">
              <input type="password" name="om_secret_key" required class="form-control"> 
              <input type="hidden" name="sales_order_print_id" value="{{ $sales_order_printed->id }}">
              <input type="hidden" name="customer_id" value="{{ $sales_order_printed->customer_id }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button class="btn btn-danger btn-block" type="submit">CANCEL DR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @else
    <p class="float-right" style="color:red;font-weight: bold;">DR CANCELLED</p>
  @endif
  <br /><br />
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


        <table class="table table-bordered table-hover">
          <thead>
              <tr>
      	        <th style="text-align: center;">CODE</th>
      	        <th style="text-align: center;">DESCRIPTION</th>
      	        <th style="text-align: center;">FINAL QUANTITY</th>
      	        <th style="text-align: center;">PRICE</th>
      	        <th style="text-align: center;">AMOUNT</th>
      	        @if($sales_order_printed->total_line_discount_1 != 0)
      	          <th style="text-align: center;">LINE DISCOUNT 1</th> 
      	        @endif
      	        @if($sales_order_printed->total_line_discount_2 != 0)
      	          <th style="text-align: center;">LINE DISCOUNT 2</th>
                
                 
      	        @endif

                @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
                   <th style="text-align: center;">TOTAL LINE DISCOUNT</th>
                @endif

              


      	        @if($sales_order_printed->line_discount_1 AND $sales_order_printed->line_discount_2 != 0)
      	          <th style="text-align: center;">SUB - TOTAL</th>
      	        @elseif($sales_order_printed->line_discount_1 != 0)
      	          <th style="text-align: center;" colspan="2">SUB - TOTAL</th>
      	        @elseif($sales_order_printed->line_discount_2 != 0)
      	          <th style="text-align: center;" colspan="2">SUB - TOTAL</th>
      	        @else
      	          <th style="text-align: center;" colspan="3">SUB - TOTAL</th>
      	        @endif
      	      </tr>
          </thead>
          <tbody>
          	@foreach($sales_order_printed->sales_order_print_details as $details)
	          	@if($details->quantity != 0)
                <tr>
                  <td>{{ $details->sku->sku_code }}</td>
                  <td>{{ $details->sku->description }}</td>
                  <td>
                    @php
                      $sum_quantity[] = $details->quantity;
                    @endphp
                    {{ $details->quantity }}
                  </td>
                  <td>{{ number_format($details->price,2,".",",") }}</td>
                  <td>
                    @php
                      $amount_per_sku = $details->quantity * $details->price;
                      $sum_amount_per_sku[] = $amount_per_sku;
                      echo number_format($amount_per_sku,2,".",",")
                    @endphp
                  </td>

                  @if($sales_order_printed->total_line_discount_1 != 0)
                     @if($details->line_discount_1 == 0)
                        <td style="text-align: right;">
                          @php
                             echo $line_discount_1 = 0;
                          @endphp
                        </td>
                      @else
                        <td style="text-align: right;">
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
                      <td style="text-align: right;">
                        @php
                          echo $line_discount_2 = 0;
                        @endphp
                      </td>
                    @else
                      <td style="text-align: right;">
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
                    <td style="text-align: right">
                      @php
                        $total_line_discount_amount = $line_discount_1 + $line_discount_2;
                        echo number_format($total_line_discount_amount,2,".",",");
                        $total_category_discount_array[] = $total_line_discount_amount;
                      @endphp
                    </td>
                  @else
                      @php
                        $total_line_discount_amount = 0;
                        $total_category_discount_array[] = $total_line_discount_amount;
                      @endphp
                  @endif

              
                  

                  <td style="text-align: right;font-weight: bold;">
                    @php
                      $final_net_amount_per_sku =  $details->sub_total;
                      $final_net_amount_per_sku_array[] = $final_net_amount_per_sku;
                      echo number_format($final_net_amount_per_sku,2,".",",");
                    @endphp
                  </td>
                </tr>
              @else

              @endif
	          @endforeach
              <tr>
                <td colspan="4"></td>
                <td>{{ number_format(array_sum($sum_amount_per_sku),2,".",",") }}</td>
                @if($sales_order_printed->total_line_discount_1 != 0)
                  <td></td>
                @else
                 
                @endif
                @if($sales_order_printed->total_line_discount_2 != 0)
                  <td></td>
                @else
                 
                @endif
                @if($sales_order_printed->total_line_discount_1 != 0 OR $sales_order_printed->total_line_discount_2 != 0)
                  <td style="text-align: right;font-weight: bold;color:green;">
                    {{  number_format($sales_order_printed->total_line_discount,2,".",",") }}
                  </td>
                @else

                @endif
                <td style="text-align: right;font-weight: bold;color:green;">
                  {{  number_format(array_sum($sum_amount_per_sku) - $sales_order_printed->total_line_discount,2,".",",") }}
                  
                </td>
              </tr>
          </tbody>
        </table>

       @php
            $customer_discount_rate = explode('-', $sales_order_printed->customer_discount_rate);
            $customer_discount_counter = count($customer_discount_rate);
       @endphp
       <table class="table table-bordered table-sm table-hover">
        <thead>
          <tr>
            <th style="text-align: right;">QUANTITY:</th>
            <th style="text-align: left">
              @php
              echo array_sum($sum_quantity);
              @endphp
            </th>
            <th style="text-align: right;">TOTAL DR AMOUNT:</th>
            <th></th>
            <th style="text-align: right;">
              @php
              $total_dr_amount = array_sum($sum_amount_per_sku);
              $total_dr_amount_array[] = $total_dr_amount;
              @endphp
              {{ number_format($total_dr_amount,2,".",",") }}
            </th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th style="text-align: right;">TOTAL CATEGORY DISC:</th>
            <th></th>
            <th style="text-align: right;">
              @php
                $total_category_discount_amount = array_sum($total_category_discount_array);
                $total_category_discount_array[] = $total_category_discount_amount;
                @endphp
                {{ number_format($total_category_discount_amount,2,".",",") }}
            </th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th style="text-align: right;">NET AMOUNT:</th>
            <th></th>
            <th style="text-align: right;">
                @php
                $total_for_dr_and_category_amount = $total_dr_amount - $total_category_discount_amount;
                @endphp
                {{ number_format($total_for_dr_and_category_amount,2,".",",") }}
            </th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th style="text-align: right;">LESS: CUSTOMER DISCOUNT</th>
            <th></th>
            <th></th>
          </tr>
          @if($customer_discount_counter == 0)
            <tr>
              <th></th>
              <th></th>
              <th style="text-align: right;">CUSTOMER DISC</th>
              <th></th>
              <th>
                @php
                echo $answer = 0.00;
                $deducted_total_history[] = $answer;
                @endphp
              </th>
            </tr>
            <tr>
              <th></th>
              <th></th>
              <th style="text-align: right;">TOTAL CUSTOMER DISC:</th>
              <th></th>
              <th style="text-align: right;">
                @php
                $total_customer_discount_amount = array_sum($deducted_total_history);
                $total_category_discount_per_sku_array[] = $total_customer_discount_amount;
                @endphp
                
                {{ number_format($total_customer_discount_amount,2,".",",") }}
              </th>
            </tr>
            <tr>
              <th></th>
              <th></th>
              <th style="text-align: right;">TOTAL PAYABLE AMOUNT:</th>
              <th></th>
              <th style="text-align: right;">
                @php
                $total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
                @endphp
                {{  number_format($total_payable_amount,2,".",",") }}
              </th>
            </tr>
          @else
            @php
              $total = $total_for_dr_and_category_amount;
              $deducted_total = $total;
              $deducted_total_history = [];
            @endphp
            @for ($i=0; $i < $customer_discount_counter; $i++)
            <tr>
              <th></th>
              <th></th>
              <th style="text-align: right;">
                <span class="float-right">CUSTOMER DISC {{ $customer_discount_rate[$i] / 100 }}</span>
              </th>
              <th style="text-align: right;">
                @php
                  $deducted_total_dummy = $deducted_total;
                  $less_percentage_by = ($customer_discount_rate[$i] / 100);
                  $deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
                  echo $answer = round($deducted_total_dummy * $less_percentage_by,2);
                  $deducted_total_history[] = $answer;
                @endphp
              </th>
              <th></th>
            </tr>
            @endfor
            <tr>
              <th></th>
              <th></th>
              <th style="text-align: right;">
                TOTAL CUSTOMER DISC:
              </th>
              <th >
              </th>
              <th style="text-align: right;">
                @php
                  $total_customer_discount_amount = array_sum($deducted_total_history);
                  $total_category_discount_per_sku_array[] = $total_customer_discount_amount;
                @endphp
                <input type="hidden" name="total_customer_discount_amount" value="{{ $total_customer_discount_amount }}">
                {{ number_format($total_customer_discount_amount,2,".",",") }}
              </th>
            </tr>
            <tr>
              <th></th>
              <th></th>
              <th style="text-align: right;">
                TOTAL PAYABLE AMOUNT:
              </th>
              <th >
              </th>
              <th style="text-align: right;">
                @php
                  $total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
                @endphp
                {{  number_format($total_payable_amount,2,".",",") }}
                <input type="hidden" name="total_customer_payable_amount" value="{{ $total_payable_amount }}">
              </th>
            </tr>
          @endif
        </thead>
       </table>

       <table class="table table-bordered table-sm">
         <thead>
            <tr>
              <th></th>
              <th></th>
              <th style="text-align: right;">VATABLE AMOUNT:</th>
              <th></th>
              <th style="text-align: right;">
                @php
                $vatable_amount = $total_payable_amount / 1.12;
              @endphp 
              {{ number_format($vatable_amount,2,".",",") }}
              <input type="hidden" name="vatable_amount" value="{{ $vatable_amount }}">
              </th>
            </tr>

            <tr>
              <th></th>
              <th></th>
              <th style="text-align: right;">VAT AMOUNT:</th>
              <th></th>
              <th style="text-align: right;">
                 @php
                  $vat_amount = $vatable_amount * 0.12;
                  @endphp
                {{ number_format($vat_amount,2,".",",") }}
                <input type="hidden" name="vat_amount" value="{{ $vat_amount }}">
              </th>
            </tr>

            <tr>
              <th></th>
              <th></th>
              <th style="text-align: right;">TOTAL DR AMOUNT:</th>
              <th></th>
              <th style="text-align: right;">
                 @php
              $total_vatable_dr_amount = $vatable_amount + $vat_amount;
              @endphp
              {{ number_format($total_vatable_dr_amount,2,".",",") }}
              </th>
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
            <th style="text-align: center;text-transform: uppercase;">ACCOUNTS RECEIVABLE - {{ $sales_order_printed->customer->store_name }}</th>
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
              <input type="hidden" name="vatable_amount" value="{{ $vatable_amount }}">
            </th>
          </tr>
        </thead>
    </table>

    <div class="container float-left" style="width:50%;" >
        <i>RECEIVED FROM JULMAR COMMERCIAL, INC. (<span style="color:blue;font-weight: bold;">{{ $sales_order_printed->principal->principal }}</span>)<br />
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

   
    @if($sales_order_printed->status_cancel == 'cancelled')
      
    @elseif($sales_order_printed->remarks == 'printed' )
        <button type="button" class="btn-warning btn-block" data-toggle="modal" data-target="#reprint_dr">
          RE PRINT INVOICE
        </button>

        <!-- Modal -->
        <div class="modal fade" id="reprint_dr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">OM ACCESS KEY</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="sales_invoicing_reprint_dr">
                <div class="modal-body">
                  <input type="password" name="om_secret_key" required class="form-control"> 
                  <input type="hidden" name="sales_order_print_id" value="{{ $sales_order_printed->id }}">
                  <input type="hidden" name="customer_id" value="{{ $sales_order_printed->customer_id }}">
                
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button class="btn btn-warning btn-block" type="submit">UPDATE DR STATUS</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    @else
       <a href="{{ route('sales_invoicing_print_dr', $input) }}" class="btn btn-success btn-block" target="_blank">PRINT DR</a>
    @endif


<script type="text/javascript">
    $("#sales_invoicing_cancel_dr").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "sales_invoicing_cancel_dr",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if(data == 'incorrect_access_key'){
               Swal.fire(
                'Incorrect Operations Manager Secret Key',
                '',
                'error'
               )
              $('.loading').hide(); 
            }else{
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Dr Cancelled, Your work has been saved. Reloading Page Please Wait',
                showConfirmButton: false,
                timer: 1500
              })
              location.reload();
              $('.loading').hide(); 
            }
          },
        });
    }));

    $("#sales_invoicing_reprint_dr").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();

        $.ajax({
          url: "sales_invoicing_reprint_dr",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if(data == 'incorrect_access_key'){
               Swal.fire(
                'Incorrect Operations Manager Secret Key',
                '',
                'error'
               )
              $('.loading').hide(); 
            }else{
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Dr Status Updated, Your work has been saved. Reloading Page Please Wait',
                showConfirmButton: false,
                timer: 1500
              })
              location.reload();
              $('.loading').hide(); 
            }
          },
        });
    }));
</script>