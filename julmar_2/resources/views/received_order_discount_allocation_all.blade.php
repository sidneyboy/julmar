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
        <span style="font-weight: bold;font-size:18px;">DISCOUNT ALLOCATION: {{ $date_from ." To ". $date_to }}</span><br />
        <span style="font-size:15px;">
      </div>
    </div><br />
    <!-- /.row -->
    
   
        




        @if ($principal_name == 'GCI')
          <table class="table table-bordered" style="font-size:15px;margin-right: 15px;">
                                          <thead>
                                            <tr>
                                              <th>RR No.</th>
                                              <th style="text-align: center;">LOGISCTICS FEE</th>
                                              <th style="text-align: center;">SELLING FREE</th>
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
                                              @if($received_counter != 0)
                                                @for($i=0; $i < $received_counter; $i++) { 
                                                  <tr>
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
                                                  </tr>
                                                @endfor
                                              @endif

                                              @if($return_counter != 0)
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
                                              @endif

                                          {{--   <tr>
                                              <td style="font-weight: bold;">TOTAL</td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_logistics_fee),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_selling_fee),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_cwo_discount),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_sub_total_1),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_vmi_discount),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_per_category_sell_discount),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_sell_discount),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_dops_discount),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_dbs_discount),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_reach),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_sub_total_2),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_shelf_management_discount),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_display_allowance),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_bleach_management_project),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_business_development_fund_discount),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_sub_total_3),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_others),2,".",",") }} </td>
                                              <td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total),2,".",",") }} </td>

                                            </tr> --}}
                                          </tbody>
                                        </table>

                                        <br /><br />
    
      
        @elseif($principal_name == 'PPMC')
          
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