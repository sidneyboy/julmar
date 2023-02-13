  <link rel="stylesheet" href="{{ asset('/adminLte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/adminLte/dist/css/adminlte.min.css') }}">
  <style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 10;  /* this affects the margin in the printer settings */
    }
  </style>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <br /><br /><br />
    <div class="row">
      <div class="col-12">
        <center>
           <h2 class="page-header">
            <img src="{{ asset('/adminLte/julmar.png') }}" style="width:50px;" alt=""> JULMAR COMMERCIAL. INC,
           </h2>
        </center>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col">
        <center>
        <h5>St Ignatius St., Brgy. Kauswagan <br /> Cagayan de Oro City, Misamis Oriental</h5>
        <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
        </center>
        <br />
        <center>
        <span style="font-weight: bold;font-size:18px;">REPORT: {{ $date_from ." To ". $date_to }}</span><br />
        <span style="font-size:15px;">
      </div>
    </div><br />
    <!-- /.row -->
    
   
        
 
    @if($method == "BO ALLOWANCE")
      <table class="table table-bordered table-hovered" style="font-size:18px;">
          <thead>
            <tr>
              <th style="text-align: center">Receiving Report</th>
              <th style="text-align: center;">Invoice No</th>
              <th style="text-align: center">Date</th>
              <th style="text-align: center;background-color:#a4ff4f">Total Invoice</th>
              <th style="text-align: center;background-color:#a4ff4f">Bo Allowance</th>
            </tr>
          </thead>
          <tbody>
                        @if ($received_counter != 0 )
                           @foreach ($received_order_data as $data)
                           <tr>
                                <td style="text-align: center;">{{ "RR - ". $data->id }}</td>
                                <td style="text-align: center;text-transform: uppercase;">
                                  {{ $data->dr_si }}
                                </td>
                                <td style="text-align: center">{{ $data->date }}</td>
                                <td style="text-align: right;color:green;font-weight: bold;">
                                  @php
                                    $sum_bo_allowance_tab_received_vatable_purchase[] = $data->vatable_purchase;
                                  @endphp
                                  {{ number_format($data->vatable_purchase,2,".",",") }}
                                </td>
                                <td style="text-align: right;color:green;font-weight: bold;">
                                  @php
                                    $sum_bo_allowance_tab_received_bo_allowance[] = $data->total_bo_allowance;
                                  @endphp
                                   {{ number_format($data->total_bo_allowance,2,".",",") }}
                                </td>
                              </tr>
                          @endforeach
                        @else
                            @php
                              $sum_bo_allowance_tab_received_vatable_purchase[] = 0;
                              $sum_bo_allowance_tab_received_bo_allowance[] = 0;
                            @endphp
                        @endif

                        @if($return_counter != 0)
                            @for ($i = 0; $i < $return_counter; $i++)
                               <tr>
                                <td style="text-align: center;">RET - {{ $return_order_data[$i]->id }}</td>
                                <td style="text-align: center;text-transform: uppercase;">{{ $return_order_data[$i]->received->dr_si }}</td>
                                <td style="text-align: center;">{{ $return_order_data[$i]->date }}</td>
                                <td style="text-align: right;background: color:red;font-weight: bold;color:red;">
                                  @php
                                    $sum_bo_allowance_tab_return_vatable_purchase[] = $return_order_data[$i]->return_vatable_purchase;
                                  @endphp 
                                  {{ number_format($return_order_data[$i]->return_vatable_purchase*-1,2,".",",") }}
                                </td>
                                <td style="text-align: right;background: color:red;font-weight: bold;color:red;">
                                  @php
                                    $sum_bo_allowance_tab_return_bo_allowace[] = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100;
                                  @endphp 
                                  {{ number_format(($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100)*-1,2,".",",") }}
                                </td>
                              </tr>
                            @endfor
                          @else
                                  @php
                                    $sum_bo_allowance_tab_return_vatable_purchase[] = 0;
                                    $sum_bo_allowance_tab_return_bo_allowace[] = 0;
                                  @endphp
                          @endif
                          @if($bo_counter != 0)
                            @for ($i = 0; $i < $bo_counter; $i++)
                               <tr>
                                <td style="text-align: center;">
                                  DM - BO {{ $bo_adjustment_data[$i]->id }}
                                </td>
                                <td style="text-align: center;text-transform: uppercase;">{{ $bo_adjustment_data[$i]->received->dr_si }}</td>
                                <td style="text-align: center;">{{ $bo_adjustment_data[$i]->date }}</td>
                                <td style="text-align: right;font-weight: bold;color:green;">
                                  {{ number_format(0,2,".",",") }}
                                </td>
                                <td style="text-align: right;font-weight: bold;color:green;">
                                  @php
                                    $sum_bo_allowance_tab_bo_adjustment_bo_allowace[] = $bo_adjustment_data[$i]->bo_allowance_deduction;
                                  @endphp 
                                  {{ number_format($bo_adjustment_data[$i]->bo_allowance_deduction,2,".",",") }}
                                </td>
                              </tr>
                            @endfor
                          @else
                                  @php
                                    $sum_bo_allowance_tab_bo_adjustment_bo_allowace[] = 0;
                                  @endphp
                          @endif
                          
                                 @if($invoice_counter != 0)
                            @for ($i = 0; $i < $invoice_counter; $i++)
                               <tr>
                                <td style="text-align: center;">
                                  INVOICE - ADJUSTMENT {{ $invoice_cost_data[$i]->id }}
                                </td>
                                <td style="text-align: center;text-transform: uppercase;">{{ $invoice_cost_data[$i]->received->dr_si }}</td>
                                <td style="text-align: center;">{{ $invoice_cost_data[$i]->date }}</td>
                                <td style="text-align: right;font-weight: bold;color">
                                  @php
                                    $sum_bo_allowance_tab_invoice_cost_adjustment_vatable_purchase[] = $invoice_cost_data[$i]->vatable_purchase;
                                  @endphp
                                  @if($invoice_cost_data[$i]->vatable_purchase > 0)
                                   <span style="color:green;">{{ number_format($invoice_cost_data[$i]->vatable_purchase,2,".",",") }}</span>
                                  @else
                                   <span style="color:red">{{ number_format($invoice_cost_data[$i]->vatable_purchase,2,".",",") }}</span>
                                  @endif
                                </td>
                                <td style="text-align: right;font-weight: bold;color">
                                  @php
                                    $sum_bo_allowance_tab_invoice_cost_adjustment_bo_allowace[] = $invoice_cost_data[$i]->total_bo_allowance;
                                  @endphp 
                                  @if($invoice_cost_data[$i]->total_bo_allowance > 0)
                                    <span style="color:green">{{ number_format($invoice_cost_data[$i]->total_bo_allowance,2,".",",") }}</span>
                                  @else
                                    <span style="color:red">{{ number_format($invoice_cost_data[$i]->total_bo_allowance,2,".",",") }}</span>
                                  @endif
                                </td>
                              </tr>
                            @endfor
                          @else
                              @php
                                $sum_bo_allowance_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                $sum_bo_allowance_tab_invoice_cost_adjustment_bo_allowace[] = 0;
                              @endphp
                          @endif

                          <tr>
                            <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                            <td style="text-align: right;background-color:#a4ff4f;font-weight: bold">
                              {{  number_format(array_sum($sum_bo_allowance_tab_received_vatable_purchase) - array_sum($sum_bo_allowance_tab_return_vatable_purchase) + array_sum($sum_bo_allowance_tab_invoice_cost_adjustment_vatable_purchase),2,".",",")   }}
                            </td>
                            <td style="text-align: right;background-color:#a4ff4f;font-weight: bold">
                              {{ number_format(array_sum($sum_bo_allowance_tab_received_bo_allowance) - array_sum($sum_bo_allowance_tab_return_bo_allowace) + array_sum($sum_bo_allowance_tab_bo_adjustment_bo_allowace) + array_sum($sum_bo_allowance_tab_invoice_cost_adjustment_bo_allowace),2,".",",")  }}
                            </td>
                            
                          </tr>

                          @if($received_counter == 0 AND $bo_counter == 0 AND $invoice_counter != 0 AND $return_counter)
                            <tr>
                              <td colspan="5" style="font-weight: bold;text-align: center">NO DATA FOUND!</td>
                            </tr>
                          @endif
                     
     
          </tbody>
      </table>





    @elseif($method == "VAT INPUTS")
                    <table class="table table-bordered table-hovered" style="font-size:18px;">
                      <thead>
                        <tr>
                          <th style="text-align: center">Receiving Report</th>
                          <th style="text-align: center;">Invoice No</th>
                          <th style="text-align: center">Date</th>
                          <th style="text-align: center;background-color:#a4ff4f">Total Invoice</th>
                          <th style="text-align: center;background-color:#a4ff4f">Input Vat</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if ($received_counter != 0 )
                           @foreach ($received_order_data as $data)
                            <tr>
                              <td style="text-align: center;">{{ "RR - ". $data->id }}</td>
                              <td style="text-align: center;text-transform: uppercase;">
                               {{ $data->dr_si }}
                              </td>
                              <td style="text-align: center">{{ $data->date }}</td>
                              <td style="text-align: right;color:green;font-weight: bold;">
                                @php
                                  $sum_vat_amount_tab_received_vatable_purchase[] = $data->vatable_purchase;
                                @endphp
                                {{ number_format($data->vatable_purchase,2,".",",") }}
                              </td>
                              <td style="text-align: right;color:green;font-weight: bold;">
                                @php
                                  $sum_vat_amount_tab_received_vat_amount[] = $data->vat_amount;
                                @endphp
                                {{ number_format($data->vat_amount,2,".",",") }}
                              </td>
                            </tr>
                          @endforeach
                        @else
                                @php  
                                  $sum_vat_amount_tab_received_vatable_purchase[] = 0;
                                  $sum_vat_amount_tab_received_vat_amount[] = 0;
                                @endphp
                        @endif

                         @if($return_counter != 0)
                          @for ($i = 0; $i < $return_counter; $i++)
                           
                             <tr>
                              <td style="text-align-last: center;">RET - {{ $return_order_data[$i]->id }}</td>
                              <td style="text-align-last: center;text-transform: uppercase;">
                                {{ $return_order_data[$i]->received->dr_si }}
                              </td>
                              <td style="text-align-last: center;">{{ $return_order_data[$i]->date }}</td>
                              <td style="text-align: right;color:red;font-weight: bold;">
                                @php
                                  $sum_vat_amount_tab_return_vatable_purchase[] = $return_order_data[$i]->return_vatable_purchase;
                                @endphp
                                {{ number_format($return_order_data[$i]->return_vatable_purchase*-1,2,".",",") }}
                              </td>
                              <td style="text-align: right;color:red;font-weight: bold;">
                                @php
                                  $sum_vat_amount_tab_return_vat_amount[] = $return_order_data[$i]->return_vat_amount;
                                @endphp
                                {{ number_format($return_order_data[$i]->return_vat_amount*-1,2,".",",") }}
                              </td>
                            </tr>
                          @endfor
                        @else
                                @php
                                  $sum_vat_amount_tab_return_vatable_purchase[] = 0;
                                  $sum_vat_amount_tab_return_vat_amount[] = 0;
                                @endphp
                        @endif

                          @if($bo_counter != 0)
                          @for ($i = 0; $i < $bo_counter; $i++)
                           
                             <tr>
                              <td style="text-align-last: center;">
                                DM - BO {{ $bo_adjustment_data[$i]->id }}
                              </td>
                              <td style="text-align-last: center;text-transform: uppercase;">
                                {{ $bo_adjustment_data[$i]->received->dr_si }}
                              </td>
                              <td style="text-align-last: center;">{{ $bo_adjustment_data[$i]->date }}</td>
                              <td style="text-align: right;color:green;font-weight: bold;">
                                {{ number_format(0,2,".",",") }}
                              </td>
                              <td style="text-align: right;color:red;font-weight: bold;">
                                @php
                                  $sum_vat_amount_tab_bo_allowance_vat_amount[] =  $bo_adjustment_data[$i]->vat_deduction;
                                @endphp
                                {{ number_format($bo_adjustment_data[$i]->vat_deduction*-1,2,".",",") }}
                              </td>
                            </tr>
                          @endfor
                        @else
                                @php
                                  $sum_vat_amount_tab_bo_allowance_vat_amount[] = 0;
                                @endphp
                        @endif

                         @if($invoice_counter != 0)
                          @for ($i = 0; $i < $invoice_counter; $i++)
                             <tr>
                              <td style="text-align: center;">
                                INVOICE - ADJUSTMENT {{ $invoice_cost_data[$i]->id }}
                              </td>
                              <td style="text-align: center;text-transform: uppercase;">
                                {{ $invoice_cost_data[$i]->received->dr_si }}
                              </td>
                              <td style="text-align: center;">{{ $invoice_cost_data[$i]->date }}</td>
                              <td style="text-align: right;font-weight: bold;color">
                                @php
                                  $sum_vat_amount_tab_invoice_cost_adjustment_vatable_purchase[] = $invoice_cost_data[$i]->vatable_purchase;
                                @endphp
                                @if($invoice_cost_data[$i]->vatable_purchase > 0)
                                 <span style="color:green;">{{ number_format($invoice_cost_data[$i]->vatable_purchase,2,".",",") }}</span>
                                @else
                                 <span style="color:red">{{ number_format($invoice_cost_data[$i]->vatable_purchase,2,".",",") }}</span>
                                @endif
                              </td>
                              <td style="text-align: right;font-weight: bold;color">
                                @php
                                  $sum_vat_amount_tab_invoice_cost_adjustment_vat_amount[] = $invoice_cost_data[$i]->vat_amount;
                                @endphp 
                                @if($invoice_cost_data[$i]->vat_amount > 0)
                                  <span style="color:green">{{ number_format($invoice_cost_data[$i]->vat_amount,2,".",",") }}</span>
                                @else
                                  <span style="color:red">{{ number_format($invoice_cost_data[$i]->vat_amount,2,".",",") }}</span>
                                @endif
                              </td>
                            </tr>
                          @endfor
                        @else
                            @php
                              $sum_vat_amount_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                              $sum_vat_amount_tab_invoice_cost_adjustment_vat_amount[] = 0;
                            @endphp
                        @endif

                        <tr>
                          <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                          <td style="text-align: right;background-color:#a4ff4f;font-weight: bold">
                            {{  number_format(array_sum($sum_vat_amount_tab_received_vatable_purchase) - array_sum($sum_vat_amount_tab_return_vatable_purchase) + array_sum($sum_vat_amount_tab_invoice_cost_adjustment_vatable_purchase),2,".",",")  }}
                          </td>
                          <td style="text-align: right;background-color:#a4ff4f;font-weight: bold">
                            {{ number_format(array_sum($sum_vat_amount_tab_received_vat_amount) - array_sum($sum_vat_amount_tab_return_vat_amount) - array_sum($sum_vat_amount_tab_bo_allowance_vat_amount) + array_sum($sum_vat_amount_tab_invoice_cost_adjustment_vat_amount) ,2,".",",")  }}
                          </td>
                        </tr>



                        @if($received_counter == 0 AND $bo_counter == 0 AND $invoice_counter != 0 AND $return_counter)
                          <tr>
                            <td colspan="5" style="font-weight: bold;text-align: center">NO DATA FOUND!</td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
    @elseif($method == "RECEIVED DELIVERIES")
         @if ($principal_name == 'GCI')
           <div class="table table-responsive">
                    <table class="table table-bordered table-hovered" style="font-size:18px;">
                        <thead>
                          <tr >
                            <th style="text-align: center;">Reference<br />#</th>
                            <th style="text-align: center;">Invoice<br />No</th>
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: center;background-color:#a4ff4f">Total<br />Invoice</th>
                            <th style="text-align: center;background-color:#a4ff4f">Discount</th>
                            <th style="text-align: center;background-color:#a4ff4f">BO <br />Allowance</th>
                            <th style="text-align: center;background-color:#a4ff4f">Net <br />Of<br />Discount</th>
                            <th style="text-align: center;background-color:#a4ff4f">Value<br />Added<br />Tax</th>
                            <th style="text-align: center;background-color:#a4ff4f">Freight</th>
                            <th style="text-align: center;background-color:#a4ff4f">Net<br />Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if($received_counter != 0)
                              @for ($i=0; $i < $received_counter; $i++) 
                                <tr>
                                  <td style="text-align: center;">
                                    <a target="_blank" href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}">RR - {{ $received_order_data[$i]->id }}</a>
                                  </td>
                                  <td style="text-align: center;text-transform: uppercase;">
                                    @if($received_order_data[$i]->invoice_image != '')
                                       <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                      {{ $received_order_data[$i]->dr_si }}
                                      </button>

                                      <!-- Modal -->
                                        <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                              </div>
                                              <div class="modal-body">
                                               <img src="{{  asset('/images/'. $received_order_data[$i]->invoice_image) }}" style="width:100%;">
                                              </div>
                                             
                                            </div>
                                          </div>
                                        </div>
                                    @else
                                      {{ $received_order_data[$i]->dr_si }}
                                    @endif
                                  </td>
                                  <td style="text-align: center;">{{ $received_order_data[$i]->date }}</td>
                                  <td style="text-align: right;color:green;font-weight: bold;">
                                    {{ number_format($received_order_data[$i]->vatable_purchase,2,".",",")  }}
                                    @php
                                      $sum_received_tab_vatable_purchase[] = $received_order_data[$i]->vatable_purchase;
                                    @endphp
                                  </td>
                                  <td style="text-align: right;font-weight: bold;">
                                    <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $received_order_data[$i]->id }}">
                                    @php
                                      $sum_received_tab_total_discount[] = round($received_order_data[$i]->total_every_discount,2);
                                    @endphp
                                    {{ number_format($received_order_data[$i]->total_every_discount,2,".",",") }}
                                    
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade " id="exampleModal{{ $received_order_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg mw-100 w-100" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="table table-responsive">
                                               <table class="table table-bordered" style="font-size:15px">
                                              <thead>
                                                <tr>
                                                  <th style="text-align: center;">REF #</th>
                                                  <th style="text-align: center;">LOGISCTICS FEE</th>
                                                  <th style="text-align: center;">SELLING FEE</th>
                                                  <th style="text-align: center;">CWO DISCOUNT</th>
                                                  <th style="text-align: center;background-color:#9beb34;">SUB TOTAL</th>
                                                  <th style="text-align: center;">VMI </th>
                                                  <th style="text-align: center;">PER CAT SO</th>
                                                  <th style="text-align: center;">TOTAL SELL</th>
                                                  <th style="text-align: center;">DOPS</th>
                                                  <th style="text-align: center;">DBS</th>
                                                  <th style="text-align: center;">REACH</th>
                                                  <th style="text-align: center;background-color:#9beb34;">SUB TOTAL</th>
                                                  <th style="text-align: center;">SHELF</th>
                                                  <th style="text-align: center;">DA</th>
                                                  <th style="text-align: center;">BMP</th>
                                                  <th style="text-align: center;">BDFD</th>
                                                  <th style="text-align: center;background-color:#9beb34;">SUB TOTAL</th>
                                                  <th style="text-align: center;background-color:#9beb34;">OTHERS</th>
                                                  <th style="text-align: center;background-color:#9beb34;">TOTAL</th>

                                                </tr>
                                               
                                              </thead>
                                              <tbody>
                                                <tr>
                                                    <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $received_order_data[$i]->id }}</a></td>
                                                    <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->logistics_fee == 0.0000) {
                                                             $logistics_fee = 0;
                                                         }else{
                                                             $logistics_fee = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->logistics_fee/100);
                                                         }
                                                       @endphp
                                                        {{ number_format($logistics_fee,2,".",",") }} 
                                                    </td>        
                                                    <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->selling_fee == 0.0000) {
                                                             $selling_fee = 0;
                                                         }else{
                                                             $selling_fee = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->selling_fee/100);
                                                         }
                                                        
                                                       @endphp
                                                        {{ number_format($selling_fee,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->cwo_discount == 0.0000) {
                                                             $cwo_discount = 0;
                                                         }else{
                                                              $cwo_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->cwo_discount/100);
                                                         }
                                                       @endphp
                                                        {{ number_format($cwo_discount,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         $sub_total_1 = $logistics_fee + $selling_fee + $cwo_discount;
                                                       @endphp
                                                        {{ number_format($sub_total_1,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->vmi_discount == 0.0000) {
                                                            $vmi_discount = 0;
                                                         }else{
                                                            $vmi_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->vmi_discount/100);
                                                         }
                                                         
                                                       @endphp
                                                        {{ number_format($vmi_discount,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->per_category_sell_discount == 0.0000) {
                                                            $per_category_sell_discount = 0;
                                                         }else{
                                                           $per_category_sell_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->per_category_sell_discount/100);
                                                         }
                                                        
                                                       @endphp
                                                        {{ number_format($per_category_sell_discount,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->total_sell_discount == 0.0000) {
                                                            $total_sell_discount = 0;
                                                         }else{
                                                           $total_sell_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->total_sell_discount/100);
                                                         }
                                                        
                                                       @endphp
                                                        {{ number_format($total_sell_discount,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->dops_discount == 0.0000) {
                                                            $dops_discount = 0;
                                                         }else{
                                                            $dops_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->dops_discount/100);
                                                         }
                                                       @endphp
                                                        {{ number_format($dops_discount,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->dbs_discount == 0.0000) {
                                                            $dbs_discount = 0;
                                                         }else{
                                                            $dbs_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->dbs_discount/100);
                                                         }
                                                       @endphp
                                                        {{ number_format($dbs_discount,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->reach == 0.0000) {
                                                            $reach = 0;
                                                         }else{
                                                            $reach = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->reach/100);
                                                         }                                                 
                                                        @endphp
                                                        {{ number_format($reach,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php

                                                         $sub_total_2 = $vmi_discount + $per_category_sell_discount + $total_sell_discount + $dops_discount + $dbs_discount + $reach;
                                                       @endphp
                                                        {{ number_format($sub_total_2,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->shelf_management_discount == 0.0000) {
                                                            $shelf_management_discount = 0;
                                                         }else{
                                                            $shelf_management_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->shelf_management_discount/100);
                                                         }   
                                                     
                                                       @endphp
                                                        {{ number_format($shelf_management_discount,2,".",",") }} 
                                                     </td>
                                                      <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->display_allowance == 0.0000) {
                                                            $display_allowance = 0;
                                                         }else{
                                                            $display_allowance = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->display_allowance/100);
                                                         }   
                                                       
                                                       @endphp
                                                        {{ number_format($display_allowance,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->bleach_management_project == 0.0000) {
                                                            $bleach_management_project = 0;
                                                         }else{
                                                            $bleach_management_project = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->bleach_management_project/100);
                                                         }   
                                                        
                                                       @endphp
                                                        {{ number_format($bleach_management_project,2,".",",") }} 
                                                     </td>
                                                     <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->business_development_fund_discount == 0.0000) {
                                                            $business_development_fund_discount = 0;
                                                         }else{
                                                            $business_development_fund_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->business_development_fund_discount/100);
                                                         }   
                                                        
                                                       @endphp
                                                        {{ number_format($business_development_fund_discount,2,".",",") }} 
                                                     </td>
                                                    <td>
                                                       @php
                                                         $sub_total_3 = $shelf_management_discount + $display_allowance + $bleach_management_project + $business_development_fund_discount;
                                                       @endphp
                                                        {{ number_format($sub_total_3,2,".",",") }} 
                                                    </td>
                                                    <td>
                                                       @php
                                                         if ($received_discount_rate[$i]->others == 0.0000) {
                                                            $others = 0;
                                                         }else{
                                                            $others = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->others/100);
                                                         }   
                                                       @endphp
                                                        {{ number_format($others,2,".",",") }} 
                                                    </td>
                                                    <td>
                                                       @php
                                                         $total = $sub_total_1  + $sub_total_2 + $sub_total_3 + $others;
                                                       @endphp
                                                        {{ number_format($total,2,".",",") }} 
                                                     </td>
                                                                        
                                                </tr>
                                              </tbody>
                                            </table>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation', $received_order_data[$i]->id ."=". $principal_name ."=". $logistics_fee ."=". $selling_fee ."=". $cwo_discount ."=". $vmi_discount ."=". $per_category_sell_discount ."=". $total_sell_discount ."=". $dops_discount ."=". $dbs_discount ."=". $reach ."=". $shelf_management_discount ."=". $display_allowance ."=". $bleach_management_project ."=". $business_development_fund_discount ."=". $others ) }}">PRINT THIS</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </td>
                                  <td style="text-align: right;color:green;font-weight: bold;">
                                    @php
                                      $sum_received_tab_bo_allowance[] = round($received_order_data[$i]->total_bo_allowance,2);
                                    @endphp
                                  {{ number_format(round($received_order_data[$i]->total_bo_allowance,2),2,".",",") }}
                                  </td>
                                  <td style="text-align: right;color:green;font-weight: bold;">
                                    @php
                                      $sum_received_tab_net_discount[] = round($received_order_data[$i]->net_discount,2);
                                    @endphp
                                     {{ number_format(round($received_order_data[$i]->net_discount,2),2,".",",") }}
                                  </td>
                                  <td style="text-align: right;color:green;font-weight: bold;">
                                    @php
                                      $sum_received_tab_vat_amount[] = round($received_order_data[$i]->vat_amount,2);
                                    @endphp
                                    {{ number_format(round($received_order_data[$i]->vat_amount,2),2,".",",") }}
                                  </td>
                                  <td style="text-align: right;color:green;font-weight: bold;">
                                    @php
                                      $sum_received_tab_freight[] = $received_order_data[$i]->freight;
                                    @endphp
                                    {{ number_format($received_order_data[$i]->freight,2,".",",") }}
                                  </td>
                                  <td style="text-align: right;color:green;font-weight: bold;">
                                    @php
                                      $sum_received_tab_net_of_amount[] = round($received_order_data[$i]->grand_final_total_cost,2);
                                    @endphp
                                    {{ number_format(round($received_order_data[$i]->grand_final_total_cost,2),2,".",",") }}
                                  </td>
                                </tr>
                              @endfor
                          @else
                             @php 
                              $sum_received_tab_vatable_purchase[] = 0;
                              $sum_received_tab_total_discount[] = 0;
                              $sum_received_tab_bo_allowance[] = 0;
                              $sum_received_tab_net_discount[] = 0;
                              $sum_received_tab_vat_amount[] = 0;
                              $sum_received_tab_freight[] = 0;
                              $sum_received_tab_net_of_amount[] = 0;
                             @endphp
                          @endif

                          @if($return_counter != 0)
                            @for ($i=0; $i < $return_counter; $i++) 
                              <tr>
                                <td style="text-align: center;">
                                  <a target="_blank" href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id ."=". $return_order_data[$i]->principal->principal) }}">RET - {{ $return_order_data[$i]->id }}</a>
                                 
                                </td>
                                <td style="text-align: center;text-transform: uppercase;">
                                  @if($received_order_data[$i]->invoice_image != '')
                                       <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                      {{ $return_order_data[$i]->received->dr_si }}
                                      </button>

                                      <!-- Modal -->
                                        <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                              </div>
                                              <div class="modal-body">
                                               <img src="{{  asset('/images/'. $received_order_data[$i]->invoice_image) }}" style="width:100%;">
                                              </div>
                                             
                                            </div>
                                          </div>
                                        </div>
                                    @else
                                      {{ $return_order_data[$i]->received->dr_si }}
                                    @endif
                                </td>
                                <td style="text-align: center;">{{ $return_order_data[$i]->date }}</td>
                                <td style="text-align: right;color:red;font-weight: bold;">
                                  @php
                                    $sum_received_tab_return_vatable_purchase[] = $return_order_data[$i]->return_vatable_purchase;
                                  @endphp
                                  {{  number_format(($return_order_data[$i]->return_vatable_purchase)*-1,2,".",",") }}
                                </td>
                                <td style="text-align: right;font-weight: bold;">
                                  <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#return{{ $return_order_data[$i]->id }}">
                                    @php
                                      $sum_received_tab_return_total_discount[] = round($return_order_data[$i]->return_less_discount - $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100,2);
                                    @endphp
                                    {{  number_format(round($return_order_data[$i]->return_less_discount - $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100,2)*-1,2,".",",") }}
                                   
                                  </button>

                                  <!-- Modal -->
                                  <div class="modal fade " id="return{{ $return_order_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg mw-100 w-100" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="table table-responsive">
                                             <table class="table table-bordered" style="font-size:15px">
                                            <thead>
                                              <tr>
                                                <th style="text-align: center;">REF #</th>
                                                <th style="text-align: center;">LOGISCTICS FEE</th>
                                                <th style="text-align: center;">SELLING FEE</th>
                                                <th style="text-align: center;">CWO DISCOUNT</th>
                                                <th style="text-align: center;background-color:#9beb34;">SUB TOTAL</th>
                                                <th style="text-align: center;">VMI </th>
                                                <th style="text-align: center;">PER CAT SO</th>
                                                <th style="text-align: center;">TOTAL SELL</th>
                                                <th style="text-align: center;">DOPS</th>
                                                <th style="text-align: center;">DBS</th>
                                                <th style="text-align: center;">REACH</th>
                                                <th style="text-align: center;background-color:#9beb34;">SUB TOTAL</th>
                                                <th style="text-align: center;">SHELF</th>
                                                <th style="text-align: center;">DA</th>
                                                <th style="text-align: center;">BMP</th>
                                                <th style="text-align: center;">BDFD</th>
                                                <th style="text-align: center;background-color:#9beb34;">SUB TOTAL</th>
                                                <th style="text-align: center;background-color:#9beb34;">OTHERS</th>
                                                <th style="text-align: center;background-color:#9beb34;">TOTAL</th>

                                              </tr>
                                             
                                            </thead>
                                            <tbody>
                                              <tr>
                                                  <td style="text-align: center;"><a target="_blank" href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id ."=". $return_order_data[$i]->principal->principal) }}">RET - {{ $return_order_data[$i]->id }}</a></td>
                                                  <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->logistics_fee == 0.0000) {
                                                           $logistics_fee = 0;
                                                       }else{
                                                           $logistics_fee = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->logistics_fee/100);
                                                       }
                                                     @endphp
                                                      {{ number_format($logistics_fee*-1,2,".",",") }} 
                                                  </td>        
                                                  <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->selling_fee == 0.0000) {
                                                           $selling_fee = 0;
                                                       }else{
                                                           $selling_fee = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->selling_fee/100);
                                                       }
                                                      
                                                     @endphp
                                                      {{ number_format($selling_fee*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->cwo_discount == 0.0000) {
                                                           $cwo_discount = 0;
                                                       }else{
                                                            $cwo_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->cwo_discount/100);
                                                       }
                                                     @endphp
                                                      {{ number_format($cwo_discount*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       $sub_total_1 = $logistics_fee + $selling_fee + $cwo_discount;
                                                     @endphp
                                                      {{ number_format($sub_total_1*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->vmi_discount == 0.0000) {
                                                          $vmi_discount = 0;
                                                       }else{
                                                          $vmi_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->vmi_discount/100);
                                                       }
                                                       
                                                     @endphp
                                                      {{ number_format($vmi_discount*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->per_category_sell_discount == 0.0000) {
                                                          $per_category_sell_discount = 0;
                                                       }else{
                                                         $per_category_sell_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->per_category_sell_discount/100);
                                                       }
                                                      
                                                     @endphp
                                                      {{ number_format($per_category_sell_discount*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->total_sell_discount == 0.0000) {
                                                          $total_sell_discount = 0;
                                                       }else{
                                                         $total_sell_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->total_sell_discount/100);
                                                       }
                                                      
                                                     @endphp
                                                      {{ number_format($total_sell_discount*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->dops_discount == 0.0000) {
                                                          $dops_discount = 0;
                                                       }else{
                                                          $dops_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->dops_discount/100);
                                                       }
                                                     @endphp
                                                      {{ number_format($dops_discount*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->dbs_discount == 0.0000) {
                                                          $dbs_discount = 0;
                                                       }else{
                                                          $dbs_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->dbs_discount/100);
                                                       }
                                                     @endphp
                                                      {{ number_format($dbs_discount*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->reach == 0.0000) {
                                                          $reach = 0;
                                                       }else{
                                                          $reach = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->reach/100);
                                                       }                                                 
                                                      @endphp
                                                      {{ number_format($reach*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php

                                                       $sub_total_2 = $vmi_discount + $per_category_sell_discount + $total_sell_discount + $dops_discount + $dbs_discount + $reach;
                                                     @endphp
                                                      {{ number_format($sub_total_2*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->shelf_management_discount == 0.0000) {
                                                          $shelf_management_discount = 0;
                                                       }else{
                                                          $shelf_management_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->shelf_management_discount/100);
                                                       }   
                                                   
                                                     @endphp
                                                      {{ number_format($shelf_management_discount*-1,2,".",",") }} 
                                                   </td>
                                                    <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->display_allowance == 0.0000) {
                                                          $display_allowance = 0;
                                                       }else{
                                                          $display_allowance = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->display_allowance/100);
                                                       }   
                                                     
                                                     @endphp
                                                      {{ number_format($display_allowance*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->bleach_management_project == 0.0000) {
                                                          $bleach_management_project = 0;
                                                       }else{
                                                          $bleach_management_project = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bleach_management_project/100);
                                                       }   
                                                      
                                                     @endphp
                                                      {{ number_format($bleach_management_project*-1,2,".",",") }} 
                                                   </td>
                                                   <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->business_development_fund_discount == 0.0000) {
                                                          $business_development_fund_discount = 0;
                                                       }else{
                                                          $business_development_fund_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->business_development_fund_discount/100);
                                                       }   
                                                      
                                                     @endphp
                                                      {{ number_format($business_development_fund_discount*-1,2,".",",") }} 
                                                   </td>
                                                  <td>
                                                     @php
                                                       $sub_total_3 = $shelf_management_discount + $display_allowance + $bleach_management_project + $business_development_fund_discount;
                                                     @endphp
                                                      {{ number_format($sub_total_3*-1,2,".",",") }} 
                                                  </td>
                                                  <td>
                                                     @php
                                                       if ($return_discount_rate[$i]->others == 0.0000) {
                                                          $others = 0;
                                                       }else{
                                                          $others = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->others/100);
                                                       }   
                                                     @endphp
                                                      {{ number_format($others*-1,2,".",",") }} 
                                                  </td>
                                                  <td>
                                                     @php
                                                       $total = $sub_total_1  + $sub_total_2 + $sub_total_3 + $others;
                                                     @endphp
                                                      {{ number_format($total*-1,2,".",",") }} 
                                                   </td>
                                                                      
                                              </tr>
                                            </tbody>
                                          </table>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation', $received_order_data[$i]->id ."=". $principal_name ."=". $logistics_fee*-1 ."=". $selling_fee*-1 ."=". $cwo_discount*-1 ."=". $vmi_discount*-1 ."=". $per_category_sell_discount*-1 ."=". $total_sell_discount*-1 ."=". $dops_discount*-1 ."=". $dbs_discount*-1 ."=". $reach*-1 ."=". $shelf_management_discount*-1 ."=". $display_allowance*-1 ."=". $bleach_management_project*-1 ."=". $business_development_fund_discount*-1 ."=". $others*-1 ) }}">PRINT THIS</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                <td style="text-align: right;color:red;font-weight: bold;">
                                @php
                                  $sum_received_tab_return_bo_allowance[] = round($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100,2);
                                @endphp
                                {{ number_format(round(($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100)*-1,2),2,".",",")  }}
                                </td>
                                <td style="text-align: right;color:red;font-weight: bold;">
                                @php
                                  $sum_received_tab_return_net_discount[] = round($return_order_data[$i]->return_net_discount,2);
                                @endphp
                                  {{ number_format(round(($return_order_data[$i]->return_net_discount)*-1,2),2,".",",") }}
                                </td>
                                <td style="text-align: right;color:red;font-weight: bold;">
                                @php
                                  $sum_received_tab_return_vat_amount[] = round($return_order_data[$i]->return_vat_amount,2);
                                @endphp
                                  {{ number_format(round(($return_order_data[$i]->return_vat_amount)*-1,2),2,".",",") }}
                                </td>
                                <td style="text-align: right;color:red;font-weight: bold;">0</td>
                                <td style="text-align: right;color:red;font-weight: bold;">
                                @php
                                  $sum_received_tab_return_net_of_deduction[] = round($return_order_data[$i]->return_net_of_deduction,2);
                                @endphp
                                  {{ number_format(round(($return_order_data[$i]->return_net_of_deduction)*-1,2),2,".",",") }}
                                </td>
                              </tr>
                            @endfor
                          @else
                              @php
                                $sum_received_tab_return_vatable_purchase[] = 0;
                                $sum_received_tab_return_total_discount[] = 0;
                                $sum_received_tab_return_bo_allowance[] = 0;
                                $sum_received_tab_return_net_discount[] = 0;
                                $sum_received_tab_return_vat_amount[] = 0;
                                $sum_received_tab_return_net_of_deduction[] = 0;
                              @endphp
                          @endif

                          @if($bo_counter != 0)
                             @for ($i=0; $i < $bo_counter; $i++) 
                              <tr>
                                <td style="text-align: center;">
                                   <a href="{{ route('bo_allowance_adjustments_show_details', $bo_adjustment_data[$i]->id ."=". $bo_adjustment_data[$i]->principal->principal ."=". $bo_adjustment_data[$i]->particulars) }}" target="_blank">DM - BO {{ $bo_adjustment_data[$i]->id }}</a> 
                                </td>
                                <td style="text-align: center;text-transform: uppercase;">
                                  @if($bo_adjustment_data[$i]->invoice_image != '')
                                     <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                    {{ $bo_adjustment_data[$i]->received->dr_si }}
                                    </button>

                                    <!-- Modal -->
                                      <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                            </div>
                                            <div class="modal-body">
                                             <img src="{{  asset('/images/'. $bo_adjustment_data[$i]->invoice_image) }}" style="width:100%;">
                                            </div>
                                           
                                          </div>
                                        </div>
                                      </div>
                                  @else
                                    {{ $bo_adjustment_data[$i]->received->dr_si }}
                                  @endif
                                </td>
                                <td style="text-align: center;">{{ $bo_adjustment_data[$i]->date }}</td>
                                <td style="text-align: right;color:green;font-weight: bold;;">
                                  {{ number_format(0,2,".",",")  }}
                                  @php
                                    $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                                  @endphp
                                </td>
                                <td style="text-align: right;color:green;font-weight: bold;;">
                                  {{ number_format(0,2,".",",")  }}
                                  @php
                                    $sum_received_tab_bo_adjustment_total_discount[] = 0;
                                  @endphp
                                </td>
                                <td style="text-align: right;color:green;font-weight: bold;">
                                  {{ number_format($bo_adjustment_data[$i]->bo_allowance_deduction,2,".",",")  }}
                                  @php
                                    $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = $bo_adjustment_data[$i]->bo_allowance_deduction;
                                  @endphp
                                </td>
                                <td style="text-align: right;color:green;font-weight: bold;">{{ number_format(0,2,".",",") }}</td>
                                <td style="text-align: right;color:red;font-weight: bold;">
                                  {{ number_format($bo_adjustment_data[$i]->vat_deduction*-1,2,".",",")  }}
                                  @php
                                    $sum_received_tab_bo_adjustment_vat_deduction[] = $bo_adjustment_data[$i]->vat_deduction;
                                  @endphp
                                </td>
                                <td style="text-align: right;color:green;font-weight: bold;">
                                  {{ number_format(0,2,".",",") }}
                                </td>
                                <td style="text-align: right;color: red;font-weight: bold;">
                                  {{ number_format($bo_adjustment_data[$i]->net_deduction*-1,2,".",",")  }}
                                  @php
                                    $sum_received_tab_bo_adjustment_net_deduction[] = $bo_adjustment_data[$i]->net_deduction;
                                  @endphp
                                </td>

                              </tr>
                             @endfor
                          @else
                            @php
                             $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = 0;
                             $sum_received_tab_bo_adjustment_vat_deduction[] = 0;
                             $sum_received_tab_bo_adjustment_net_deduction[] = 0;
                             $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                             $sum_received_tab_bo_adjustment_total_discount[] = 0;
                            @endphp
                          @endif

                          @if($invoice_counter != 0)
                             @for ($i=0; $i < $invoice_counter; $i++) 
                               <tr>
                                <td style="text-align: center;">
                                   <a href="{{ route('bo_allowance_adjustments_show_details', $invoice_cost_data[$i]->id ."=". $invoice_cost_data[$i]->principal->principal ."=". $invoice_cost_data[$i]->particulars) }}" target="_blank">INVOICE - ADJUSTMENT {{ $invoice_cost_data[$i]->id }}</a> 
                                </td>
                                <td style="text-align: center;text-transform: uppercase;">
                                  @if($invoice_cost_data[$i]->invoice_image != '')
                                     <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                    {{ $invoice_cost_data[$i]->received->dr_si }}
                                    </button>

                                    <!-- Modal -->
                                      <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                            </div>
                                            <div class="modal-body">
                                             <img src="{{  asset('/images/'. $invoice_cost_data[$i]->invoice_image) }}" style="width:100%;">
                                            </div>
                                           
                                          </div>
                                        </div>
                                      </div>
                                  @else
                                    {{ $invoice_cost_data[$i]->received->dr_si }}
                                  @endif
                                </td>
                                <td style="text-align: center;">{{ $invoice_cost_data[$i]->date }}</td>
                                <td style="text-align: right;color:green;font-weight: bold;;">
                                  
                                  @php
                                    $received_tab_invoice_cost_adjustment_vatable_purchase = $invoice_cost_data[$i]->vatable_purchase;
                                    $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                  @endphp
                                  @if($received_tab_invoice_cost_adjustment_vatable_purchase > 0)
                                    <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase,2,".",",")  }}</span>
                                  @else
                                    <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase,2,".",",")  }}</span>
                                  @endif
                                   
                                </td>
                                <td style="text-align: right;color:green;font-weight: bold;">
                                  @php
                                    $received_tab_invoice_cost_adjustment_less_discount = $invoice_cost_data[$i]->less_discount;
                                    $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                  @endphp
                                  @if($received_tab_invoice_cost_adjustment_less_discount > 0)
                                    <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_less_discount,2,".",",")  }}</span>
                                  @else
                                    <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_less_discount,2,".",",")  }}</span>
                                  @endif
                                </td>
                                <td style="text-align: right;color:green;font-weight: bold;">
                                  @php
                                    $received_tab_invoice_cost_adjustment_bo_allowance = $invoice_cost_data[$i]->total_bo_allowance;
                                    $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                  @endphp
                                  @if($received_tab_invoice_cost_adjustment_bo_allowance > 0)
                                    <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance,2,".",",")  }}</span>
                                  @else
                                    <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance,2,".",",")  }}</span>
                                  @endif
                                </td>
                                <td style="text-align: right;color:green;font-weight: bold;">
                                  @php
                                    $received_tab_invoice_cost_adjustment_net_discount = $invoice_cost_data[$i]->net_discount;
                                    $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                  @endphp
                                  @if($received_tab_invoice_cost_adjustment_net_discount > 0)
                                    <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_discount,2,".",",")  }}</span>
                                  @else
                                    <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_discount,2,".",",")  }}</span>
                                  @endif
                                </td>
                                <td style="text-align: right;color:red;font-weight: bold;">
                                  @php
                                    $received_tab_invoice_cost_adjustment_vat_amount = $invoice_cost_data[$i]->vat_amount;
                                    $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                  @endphp
                                  @if($received_tab_invoice_cost_adjustment_vat_amount > 0)
                                    <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount,2,".",",")  }}</span>
                                  @else
                                    <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount,2,".",",")  }}</span>
                                  @endif
                                </td>
                                <td style="text-align: right;color:green;font-weight: bold;">
                                  {{ number_format(0,2,".",",") }}
                                </td>
                                <td style="text-align: right;color: red;font-weight: bold;">
                                  @php
                                    $received_tab_invoice_cost_adjustment_net_adjustment = $invoice_cost_data[$i]->net_adjustment;
                                    $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                                  @endphp
                                  @if($received_tab_invoice_cost_adjustment_net_adjustment > 0)
                                    <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment,2,".",",")  }}</span>
                                  @else
                                    <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment,2,".",",")  }}</span>
                                  @endif
                                </td>
                              </tr>
                             @endfor
                          @else
                              @php
                                $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                              @endphp
                          @endif

                          <tr>
                          <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                          <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                          {{ 
                            number_format(array_sum($sum_received_tab_vatable_purchase) - array_sum($sum_received_tab_return_vatable_purchase) + - array_sum($sum_received_tab_invoice_cost_adjustment_vatable_purchase) ,2,".",",") 
                          }}
                          </td>
                          <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;;">
                                <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#grand_total">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_total_discount) - array_sum($sum_received_tab_return_total_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_less_discount),2,".",",") 
                                    }}
                                </button>

                                <!-- Modal -->
                                <div class="modal fade " id="grand_total" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg mw-100 w-100" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="table table-responsive">
                                           <table class="table table-bordered" style="font-size:15px">
                                          <thead>
                                            <tr>
                                              <th style="text-align: center;">REF #</th>
                                              <th style="text-align: center;">LOGISCTICS FEE</th>
                                              <th style="text-align: center;">SELLING FEE</th>
                                              <th style="text-align: center;">CWO DISCOUNT</th>
                                              <th style="text-align: center;background-color:#9beb34;">SUB TOTAL</th>
                                              <th style="text-align: center;">VMI </th>
                                              <th style="text-align: center;">PER CAT SO</th>
                                              <th style="text-align: center;">TOTAL SELL</th>
                                              <th style="text-align: center;">DOPS</th>
                                              <th style="text-align: center;">DBS</th>
                                              <th style="text-align: center;">REACH</th>
                                              <th style="text-align: center;background-color:#9beb34;">SUB TOTAL</th>
                                              <th style="text-align: center;">SHELF</th>
                                              <th style="text-align: center;">DA</th>
                                              <th style="text-align: center;">BMP</th>
                                              <th style="text-align: center;">BDFD</th>
                                              <th style="text-align: center;background-color:#9beb34;">SUB TOTAL</th>
                                              <th style="text-align: center;background-color:#9beb34;">OTHERS</th>
                                              <th style="text-align: center;background-color:#9beb34;">TOTAL</th>

                                            </tr>
                                           
                                          </thead>
                                          <tbody>
                                              @for ($i=0; $i < $received_counter; $i++) 

                                                <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $received_order_data[$i]->id }}</a></td>
                                                <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->logistics_fee == 0.0000) {
                                                         $logistics_fee = 0;
                                                     }else{
                                                         $logistics_fee = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->logistics_fee/100);
                                                     }
                                                   @endphp
                                                    {{ number_format($logistics_fee,2,".",",") }} 
                                                </td>        
                                                <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->selling_fee == 0.0000) {
                                                         $selling_fee = 0;
                                                     }else{
                                                         $selling_fee = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->selling_fee/100);
                                                     }
                                                    
                                                   @endphp
                                                    {{ number_format($selling_fee,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->cwo_discount == 0.0000) {
                                                         $cwo_discount = 0;
                                                     }else{
                                                          $cwo_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->cwo_discount/100);
                                                     }
                                                   @endphp
                                                    {{ number_format($cwo_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $sub_total_1 = $logistics_fee + $selling_fee + $cwo_discount;
                                                   @endphp
                                                    {{ number_format($sub_total_1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->vmi_discount == 0.0000) {
                                                        $vmi_discount = 0;
                                                     }else{
                                                        $vmi_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->vmi_discount/100);
                                                     }
                                                     
                                                   @endphp
                                                    {{ number_format($vmi_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->per_category_sell_discount == 0.0000) {
                                                        $per_category_sell_discount = 0;
                                                     }else{
                                                       $per_category_sell_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->per_category_sell_discount/100);
                                                     }
                                                    
                                                   @endphp
                                                    {{ number_format($per_category_sell_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->total_sell_discount == 0.0000) {
                                                        $total_sell_discount = 0;
                                                     }else{
                                                       $total_sell_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->total_sell_discount/100);
                                                     }
                                                    
                                                   @endphp
                                                    {{ number_format($total_sell_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->dops_discount == 0.0000) {
                                                        $dops_discount = 0;
                                                     }else{
                                                        $dops_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->dops_discount/100);
                                                     }
                                                   @endphp
                                                    {{ number_format($dops_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->dbs_discount == 0.0000) {
                                                        $dbs_discount = 0;
                                                     }else{
                                                        $dbs_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->dbs_discount/100);
                                                     }
                                                   @endphp
                                                    {{ number_format($dbs_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->reach == 0.0000) {
                                                        $reach = 0;
                                                     }else{
                                                        $reach = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->reach/100);
                                                     }                                                 
                                                    @endphp
                                                    {{ number_format($reach,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php

                                                     $sub_total_2 = $vmi_discount + $per_category_sell_discount + $total_sell_discount + $dops_discount + $dbs_discount + $reach;
                                                   @endphp
                                                    {{ number_format($sub_total_2,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->shelf_management_discount == 0.0000) {
                                                        $shelf_management_discount = 0;
                                                     }else{
                                                        $shelf_management_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->shelf_management_discount/100);
                                                     }   
                                                 
                                                   @endphp
                                                    {{ number_format($shelf_management_discount,2,".",",") }} 
                                                 </td>
                                                  <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->display_allowance == 0.0000) {
                                                        $display_allowance = 0;
                                                     }else{
                                                        $display_allowance = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->display_allowance/100);
                                                     }   
                                                   
                                                   @endphp
                                                    {{ number_format($display_allowance,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->bleach_management_project == 0.0000) {
                                                        $bleach_management_project = 0;
                                                     }else{
                                                        $bleach_management_project = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->bleach_management_project/100);
                                                     }   
                                                    
                                                   @endphp
                                                    {{ number_format($bleach_management_project,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->business_development_fund_discount == 0.0000) {
                                                        $business_development_fund_discount = 0;
                                                     }else{
                                                        $business_development_fund_discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->business_development_fund_discount/100);
                                                     }   
                                                    
                                                   @endphp
                                                    {{ number_format($business_development_fund_discount,2,".",",") }} 
                                                 </td>
                                                <td style="text-align: right;">
                                                   @php
                                                     $sub_total_3 = $shelf_management_discount + $display_allowance + $bleach_management_project + $business_development_fund_discount;
                                                   @endphp
                                                    {{ number_format($sub_total_3,2,".",",") }} 
                                                </td>
                                                <td style="text-align: right;">
                                                   @php
                                                     if ($received_discount_rate[$i]->others == 0.0000) {
                                                        $others = 0;
                                                     }else{
                                                        $others = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->others/100);
                                                     }   
                                                   @endphp
                                                    {{ number_format($others,2,".",",") }} 
                                                </td>
                                                <td style="text-align: right;">
                                                   @php
                                                     $total = $sub_total_1  + $sub_total_2 + $sub_total_3 + $others;
                                                   @endphp
                                                    {{ number_format($total,2,".",",") }} 
                                                 </td>
                                              @endfor 
                                              @for ($i=0; $i < $return_counter; $i++) 
                                                <tr>
                                                <td style="text-align: center;"><a target="_blank" href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id ."=". $return_order_data[$i]->principal->principal) }}">RET - {{ $return_order_data[$i]->id }}</a></td>
                                                <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->logistics_fee == 0.0000) {
                                                         $logistics_fee = 0;
                                                     }else{
                                                         $logistics_fee = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->logistics_fee/100);
                                                     }
                                                   @endphp
                                                    {{ number_format($logistics_fee*-1,2,".",",") }} 
                                                </td>        
                                                <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->selling_fee == 0.0000) {
                                                         $selling_fee = 0;
                                                     }else{
                                                         $selling_fee = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->selling_fee/100);
                                                     }
                                                    
                                                   @endphp
                                                    {{ number_format($selling_fee*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->cwo_discount == 0.0000) {
                                                         $cwo_discount = 0;
                                                     }else{
                                                          $cwo_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->cwo_discount/100);
                                                     }
                                                   @endphp
                                                    {{ number_format($cwo_discount*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $sub_total_1 = $logistics_fee + $selling_fee + $cwo_discount;
                                                   @endphp
                                                    {{ number_format($sub_total_1*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->vmi_discount == 0.0000) {
                                                        $vmi_discount = 0;
                                                     }else{
                                                        $vmi_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->vmi_discount/100);
                                                     }
                                                     
                                                   @endphp
                                                    {{ number_format($vmi_discount*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->per_category_sell_discount == 0.0000) {
                                                        $per_category_sell_discount = 0;
                                                     }else{
                                                       $per_category_sell_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->per_category_sell_discount/100);
                                                     }
                                                    
                                                   @endphp
                                                    {{ number_format($per_category_sell_discount*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->total_sell_discount == 0.0000) {
                                                        $total_sell_discount = 0;
                                                     }else{
                                                       $total_sell_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->total_sell_discount/100);
                                                     }
                                                    
                                                   @endphp
                                                    {{ number_format($total_sell_discount*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->dops_discount == 0.0000) {
                                                        $dops_discount = 0;
                                                     }else{
                                                        $dops_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->dops_discount/100);
                                                     }
                                                   @endphp
                                                    {{ number_format($dops_discount*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->dbs_discount == 0.0000) {
                                                        $dbs_discount = 0;
                                                     }else{
                                                        $dbs_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->dbs_discount/100);
                                                     }
                                                   @endphp
                                                    {{ number_format($dbs_discount*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->reach == 0.0000) {
                                                        $reach = 0;
                                                     }else{
                                                        $reach = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->reach/100);
                                                     }                                                 
                                                    @endphp
                                                    {{ number_format($reach*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php

                                                     $sub_total_2 = $vmi_discount + $per_category_sell_discount + $total_sell_discount + $dops_discount + $dbs_discount + $reach;
                                                   @endphp
                                                    {{ number_format($sub_total_2*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->shelf_management_discount == 0.0000) {
                                                        $shelf_management_discount = 0;
                                                     }else{
                                                        $shelf_management_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->shelf_management_discount/100);
                                                     }   
                                                 
                                                   @endphp
                                                    {{ number_format($shelf_management_discount*-1,2,".",",") }} 
                                                 </td>
                                                  <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->display_allowance == 0.0000) {
                                                        $display_allowance = 0;
                                                     }else{
                                                        $display_allowance = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->display_allowance/100);
                                                     }   
                                                   
                                                   @endphp
                                                    {{ number_format($display_allowance*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->bleach_management_project == 0.0000) {
                                                        $bleach_management_project = 0;
                                                     }else{
                                                        $bleach_management_project = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bleach_management_project/100);
                                                     }   
                                                    
                                                   @endphp
                                                    {{ number_format($bleach_management_project*-1,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->business_development_fund_discount == 0.0000) {
                                                        $business_development_fund_discount = 0;
                                                     }else{
                                                        $business_development_fund_discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->business_development_fund_discount/100);
                                                     }   
                                                    
                                                   @endphp
                                                    {{ number_format($business_development_fund_discount*-1,2,".",",") }} 
                                                 </td>
                                                <td style="text-align: right;">
                                                   @php
                                                     $sub_total_3 = $shelf_management_discount + $display_allowance + $bleach_management_project + $business_development_fund_discount;
                                                   @endphp
                                                    {{ number_format($sub_total_3*-1,2,".",",") }} 
                                                </td>
                                                <td style="text-align: right;">
                                                   @php
                                                     if ($return_discount_rate[$i]->others == 0.0000) {
                                                        $others = 0;
                                                     }else{
                                                        $others = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->others/100);
                                                     }   
                                                   @endphp
                                                    {{ number_format($others*-1,2,".",",") }} 
                                                </td>
                                                <td style="text-align: right;">
                                                   @php
                                                     $total = $sub_total_1  + $sub_total_2 + $sub_total_3 + $others;
                                                   @endphp
                                                    {{ number_format($total*-1,2,".",",") }} 
                                                 </td>
                                                                    
                                                </tr>
                                              @endfor
                                          </tbody>
                                        </table>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation_all', $date_from ."=". $date_to ."=". $principal_id ."=". $principal_name) }}">PRINT THIS</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                          </td>
                          <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                          {{ 
                            number_format(array_sum($sum_received_tab_bo_allowance) - array_sum($sum_received_tab_return_bo_allowance) + array_sum($sum_received_tab_bo_adjustment_bo_allowance_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_bo_allowance),2,".",",") 
                          }}
                          </td>
                          <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                          {{ 
                            number_format(array_sum($sum_received_tab_net_discount) - array_sum($sum_received_tab_return_net_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_net_discount),2,".",",") 
                          }}
                          </td>
                          <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                          {{ 
                            number_format(array_sum($sum_received_tab_vat_amount) - array_sum($sum_received_tab_return_vat_amount) - array_sum($sum_received_tab_bo_adjustment_vat_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_vat_amount),2,".",",") 
                          }}
                          </td>
                          <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">0</td>
                          <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                          {{ 
                            number_format(array_sum($sum_received_tab_net_of_amount) - array_sum($sum_received_tab_return_net_of_deduction) - array_sum($sum_received_tab_bo_adjustment_net_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_net_adjustment),2,".",",") 
                          }}
                          </td>
                        </tr>

                        </tbody>
                    </table>
                  </div>
         @elseif($principal_name == 'PPMC')

                      <div class="table table-responsive">
                        <table class="table table-bordered table-hovered" style="font-size:15px;">
                        <thead>
                          <tr >
                            <th style="text-align: center;">Receving<br />Report</th>
                            <th style="text-align: center;">Invoice<br />No</th>
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Total<br />Invoice</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Trade<br />Discount 1</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Trade<br />Discount 2</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Dizer<br />Allowance</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Dste</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Optimix</th>
                            <th style="text-align: center;background-color:#a4ff4f;">BO <br />Allowance</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Total <br />Discount</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Value<br />Added<br />Tax</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Freight</th>
                            <th style="text-align: center;background-color:#a4ff4f;">Net<br />Amount<br />Paid</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if ($received_order_data != NULL)
                            @foreach ($received_order_data as $data)
                              <tr>
                                <td style="text-align: center">{{ $data->id }}</td>
                                <td style="text-align: center">{{ $data->dr_si }}</td>
                                <td style="text-align: center">{{ $data->date }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($data->vatable_purchase,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($trade_discount_1,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($trade_discount_2,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($dizer_allowance,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($dste,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($optimix,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($data->total_bo_allowance,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($data->net_discount,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($data->vat_amount,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($data->freight,2,".",",") }}</td>
                                <td style="text-align: right;background-color:#a4ff4f;">{{ number_format($data->grand_final_total_cost,2,".",",") }}</td>
                              </tr>
                            @endforeach
                          @else
                            <td colspan="14" style="font-weight: bold;text-align: center">NO DATA FOUND!</td>
                          
                          @endif
                        </tbody>
                      </table>
                      </div>
         @elseif($principal_name == 'PFC')
                  <div class="table table-responsive">
                              <table class="table table-bordered table-hovered" style="font-size:18px;">
                                <thead>
                                  <tr >
                                    <th style="text-align: center;">Reference<br />#</th>
                                    <th style="text-align: center;">Invoice<br />No</th>
                                    <th style="text-align: center;">Date</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Total<br />Invoice</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Discount</th>
                                    <th style="text-align: center;background-color:#a4ff4f">BO <br />Allowance</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Net <br />Of<br />Discount</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Value<br />Added<br />Tax</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Freight</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Net<br />Amount</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @if($received_counter != 0)
                                    @for ($i=0; $i < $received_counter; $i++) 
                                      <tr>
                                        <td style="text-align: center;">
                                          <a target="_blank" href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}">RR - {{ $received_order_data[$i]->id }}</a>
                                        </td>
                                        <td style="text-align: center;text-transform: uppercase;">
                                          @if($received_order_data[$i]->invoice_image != '')
                                             <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                            {{ $received_order_data[$i]->dr_si }}
                                            </button>

                                            <!-- Modal -->
                                              <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                     <img src="{{  asset('/images/'. $received_order_data[$i]->invoice_image) }}" style="width:100%;">
                                                    </div>
                                                   
                                                  </div>
                                                </div>
                                              </div>
                                          @else
                                            {{ $received_order_data[$i]->dr_si }}
                                          @endif
                                        </td>
                                        <td style="text-align: center;">{{ $received_order_data[$i]->date }}</td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          {{ number_format($received_order_data[$i]->vatable_purchase,2,".",",")  }}
                                          @php
                                            $sum_received_tab_vatable_purchase[] = $received_order_data[$i]->vatable_purchase;
                                          @endphp
                                        </td>
                                        <td style="text-align: right;font-weight: bold;">
                                          <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $received_order_data[$i]->id }}">
                                          @php
                                            $sum_received_tab_total_discount[] = round($received_order_data[$i]->total_every_discount,2);
                                          @endphp
                                          {{ number_format($received_order_data[$i]->total_every_discount,2,".",",") }}
                                          
                                          </button>
                                           <div class="modal fade " id="exampleModal{{ $received_order_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="table table-responsive">
                                                     <table class="table table-bordered" style="font-size:15px">
                                                    <thead>
                                                      <tr>
                                                        <th style="text-align: center;">REF #</th>
                                                        <th style="text-align: center;">DISCOUNT</th>
                                                      </tr>
                                                     
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                          <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $received_order_data[$i]->id }}</a></td>
                                                          <td>
                                                             @php
                                                               if ($received_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount,2,".",",") }} 
                                                          </td>        
                                                          
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  {{-- <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation', $received_order_data[$i]->id ."=". $principal_name ."=". $logistics_fee ."=". $selling_fee ."=". $cwo_discount ."=". $vmi_discount ."=". $per_category_sell_discount ."=". $total_sell_discount ."=". $dops_discount ."=". $dbs_discount ."=". $reach ."=". $shelf_management_discount ."=". $display_allowance ."=". $bleach_management_project ."=". $business_development_fund_discount ."=". $others ) }}">PRINT THIS</a> --}}
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </td>
                                         <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_bo_allowance[] = round($received_order_data[$i]->total_bo_allowance,2);
                                          @endphp
                                        {{ number_format(round($received_order_data[$i]->total_bo_allowance,2),2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_net_discount[] = round($received_order_data[$i]->net_discount,2);
                                          @endphp
                                           {{ number_format(round($received_order_data[$i]->net_discount,2),2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          
                                          @php
                                            $sum_received_tab_vat_amount[] = round($received_order_data[$i]->vat_amount,2);
                                          @endphp
                                          {{ number_format(round($received_order_data[$i]->vat_amount,2),2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_freight[] = $received_order_data[$i]->freight;
                                          @endphp
                                          {{ number_format($received_order_data[$i]->freight,2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_net_of_amount[] = round($received_order_data[$i]->grand_final_total_cost,2);
                                          @endphp
                                          {{ number_format(round($received_order_data[$i]->grand_final_total_cost,2),2,".",",") }}
                                        </td>
                                      </tr>
                                    @endfor
                                  @else
                                    @php
                                              $sum_received_tab_vatable_purchase[] = 0;
                                              $sum_received_tab_total_discount[] = 0;
                                              $sum_received_tab_bo_allowance[] = 0;
                                              $sum_received_tab_net_discount[] = 0;
                                              $sum_received_tab_vat_amount[] = 0;
                                              $sum_received_tab_net_of_amount[] = 0;
                                    @endphp
                                  @endif
                                  @if($return_counter != 0)
                                      @for ($i=0; $i < $return_counter; $i++) 
                                        <tr>
                                          <td style="text-align: center;">
                                            <a target="_blank" href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id ."=". $return_order_data[$i]->principal->principal) }}">RET - {{ $return_order_data[$i]->id }}</a>
                                          </td>
                                          <td style="text-align: center;text-transform: uppercase;">
                                            @if($return_order_data[$i]->invoice_image != '')
                                                 <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                                {{ $return_order_data[$i]->received->dr_si }}
                                                </button>

                                                <!-- Modal -->
                                                  <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                         <img src="{{  asset('/images/'. $return_order_data[$i]->invoice_image) }}" style="width:100%;">
                                                        </div>
                                                       
                                                      </div>
                                                    </div>
                                                  </div>
                                              @else
                                                {{ $return_order_data[$i]->received->dr_si }}
                                              @endif
                                          </td>
                                          <td style="text-align: center;">{{ $return_order_data[$i]->date }}</td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                              $sum_received_tab_return_vatable_purchase[] = $return_order_data[$i]->return_vatable_purchase;
                                            @endphp
                                            {{  number_format(($return_order_data[$i]->return_vatable_purchase)*-1,2,".",",") }}
                                          </td>
                                          <td style="text-align: right;font-weight: bold;">
                                          <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $return_order_data[$i]->id }}">
                                          @php
                                            $sum_received_tab_return_total_discount[] = round($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100),2);
                                          @endphp
                                          {{ number_format($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100)*-1,2,".",",") }}
                                          
                                          </button>
                                          <div class="modal fade " id="exampleModal{{ $return_order_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="table table-responsive">
                                                     <table class="table table-bordered" style="font-size:15px">
                                                    <thead>
                                                      <tr>
                                                        <th style="text-align: center;">REF #</th>
                                                        <th style="text-align: center;">DISCOUNT</th>
                                                      </tr>
                                                     
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                          <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $return_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $return_order_data[$i]->id }}</a></td>
                                                          <td>
                                                             @php
                                                               if ($return_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount*-1,2,".",",") }} 
                                                          </td>        
                                                          
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  {{-- <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation', $received_order_data[$i]->id ."=". $principal_name ."=". $logistics_fee ."=". $selling_fee ."=". $cwo_discount ."=". $vmi_discount ."=". $per_category_sell_discount ."=". $total_sell_discount ."=". $dops_discount ."=". $dbs_discount ."=". $reach ."=". $shelf_management_discount ."=". $display_allowance ."=". $bleach_management_project ."=". $business_development_fund_discount ."=". $others ) }}">PRINT THIS</a> --}}
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_bo_allowance[] = round($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100,2);
                                          @endphp
                                          {{ number_format(round(($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100)*-1,2),2,".",",")  }}
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_net_discount[] = round($return_order_data[$i]->return_net_discount,2);
                                          @endphp
                                            {{ number_format(round(($return_order_data[$i]->return_net_discount)*-1,2),2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_vat_amount[] = round($return_order_data[$i]->return_vat_amount,2);
                                          @endphp
                                            {{ number_format(round(($return_order_data[$i]->return_vat_amount)*-1,2),2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">0</td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_net_of_deduction[] = round($return_order_data[$i]->return_net_of_deduction,2);
                                          @endphp
                                            {{ number_format(round(($return_order_data[$i]->return_net_of_deduction)*-1,2),2,".",",") }}
                                          </td>
                                        </tr>
                                      @endfor
                                  @else
                                        @php
                                          $sum_received_tab_return_vatable_purchase[] = 0;
                                          $sum_received_tab_return_total_discount[] = 0;
                                          $sum_received_tab_return_bo_allowance[] = 0;
                                          $sum_received_tab_return_net_discount[] = 0;
                                          $sum_received_tab_return_vat_amount[] = 0;
                                          $sum_received_tab_return_net_of_deduction[] = 0;
                                        @endphp
                                  @endif
                                  @if($bo_counter != 0)
                                       @for ($i=0; $i < $bo_counter; $i++) 
                                        <tr>
                                          <td style="text-align: center;">
                                             <a href="{{ route('bo_allowance_adjustments_show_details', $bo_adjustment_data[$i]->id ."=". $bo_adjustment_data[$i]->principal->principal ."=". $bo_adjustment_data[$i]->particulars) }}" target="_blank">DM - BO {{ $bo_adjustment_data[$i]->id }}</a> 
                                          </td>
                                          <td style="text-align: center;text-transform: uppercase;">
                                            @if($bo_adjustment_data[$i]->invoice_image != '')
                                               <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                              {{ $bo_adjustment_data[$i]->received->dr_si }}
                                              </button>

                                              <!-- Modal -->
                                                <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                      </div>
                                                      <div class="modal-body">
                                                       <img src="{{  asset('/images/'. $bo_adjustment_data[$i]->invoice_image) }}" style="width:100%;">
                                                      </div>
                                                     
                                                    </div>
                                                  </div>
                                                </div>
                                            @else
                                              {{ $bo_adjustment_data[$i]->received->dr_si }}
                                            @endif
                                          </td>
                                          <td style="text-align: center;">{{ $bo_adjustment_data[$i]->date }}</td>
                                          <td style="text-align: right;color:green;font-weight: bold;;">
                                            {{ number_format(0,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;;">
                                            {{ number_format(0,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_total_discount[] = 0;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format($bo_adjustment_data[$i]->bo_allowance_deduction,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = $bo_adjustment_data[$i]->bo_allowance_deduction;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">{{ number_format(0,2,".",",") }}</td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                            {{ number_format($bo_adjustment_data[$i]->vat_deduction*-1,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_vat_deduction[] = $bo_adjustment_data[$i]->vat_deduction;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format(0,2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color: red;font-weight: bold;">
                                            {{ number_format($bo_adjustment_data[$i]->net_deduction*-1,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_net_deduction[] = $bo_adjustment_data[$i]->net_deduction;
                                            @endphp
                                          </td>

                                        </tr>
                                       @endfor
                                  @else
                                      @php
                                       $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = 0;
                                       $sum_received_tab_bo_adjustment_vat_deduction[] = 0;
                                       $sum_received_tab_bo_adjustment_net_deduction[] = 0;
                                       $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                                       $sum_received_tab_bo_adjustment_total_discount[] = 0;
                                      @endphp
                                  @endif
                                  @if($invoice_counter != 0)
                                       @for ($i=0; $i < $invoice_counter; $i++) 
                                         <tr>
                                          <td style="text-align: center;">
                                             <a href="{{ route('bo_allowance_adjustments_show_details', $invoice_cost_data[$i]->id ."=". $invoice_cost_data[$i]->principal->principal ."=". $invoice_cost_data[$i]->particulars) }}" target="_blank">INVOICE - ADJUSTMENT {{ $invoice_cost_data[$i]->id }}</a> 
                                          </td>
                                          <td style="text-align: center;text-transform: uppercase;">
                                            @if($invoice_cost_data[$i]->invoice_image != '')
                                               <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                              {{ $invoice_cost_data[$i]->received->dr_si }}
                                              </button>

                                              <!-- Modal -->
                                                <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                      </div>
                                                      <div class="modal-body">
                                                       <img src="{{  asset('/images/'. $invoice_cost_data[$i]->invoice_image) }}" style="width:100%;">
                                                      </div>
                                                     
                                                    </div>
                                                  </div>
                                                </div>
                                            @else
                                              {{ $invoice_cost_data[$i]->received->dr_si }}
                                            @endif
                                          </td>
                                          <td style="text-align: center;">{{ $invoice_cost_data[$i]->date }}</td>
                                          <td style="text-align: right;color:green;font-weight: bold;;">
                                            
                                            @php
                                              $received_tab_invoice_cost_adjustment_vatable_purchase = $invoice_cost_data[$i]->vatable_purchase;
                                              $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_vatable_purchase > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase,2,".",",")  }}</span>
                                            @endif
                                             
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_less_discount = $invoice_cost_data[$i]->less_discount;
                                              $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_less_discount > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_less_discount,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_less_discount,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_bo_allowance = $invoice_cost_data[$i]->total_bo_allowance;
                                              $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_bo_allowance > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_net_discount = $invoice_cost_data[$i]->net_discount;
                                              $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_net_discount > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_discount,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_discount,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_vat_amount = $invoice_cost_data[$i]->vat_amount;
                                              $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_vat_amount > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format(0,2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color: red;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_net_adjustment = $invoice_cost_data[$i]->net_adjustment;
                                              $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_net_adjustment > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                        </tr>
                                       @endfor
                                  @else
                                        @php
                                          $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                                        @endphp
                                  @endif
                                  <tr>
                                    <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_vatable_purchase) - array_sum($sum_received_tab_return_vatable_purchase) + - array_sum($sum_received_tab_invoice_cost_adjustment_vatable_purchase) ,2,".",",") 
                                    }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;;">
                                          <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#grand_total">
                                              {{ 
                                                number_format(array_sum($sum_received_tab_total_discount) - array_sum($sum_received_tab_return_total_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_less_discount),2,".",",") 
                                              }}
                                          </button>

                                          <!-- Modal -->
                                          <div class="modal fade " id="grand_total" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg mw-100 w-100" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="table table-responsive">
                                                     <table class="table table-bordered" style="font-size:15px">
                                                    <thead>
                                                      <tr>
                                                        <th style="text-align: center;">REF #</th>
                                                        <th style="text-align: center;">DISCOUNT</th>
                                                        <th style="text-align: center;">BO ALLOWANCE</th>
                                                      </tr>
                                                     
                                                    </thead>
                                                    <tbody>
                                                      @for ($i=0; $i < $received_counter; $i++) 
                                                        <tr>
                                                          <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $received_order_data[$i]->id }}</a></td>
                                                              <td style="text-align: right;">
                                                             @php
                                                               if ($received_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount,2,".",",") }} 
                                                          </td>        
                                                          <td style="text-align: right;">
                                                             @php
                                                               if ($received_discount_rate[$i]->bo_allowance == 0.0000) {
                                                                   $bo_allowance = 0;
                                                               }else{
                                                                   $bo_allowance = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->bo_allowance/100);
                                                               }
                                                              
                                                             @endphp
                                                              {{ number_format($bo_allowance,2,".",",") }} 
                                                           </td>
                                                          
                                                        </tr>
                                                      @endfor 




                                                      @for ($i=0; $i < $return_counter; $i++) 
                                                        <tr>
                                                          <td style="text-align: center;"><a target="_blank" href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id ."=". $return_order_data[$i]->principal->principal) }}">RET - {{ $return_order_data[$i]->id }}</a></td>
                                                          <td style="text-align: right;">
                                                             @php
                                                               if ($return_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount*-1,2,".",",") }} 
                                                          </td>        
                                                          <td style="text-align: right;">
                                                             @php
                                                               if ($return_discount_rate[$i]->bo_allowance == 0.0000) {
                                                                   $bo_allowance = 0;
                                                               }else{
                                                                   $bo_allowance = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_allowance/100);
                                                               }
                                                              
                                                             @endphp
                                                              {{ number_format($bo_allowance*-1,2,".",",") }} 
                                                           </td>

                                                        </tr>
                                                      @endfor
                                                    </tbody>
                                                  </table>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation_all', $date_from ."=". $date_to ."=". $principal_id ."=". $principal_name) }}">PRINT THIS</a>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_bo_allowance) - array_sum($sum_received_tab_return_bo_allowance) + array_sum($sum_received_tab_bo_adjustment_bo_allowance_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_bo_allowance),2,".",",") 
                                    }}
                                    </td>
                                     <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_net_discount) - array_sum($sum_received_tab_return_net_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_net_discount),2,".",",") 
                                    }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_vat_amount) - array_sum($sum_received_tab_return_vat_amount) - array_sum($sum_received_tab_bo_adjustment_vat_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_vat_amount),2,".",",") 
                                    }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">0</td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_net_of_amount) - array_sum($sum_received_tab_return_net_of_deduction) - array_sum($sum_received_tab_bo_adjustment_net_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_net_adjustment),2,".",",") 
                                    }}
                                    </td>
                                   
                                  </tr>
                                 
                                </tbody>
                              </table>
          </div>
         @elseif($principal_name == 'EPI')
                    <div class="table table-responsive">
                              <table class="table table-bordered table-hovered" style="font-size:18px;">
                                <thead>
                                  <tr >
                                    <th style="text-align: center;">Reference<br />#</th>
                                    <th style="text-align: center;">Invoice<br />No</th>
                                    <th style="text-align: center;">Date</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Total<br />Invoice</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Discount</th>
                                    <th style="text-align: center;background-color:#a4ff4f">BO <br />Allowance</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Net <br />Of<br />Discount</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Value<br />Added<br />Tax</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Freight</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Net<br />Amount</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @if($received_counter != 0)
                                    @for ($i=0; $i < $received_counter; $i++) 
                                      <tr>
                                        <td style="text-align: center;">
                                          <a target="_blank" href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}">RR - {{ $received_order_data[$i]->id }}</a>
                                        </td>
                                        <td style="text-align: center;text-transform: uppercase;">
                                          @if($received_order_data[$i]->invoice_image != '')
                                             <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                            {{ $received_order_data[$i]->dr_si }}
                                            </button>

                                            <!-- Modal -->
                                              <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                     <img src="{{  asset('/images/'. $received_order_data[$i]->invoice_image) }}" style="width:100%;">
                                                    </div>
                                                   
                                                  </div>
                                                </div>
                                              </div>
                                          @else
                                            {{ $received_order_data[$i]->dr_si }}
                                          @endif
                                        </td>
                                        <td style="text-align: center;">{{ $received_order_data[$i]->date }}</td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          {{ number_format($received_order_data[$i]->vatable_purchase,2,".",",")  }}
                                          @php
                                            $sum_received_tab_vatable_purchase[] = $received_order_data[$i]->vatable_purchase;
                                          @endphp
                                        </td>
                                        <td style="text-align: right;font-weight: bold;">
                                          <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $received_order_data[$i]->id }}">
                                          @php
                                            $sum_received_tab_total_discount[] = round($received_order_data[$i]->total_every_discount,2);
                                          @endphp
                                          {{ number_format($received_order_data[$i]->total_every_discount,2,".",",") }}
                                          
                                          </button>
                                           <div class="modal fade " id="exampleModal{{ $received_order_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="table table-responsive">
                                                     <table class="table table-bordered" style="font-size:15px">
                                                    <thead>
                                                      <tr>
                                                        <th style="text-align: center;">REF #</th>
                                                        <th style="text-align: center;">DISCOUNT</th>
                                                      </tr>
                                                     
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                          <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $received_order_data[$i]->id }}</a></td>
                                                          <td>
                                                             @php
                                                               if ($received_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount,2,".",",") }} 
                                                          </td>        
                                                          
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  {{-- <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation', $received_order_data[$i]->id ."=". $principal_name ."=". $logistics_fee ."=". $selling_fee ."=". $cwo_discount ."=". $vmi_discount ."=". $per_category_sell_discount ."=". $total_sell_discount ."=". $dops_discount ."=". $dbs_discount ."=". $reach ."=". $shelf_management_discount ."=". $display_allowance ."=". $bleach_management_project ."=". $business_development_fund_discount ."=". $others ) }}">PRINT THIS</a> --}}
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </td>
                                         <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_bo_allowance[] = round($received_order_data[$i]->total_bo_allowance,2);
                                          @endphp
                                        {{ number_format(round($received_order_data[$i]->total_bo_allowance,2),2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_net_discount[] = round($received_order_data[$i]->net_discount,2);
                                          @endphp
                                           {{ number_format(round($received_order_data[$i]->net_discount,2),2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          
                                          @php
                                            $sum_received_tab_vat_amount[] = round($received_order_data[$i]->vat_amount,2);
                                          @endphp
                                          {{ number_format(round($received_order_data[$i]->vat_amount,2),2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_freight[] = $received_order_data[$i]->freight;
                                          @endphp
                                          {{ number_format($received_order_data[$i]->freight,2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_net_of_amount[] = round($received_order_data[$i]->grand_final_total_cost,2);
                                          @endphp
                                          {{ number_format(round($received_order_data[$i]->grand_final_total_cost,2),2,".",",") }}
                                        </td>
                                      </tr>
                                    @endfor
                                  @else
                                    @php
                                              $sum_received_tab_vatable_purchase[] = 0;
                                              $sum_received_tab_total_discount[] = 0;
                                              $sum_received_tab_bo_allowance[] = 0;
                                              $sum_received_tab_net_discount[] = 0;
                                              $sum_received_tab_vat_amount[] = 0;
                                              $sum_received_tab_net_of_amount[] = 0;
                                    @endphp
                                  @endif
                                  @if($return_counter != 0)
                                      @for ($i=0; $i < $return_counter; $i++) 
                                        <tr>
                                          <td style="text-align: center;">
                                            <a target="_blank" href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id ."=". $return_order_data[$i]->principal->principal) }}">RET - {{ $return_order_data[$i]->id }}</a>
                                          </td>
                                          <td style="text-align: center;text-transform: uppercase;">
                                            @if($return_order_data[$i]->invoice_image != '')
                                                 <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                                {{ $return_order_data[$i]->received->dr_si }}
                                                </button>

                                                <!-- Modal -->
                                                  <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                         <img src="{{  asset('/images/'. $return_order_data[$i]->invoice_image) }}" style="width:100%;">
                                                        </div>
                                                       
                                                      </div>
                                                    </div>
                                                  </div>
                                              @else
                                                {{ $return_order_data[$i]->received->dr_si }}
                                              @endif
                                          </td>
                                          <td style="text-align: center;">{{ $return_order_data[$i]->date }}</td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                              $sum_received_tab_return_vatable_purchase[] = $return_order_data[$i]->return_vatable_purchase;
                                            @endphp
                                            {{  number_format(($return_order_data[$i]->return_vatable_purchase)*-1,2,".",",") }}
                                          </td>
                                          <td style="text-align: right;font-weight: bold;">
                                          <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $return_order_data[$i]->id }}">
                                          @php
                                            $sum_received_tab_return_total_discount[] = round($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100),2);
                                          @endphp
                                          {{ number_format($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100)*-1,2,".",",") }}
                                          
                                          </button>
                                          <div class="modal fade " id="exampleModal{{ $return_order_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="table table-responsive">
                                                     <table class="table table-bordered" style="font-size:15px">
                                                    <thead>
                                                      <tr>
                                                        <th style="text-align: center;">REF #</th>
                                                        <th style="text-align: center;">DISCOUNT</th>
                                                      </tr>
                                                     
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                          <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $return_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $return_order_data[$i]->id }}</a></td>
                                                          <td>
                                                             @php
                                                               if ($return_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount*-1,2,".",",") }} 
                                                          </td>        
                                                          
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  {{-- <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation', $received_order_data[$i]->id ."=". $principal_name ."=". $logistics_fee ."=". $selling_fee ."=". $cwo_discount ."=". $vmi_discount ."=". $per_category_sell_discount ."=". $total_sell_discount ."=". $dops_discount ."=". $dbs_discount ."=". $reach ."=". $shelf_management_discount ."=". $display_allowance ."=". $bleach_management_project ."=". $business_development_fund_discount ."=". $others ) }}">PRINT THIS</a> --}}
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_bo_allowance[] = round($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100,2);
                                          @endphp
                                          {{ number_format(round(($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100)*-1,2),2,".",",")  }}
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_net_discount[] = round($return_order_data[$i]->return_net_discount,2);
                                          @endphp
                                            {{ number_format(round(($return_order_data[$i]->return_net_discount)*-1,2),2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_vat_amount[] = round($return_order_data[$i]->return_vat_amount,2);
                                          @endphp
                                            {{ number_format(round(($return_order_data[$i]->return_vat_amount)*-1,2),2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">0</td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_net_of_deduction[] = round($return_order_data[$i]->return_net_of_deduction,2);
                                          @endphp
                                            {{ number_format(round(($return_order_data[$i]->return_net_of_deduction)*-1,2),2,".",",") }}
                                          </td>
                                        </tr>
                                      @endfor
                                  @else
                                        @php
                                          $sum_received_tab_return_vatable_purchase[] = 0;
                                          $sum_received_tab_return_total_discount[] = 0;
                                          $sum_received_tab_return_bo_allowance[] = 0;
                                          $sum_received_tab_return_net_discount[] = 0;
                                          $sum_received_tab_return_vat_amount[] = 0;
                                          $sum_received_tab_return_net_of_deduction[] = 0;
                                        @endphp
                                  @endif
                                  @if($bo_counter != 0)
                                       @for ($i=0; $i < $bo_counter; $i++) 
                                        <tr>
                                          <td style="text-align: center;">
                                             <a href="{{ route('bo_allowance_adjustments_show_details', $bo_adjustment_data[$i]->id ."=". $bo_adjustment_data[$i]->principal->principal ."=". $bo_adjustment_data[$i]->particulars) }}" target="_blank">DM - BO {{ $bo_adjustment_data[$i]->id }}</a> 
                                          </td>
                                          <td style="text-align: center;text-transform: uppercase;">
                                            @if($bo_adjustment_data[$i]->invoice_image != '')
                                               <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                              {{ $bo_adjustment_data[$i]->received->dr_si }}
                                              </button>

                                              <!-- Modal -->
                                                <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                      </div>
                                                      <div class="modal-body">
                                                       <img src="{{  asset('/images/'. $bo_adjustment_data[$i]->invoice_image) }}" style="width:100%;">
                                                      </div>
                                                     
                                                    </div>
                                                  </div>
                                                </div>
                                            @else
                                              {{ $bo_adjustment_data[$i]->received->dr_si }}
                                            @endif
                                          </td>
                                          <td style="text-align: center;">{{ $bo_adjustment_data[$i]->date }}</td>
                                          <td style="text-align: right;color:green;font-weight: bold;;">
                                            {{ number_format(0,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;;">
                                            {{ number_format(0,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_total_discount[] = 0;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format($bo_adjustment_data[$i]->bo_allowance_deduction,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = $bo_adjustment_data[$i]->bo_allowance_deduction;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">{{ number_format(0,2,".",",") }}</td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                            {{ number_format($bo_adjustment_data[$i]->vat_deduction*-1,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_vat_deduction[] = $bo_adjustment_data[$i]->vat_deduction;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format(0,2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color: red;font-weight: bold;">
                                            {{ number_format($bo_adjustment_data[$i]->net_deduction*-1,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_net_deduction[] = $bo_adjustment_data[$i]->net_deduction;
                                            @endphp
                                          </td>

                                        </tr>
                                       @endfor
                                  @else
                                      @php
                                       $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = 0;
                                       $sum_received_tab_bo_adjustment_vat_deduction[] = 0;
                                       $sum_received_tab_bo_adjustment_net_deduction[] = 0;
                                       $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                                       $sum_received_tab_bo_adjustment_total_discount[] = 0;
                                      @endphp
                                  @endif
                                  @if($invoice_counter != 0)
                                       @for ($i=0; $i < $invoice_counter; $i++) 
                                         <tr>
                                          <td style="text-align: center;">
                                             <a href="{{ route('bo_allowance_adjustments_show_details', $invoice_cost_data[$i]->id ."=". $invoice_cost_data[$i]->principal->principal ."=". $invoice_cost_data[$i]->particulars) }}" target="_blank">INVOICE - ADJUSTMENT {{ $invoice_cost_data[$i]->id }}</a> 
                                          </td>
                                          <td style="text-align: center;text-transform: uppercase;">
                                            @if($invoice_cost_data[$i]->invoice_image != '')
                                               <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                              {{ $invoice_cost_data[$i]->received->dr_si }}
                                              </button>

                                              <!-- Modal -->
                                                <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                      </div>
                                                      <div class="modal-body">
                                                       <img src="{{  asset('/images/'. $invoice_cost_data[$i]->invoice_image) }}" style="width:100%;">
                                                      </div>
                                                     
                                                    </div>
                                                  </div>
                                                </div>
                                            @else
                                              {{ $invoice_cost_data[$i]->received->dr_si }}
                                            @endif
                                          </td>
                                          <td style="text-align: center;">{{ $invoice_cost_data[$i]->date }}</td>
                                          <td style="text-align: right;color:green;font-weight: bold;;">
                                            
                                            @php
                                              $received_tab_invoice_cost_adjustment_vatable_purchase = $invoice_cost_data[$i]->vatable_purchase;
                                              $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_vatable_purchase > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase,2,".",",")  }}</span>
                                            @endif
                                             
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_less_discount = $invoice_cost_data[$i]->less_discount;
                                              $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_less_discount > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_less_discount,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_less_discount,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_bo_allowance = $invoice_cost_data[$i]->total_bo_allowance;
                                              $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_bo_allowance > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_net_discount = $invoice_cost_data[$i]->net_discount;
                                              $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_net_discount > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_discount,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_discount,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_vat_amount = $invoice_cost_data[$i]->vat_amount;
                                              $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_vat_amount > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format(0,2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color: red;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_net_adjustment = $invoice_cost_data[$i]->net_adjustment;
                                              $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_net_adjustment > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                        </tr>
                                       @endfor
                                  @else
                                        @php
                                          $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                                        @endphp
                                  @endif
                                  <tr>
                                    <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_vatable_purchase) - array_sum($sum_received_tab_return_vatable_purchase) + - array_sum($sum_received_tab_invoice_cost_adjustment_vatable_purchase) ,2,".",",") 
                                    }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;;">
                                          <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#grand_total">
                                              {{ 
                                                number_format(array_sum($sum_received_tab_total_discount) - array_sum($sum_received_tab_return_total_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_less_discount),2,".",",") 
                                              }}
                                          </button>

                                          <!-- Modal -->
                                          <div class="modal fade " id="grand_total" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg mw-100 w-100" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="table table-responsive">
                                                     <table class="table table-bordered" style="font-size:15px">
                                                    <thead>
                                                      <tr>
                                                        <th style="text-align: center;">REF #</th>
                                                        <th style="text-align: center;">DISCOUNT</th>
                                                        <th style="text-align: center;">BO ALLOWANCE</th>
                                                      </tr>
                                                     
                                                    </thead>
                                                    <tbody>
                                                      @for ($i=0; $i < $received_counter; $i++) 
                                                        <tr>
                                                          <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $received_order_data[$i]->id }}</a></td>
                                                              <td style="text-align: right;">
                                                             @php
                                                               if ($received_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount,2,".",",") }} 
                                                          </td>        
                                                          <td style="text-align: right;">
                                                             @php
                                                               if ($received_discount_rate[$i]->bo_allowance == 0.0000) {
                                                                   $bo_allowance = 0;
                                                               }else{
                                                                   $bo_allowance = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->bo_allowance/100);
                                                               }
                                                              
                                                             @endphp
                                                              {{ number_format($bo_allowance,2,".",",") }} 
                                                           </td>
                                                          
                                                        </tr>
                                                      @endfor 




                                                      @for ($i=0; $i < $return_counter; $i++) 
                                                        <tr>
                                                          <td style="text-align: center;"><a target="_blank" href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id ."=". $return_order_data[$i]->principal->principal) }}">RET - {{ $return_order_data[$i]->id }}</a></td>
                                                          <td style="text-align: right;">
                                                             @php
                                                               if ($return_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount*-1,2,".",",") }} 
                                                          </td>        
                                                          <td style="text-align: right;">
                                                             @php
                                                               if ($return_discount_rate[$i]->bo_allowance == 0.0000) {
                                                                   $bo_allowance = 0;
                                                               }else{
                                                                   $bo_allowance = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_allowance/100);
                                                               }
                                                              
                                                             @endphp
                                                              {{ number_format($bo_allowance*-1,2,".",",") }} 
                                                           </td>

                                                        </tr>
                                                      @endfor
                                                    </tbody>
                                                  </table>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation_all', $date_from ."=". $date_to ."=". $principal_id ."=". $principal_name) }}">PRINT THIS</a>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_bo_allowance) - array_sum($sum_received_tab_return_bo_allowance) + array_sum($sum_received_tab_bo_adjustment_bo_allowance_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_bo_allowance),2,".",",") 
                                    }}
                                    </td>
                                     <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_net_discount) - array_sum($sum_received_tab_return_net_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_net_discount),2,".",",") 
                                    }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_vat_amount) - array_sum($sum_received_tab_return_vat_amount) - array_sum($sum_received_tab_bo_adjustment_vat_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_vat_amount),2,".",",") 
                                    }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">0</td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_net_of_amount) - array_sum($sum_received_tab_return_net_of_deduction) - array_sum($sum_received_tab_bo_adjustment_net_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_net_adjustment),2,".",",") 
                                    }}
                                    </td>
                                   
                                  </tr>
                                 
                                </tbody>
                              </table>
                    </div>
         @elseif($principal_name == 'DOLE')
             <div class="table table-responsive">
                              <table class="table table-bordered table-hovered" style="font-size:18px;">
                                <thead>
                                  <tr >
                                    <th style="text-align: center;">Reference<br />#</th>
                                    <th style="text-align: center;">Invoice<br />No</th>
                                    <th style="text-align: center;">Date</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Total<br />Invoice</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Discount</th>
                                    <th style="text-align: center;background-color:#a4ff4f">BO <br />Allowance</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Net <br />Of<br />Discount</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Value<br />Added<br />Tax</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Freight</th>
                                    <th style="text-align: center;background-color:#a4ff4f">Net<br />Amount</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @if($received_counter != 0)
                                    @for ($i=0; $i < $received_counter; $i++) 
                                      <tr>
                                        <td style="text-align: center;">
                                          <a target="_blank" href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}">RR - {{ $received_order_data[$i]->id }}</a>
                                        </td>
                                        <td style="text-align: center;text-transform: uppercase;">
                                          @if($received_order_data[$i]->invoice_image != '')
                                             <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                            {{ $received_order_data[$i]->dr_si }}
                                            </button>

                                            <!-- Modal -->
                                              <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                     <img src="{{  asset('/images/'. $received_order_data[$i]->invoice_image) }}" style="width:100%;">
                                                    </div>
                                                   
                                                  </div>
                                                </div>
                                              </div>
                                          @else
                                            {{ $received_order_data[$i]->dr_si }}
                                          @endif
                                        </td>
                                        <td style="text-align: center;">{{ $received_order_data[$i]->date }}</td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          {{ number_format($received_order_data[$i]->vatable_purchase,2,".",",")  }}
                                          @php
                                            $sum_received_tab_vatable_purchase[] = $received_order_data[$i]->vatable_purchase;
                                          @endphp
                                        </td>
                                        <td style="text-align: right;font-weight: bold;">
                                          <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $received_order_data[$i]->id }}">
                                          @php
                                            $sum_received_tab_total_discount[] = round($received_order_data[$i]->total_every_discount,2);
                                          @endphp
                                          {{ number_format($received_order_data[$i]->total_every_discount,2,".",",") }}
                                          
                                          </button>
                                           <div class="modal fade " id="exampleModal{{ $received_order_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="table table-responsive">
                                                     <table class="table table-bordered" style="font-size:15px">
                                                    <thead>
                                                      <tr>
                                                        <th style="text-align: center;">REF #</th>
                                                        <th style="text-align: center;">DISCOUNT</th>
                                                      </tr>
                                                     
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                          <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $received_order_data[$i]->id }}</a></td>
                                                          <td>
                                                             @php
                                                               if ($received_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount,2,".",",") }} 
                                                          </td>        
                                                          
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  {{-- <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation', $received_order_data[$i]->id ."=". $principal_name ."=". $logistics_fee ."=". $selling_fee ."=". $cwo_discount ."=". $vmi_discount ."=". $per_category_sell_discount ."=". $total_sell_discount ."=". $dops_discount ."=". $dbs_discount ."=". $reach ."=". $shelf_management_discount ."=". $display_allowance ."=". $bleach_management_project ."=". $business_development_fund_discount ."=". $others ) }}">PRINT THIS</a> --}}
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </td>
                                         <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_bo_allowance[] = round($received_order_data[$i]->total_bo_allowance,2);
                                          @endphp
                                        {{ number_format(round($received_order_data[$i]->total_bo_allowance,2),2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_net_discount[] = round($received_order_data[$i]->net_discount,2);
                                          @endphp
                                           {{ number_format(round($received_order_data[$i]->net_discount,2),2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          
                                          @php
                                            $sum_received_tab_vat_amount[] = round($received_order_data[$i]->vat_amount,2);
                                          @endphp
                                          {{ number_format(round($received_order_data[$i]->vat_amount,2),2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_freight[] = $received_order_data[$i]->freight;
                                          @endphp
                                          {{ number_format($received_order_data[$i]->freight,2,".",",") }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                          @php
                                            $sum_received_tab_net_of_amount[] = round($received_order_data[$i]->grand_final_total_cost,2);
                                          @endphp
                                          {{ number_format(round($received_order_data[$i]->grand_final_total_cost,2),2,".",",") }}
                                        </td>
                                      </tr>
                                    @endfor
                                  @else
                                    @php
                                              $sum_received_tab_vatable_purchase[] = 0;
                                              $sum_received_tab_total_discount[] = 0;
                                              $sum_received_tab_bo_allowance[] = 0;
                                              $sum_received_tab_net_discount[] = 0;
                                              $sum_received_tab_vat_amount[] = 0;
                                              $sum_received_tab_net_of_amount[] = 0;
                                    @endphp
                                  @endif
                                  @if($return_counter != 0)
                                      @for ($i=0; $i < $return_counter; $i++) 
                                        <tr>
                                          <td style="text-align: center;">
                                            <a target="_blank" href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id ."=". $return_order_data[$i]->principal->principal) }}">RET - {{ $return_order_data[$i]->id }}</a>
                                          </td>
                                          <td style="text-align: center;text-transform: uppercase;">
                                            @if($return_order_data[$i]->invoice_image != '')
                                                 <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                                {{ $return_order_data[$i]->received->dr_si }}
                                                </button>

                                                <!-- Modal -->
                                                  <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                         <img src="{{  asset('/images/'. $return_order_data[$i]->invoice_image) }}" style="width:100%;">
                                                        </div>
                                                       
                                                      </div>
                                                    </div>
                                                  </div>
                                              @else
                                                {{ $return_order_data[$i]->received->dr_si }}
                                              @endif
                                          </td>
                                          <td style="text-align: center;">{{ $return_order_data[$i]->date }}</td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                              $sum_received_tab_return_vatable_purchase[] = $return_order_data[$i]->return_vatable_purchase;
                                            @endphp
                                            {{  number_format(($return_order_data[$i]->return_vatable_purchase)*-1,2,".",",") }}
                                          </td>
                                          <td style="text-align: right;font-weight: bold;">
                                          <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $return_order_data[$i]->id }}">
                                          @php
                                            $sum_received_tab_return_total_discount[] = round($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100),2);
                                          @endphp
                                          {{ number_format($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100)*-1,2,".",",") }}
                                          
                                          </button>
                                          <div class="modal fade " id="exampleModal{{ $return_order_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="table table-responsive">
                                                     <table class="table table-bordered" style="font-size:15px">
                                                    <thead>
                                                      <tr>
                                                        <th style="text-align: center;">REF #</th>
                                                        <th style="text-align: center;">DISCOUNT</th>
                                                      </tr>
                                                     
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                          <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $return_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $return_order_data[$i]->id }}</a></td>
                                                          <td>
                                                             @php
                                                               if ($return_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount*-1,2,".",",") }} 
                                                          </td>        
                                                          
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  {{-- <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation', $received_order_data[$i]->id ."=". $principal_name ."=". $logistics_fee ."=". $selling_fee ."=". $cwo_discount ."=". $vmi_discount ."=". $per_category_sell_discount ."=". $total_sell_discount ."=". $dops_discount ."=". $dbs_discount ."=". $reach ."=". $shelf_management_discount ."=". $display_allowance ."=". $bleach_management_project ."=". $business_development_fund_discount ."=". $others ) }}">PRINT THIS</a> --}}
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_bo_allowance[] = round($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100,2);
                                          @endphp
                                          {{ number_format(round(($return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_discount)/100)*-1,2),2,".",",")  }}
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_net_discount[] = round($return_order_data[$i]->return_net_discount,2);
                                          @endphp
                                            {{ number_format(round(($return_order_data[$i]->return_net_discount)*-1,2),2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_vat_amount[] = round($return_order_data[$i]->return_vat_amount,2);
                                          @endphp
                                            {{ number_format(round(($return_order_data[$i]->return_vat_amount)*-1,2),2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">0</td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                          @php
                                            $sum_received_tab_return_net_of_deduction[] = round($return_order_data[$i]->return_net_of_deduction,2);
                                          @endphp
                                            {{ number_format(round(($return_order_data[$i]->return_net_of_deduction)*-1,2),2,".",",") }}
                                          </td>
                                        </tr>
                                      @endfor
                                  @else
                                        @php
                                          $sum_received_tab_return_vatable_purchase[] = 0;
                                          $sum_received_tab_return_total_discount[] = 0;
                                          $sum_received_tab_return_bo_allowance[] = 0;
                                          $sum_received_tab_return_net_discount[] = 0;
                                          $sum_received_tab_return_vat_amount[] = 0;
                                          $sum_received_tab_return_net_of_deduction[] = 0;
                                        @endphp
                                  @endif
                                  @if($bo_counter != 0)
                                       @for ($i=0; $i < $bo_counter; $i++) 
                                        <tr>
                                          <td style="text-align: center;">
                                             <a href="{{ route('bo_allowance_adjustments_show_details', $bo_adjustment_data[$i]->id ."=". $bo_adjustment_data[$i]->principal->principal ."=". $bo_adjustment_data[$i]->particulars) }}" target="_blank">DM - BO {{ $bo_adjustment_data[$i]->id }}</a> 
                                          </td>
                                          <td style="text-align: center;text-transform: uppercase;">
                                            @if($bo_adjustment_data[$i]->invoice_image != '')
                                               <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                              {{ $bo_adjustment_data[$i]->received->dr_si }}
                                              </button>

                                              <!-- Modal -->
                                                <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                      </div>
                                                      <div class="modal-body">
                                                       <img src="{{  asset('/images/'. $bo_adjustment_data[$i]->invoice_image) }}" style="width:100%;">
                                                      </div>
                                                     
                                                    </div>
                                                  </div>
                                                </div>
                                            @else
                                              {{ $bo_adjustment_data[$i]->received->dr_si }}
                                            @endif
                                          </td>
                                          <td style="text-align: center;">{{ $bo_adjustment_data[$i]->date }}</td>
                                          <td style="text-align: right;color:green;font-weight: bold;;">
                                            {{ number_format(0,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;;">
                                            {{ number_format(0,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_total_discount[] = 0;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format($bo_adjustment_data[$i]->bo_allowance_deduction,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = $bo_adjustment_data[$i]->bo_allowance_deduction;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">{{ number_format(0,2,".",",") }}</td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                            {{ number_format($bo_adjustment_data[$i]->vat_deduction*-1,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_vat_deduction[] = $bo_adjustment_data[$i]->vat_deduction;
                                            @endphp
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format(0,2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color: red;font-weight: bold;">
                                            {{ number_format($bo_adjustment_data[$i]->net_deduction*-1,2,".",",")  }}
                                            @php
                                              $sum_received_tab_bo_adjustment_net_deduction[] = $bo_adjustment_data[$i]->net_deduction;
                                            @endphp
                                          </td>

                                        </tr>
                                       @endfor
                                  @else
                                      @php
                                       $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = 0;
                                       $sum_received_tab_bo_adjustment_vat_deduction[] = 0;
                                       $sum_received_tab_bo_adjustment_net_deduction[] = 0;
                                       $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                                       $sum_received_tab_bo_adjustment_total_discount[] = 0;
                                      @endphp
                                  @endif
                                  @if($invoice_counter != 0)
                                       @for ($i=0; $i < $invoice_counter; $i++) 
                                         <tr>
                                          <td style="text-align: center;">
                                             <a href="{{ route('bo_allowance_adjustments_show_details', $invoice_cost_data[$i]->id ."=". $invoice_cost_data[$i]->principal->principal ."=". $invoice_cost_data[$i]->particulars) }}" target="_blank">INVOICE - ADJUSTMENT {{ $invoice_cost_data[$i]->id }}</a> 
                                          </td>
                                          <td style="text-align: center;text-transform: uppercase;">
                                            @if($invoice_cost_data[$i]->invoice_image != '')
                                               <button type="button" class="btn btn-link" data-toggle="modal" style="text-transform: uppercase;" data-target="#exampleModal_received_deliveries_id">
                                              {{ $invoice_cost_data[$i]->received->dr_si }}
                                              </button>

                                              <!-- Modal -->
                                                <div class="modal fade" id="exampleModal_received_deliveries_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel" style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                      </div>
                                                      <div class="modal-body">
                                                       <img src="{{  asset('/images/'. $invoice_cost_data[$i]->invoice_image) }}" style="width:100%;">
                                                      </div>
                                                     
                                                    </div>
                                                  </div>
                                                </div>
                                            @else
                                              {{ $invoice_cost_data[$i]->received->dr_si }}
                                            @endif
                                          </td>
                                          <td style="text-align: center;">{{ $invoice_cost_data[$i]->date }}</td>
                                          <td style="text-align: right;color:green;font-weight: bold;;">
                                            
                                            @php
                                              $received_tab_invoice_cost_adjustment_vatable_purchase = $invoice_cost_data[$i]->vatable_purchase;
                                              $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_vatable_purchase > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase,2,".",",")  }}</span>
                                            @endif
                                             
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_less_discount = $invoice_cost_data[$i]->less_discount;
                                              $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_less_discount > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_less_discount,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_less_discount,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_bo_allowance = $invoice_cost_data[$i]->total_bo_allowance;
                                              $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_bo_allowance > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_net_discount = $invoice_cost_data[$i]->net_discount;
                                              $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_net_discount > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_discount,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_discount,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_vat_amount = $invoice_cost_data[$i]->vat_amount;
                                              $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_vat_amount > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                          <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format(0,2,".",",") }}
                                          </td>
                                          <td style="text-align: right;color: red;font-weight: bold;">
                                            @php
                                              $received_tab_invoice_cost_adjustment_net_adjustment = $invoice_cost_data[$i]->net_adjustment;
                                              $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                                            @endphp
                                            @if($received_tab_invoice_cost_adjustment_net_adjustment > 0)
                                              <span style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment,2,".",",")  }}</span>
                                            @else
                                              <span style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment,2,".",",")  }}</span>
                                            @endif
                                          </td>
                                        </tr>
                                       @endfor
                                  @else
                                        @php
                                          $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                          $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                                        @endphp
                                  @endif
                                  <tr>
                                    <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_vatable_purchase) - array_sum($sum_received_tab_return_vatable_purchase) + - array_sum($sum_received_tab_invoice_cost_adjustment_vatable_purchase) ,2,".",",") 
                                    }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;;">
                                          <button style="font-size:18px;" type="button" class="btn btn-link" data-toggle="modal" data-target="#grand_total">
                                              {{ 
                                                number_format(array_sum($sum_received_tab_total_discount) - array_sum($sum_received_tab_return_total_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_less_discount),2,".",",") 
                                              }}
                                          </button>

                                          <!-- Modal -->
                                          <div class="modal fade " id="grand_total" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg mw-100 w-100" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel"><center>DISCOUNT ALLOCATION</center></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="table table-responsive">
                                                     <table class="table table-bordered" style="font-size:15px">
                                                    <thead>
                                                      <tr>
                                                        <th style="text-align: center;">REF #</th>
                                                        <th style="text-align: center;">DISCOUNT</th>
                                                        <th style="text-align: center;">BO ALLOWANCE</th>
                                                      </tr>
                                                     
                                                    </thead>
                                                    <tbody>
                                                      @for ($i=0; $i < $received_counter; $i++) 
                                                        <tr>
                                                          <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $received_order_data[$i]->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $received_order_data[$i]->id }}</a></td>
                                                              <td style="text-align: right;">
                                                             @php
                                                               if ($received_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount,2,".",",") }} 
                                                          </td>        
                                                          <td style="text-align: right;">
                                                             @php
                                                               if ($received_discount_rate[$i]->bo_allowance == 0.0000) {
                                                                   $bo_allowance = 0;
                                                               }else{
                                                                   $bo_allowance = $received_order_data[$i]->vatable_purchase * ($received_discount_rate[$i]->bo_allowance/100);
                                                               }
                                                              
                                                             @endphp
                                                              {{ number_format($bo_allowance,2,".",",") }} 
                                                           </td>
                                                          
                                                        </tr>
                                                      @endfor 




                                                      @for ($i=0; $i < $return_counter; $i++) 
                                                        <tr>
                                                          <td style="text-align: center;"><a target="_blank" href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id ."=". $return_order_data[$i]->principal->principal) }}">RET - {{ $return_order_data[$i]->id }}</a></td>
                                                          <td style="text-align: right;">
                                                             @php
                                                               if ($return_discount_rate[$i]->discount == 0.0000) {
                                                                   $discount = 0;
                                                               }else{
                                                                   $discount = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->discount/100);
                                                               }
                                                             @endphp
                                                              {{ number_format($discount*-1,2,".",",") }} 
                                                          </td>        
                                                          <td style="text-align: right;">
                                                             @php
                                                               if ($return_discount_rate[$i]->bo_allowance == 0.0000) {
                                                                   $bo_allowance = 0;
                                                               }else{
                                                                   $bo_allowance = $return_order_data[$i]->return_vatable_purchase * ($return_discount_rate[$i]->bo_allowance/100);
                                                               }
                                                              
                                                             @endphp
                                                              {{ number_format($bo_allowance*-1,2,".",",") }} 
                                                           </td>

                                                        </tr>
                                                      @endfor
                                                    </tbody>
                                                  </table>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <a target="_blank" class="btn btn-success" href="{{ route('discount_allocation_all', $date_from ."=". $date_to ."=". $principal_id ."=". $principal_name) }}">PRINT THIS</a>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_bo_allowance) - array_sum($sum_received_tab_return_bo_allowance) + array_sum($sum_received_tab_bo_adjustment_bo_allowance_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_bo_allowance),2,".",",") 
                                    }}
                                    </td>
                                     <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_net_discount) - array_sum($sum_received_tab_return_net_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_net_discount),2,".",",") 
                                    }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_vat_amount) - array_sum($sum_received_tab_return_vat_amount) - array_sum($sum_received_tab_bo_adjustment_vat_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_vat_amount),2,".",",") 
                                    }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">0</td>
                                    <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ 
                                      number_format(array_sum($sum_received_tab_net_of_amount) - array_sum($sum_received_tab_return_net_of_deduction) - array_sum($sum_received_tab_bo_adjustment_net_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_net_adjustment),2,".",",") 
                                    }}
                                    </td>
                                   
                                  </tr>
                                 
                                </tbody>
                              </table>
                    </div>
         @endif
    @endif
    

    <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-6 invoice-col">
        <span style="">
          Prepared By: <br /><br /><br />
          <u style="font-weight: bold;">{{ $prepared_by->name }}</u>
        </span>
        </div>
        <div class="col-sm-6 invoice-col">
          <span style="">
            Approved By: <br /><br /><br />
            <u style="font-weight: bold;">JEFFERSON T. LIMCHU</u><br />
            <p>Group Manager</p>
          </span>
        </div>
      </div>



    
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<script type="text/javascript"> 
    //window.addEventListener("load", window.print());
</script>