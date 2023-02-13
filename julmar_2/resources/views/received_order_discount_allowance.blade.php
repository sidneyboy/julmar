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
        <span style="font-weight: bold;font-size:18px;">DISCOUNT ALLOCATION: </span><br />
        <span style="font-size:15px;">
      </div>
    </div><br />
    <!-- /.row -->
    
    <div class="row invoice-info" style="width:80%;margin-left:25%;margin-right:25%;">
      <div class="col-sm-6 invoice-col">
        
        
         <table>
            <tr>
              <td style="font-weight: bold;">RR No. <span class="float-right">:</span></td>
              <td> {{ $id }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">RR Date. <span class="float-right">:</span></td>
              <td> {{ $date }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Po No. <span class="float-right">:</span></td>
              <td> {{ $received_data->purchase_order->purchase_id }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Po Date <span class="float-right">:</span></td>
              <td> 
                {{  $received_data->purchase_order->date }}
              </td>
            </tr>
          </table>

      </div>
      <!-- /.col -->
     
      <!-- /.col -->
      <div class="col-sm-6 invoice-col">
          <table>
            <tr>
              <td style="font-weight: bold;">Principal <span class="float-right">:</span></td>
              <td> {{ $principal_name }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Principal Invoice No. <span class="float-right">:</span></td>
              <td> {{ $received_data->dr_si }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Invoice Date <span class="float-right">:</span></td>
              <td> {{ $received_data->invoice_date }}</td>
            </tr>
            <tr>
              <td style="font-weight: bold;">Delivery Status. <span class="float-right">:</span></td>
              <td> 
                @if ($received_data->purchase_order->remarks == 'Received')
                   {{ 'COMPLETE' }}
                 @else
                   {{ 'PARTIAL' }}
                 @endif
              </td>
            </tr>
          </table>
      </div>
      <!-- /.col -->
    </div><br /><br />
    




        @if ($principal_name == 'GCI')
          <table class="table table-bordered" style="font-size:15px;margin-right: 15px;">
                                          <thead>
                                            <tr>
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
                                            
                                               <tr>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $logistics_fee = $logistics_fee;
                                                   @endphp
                                                    {{ number_format($logistics_fee,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $selling_fee = $selling_fee;
                                                   @endphp
                                                    {{ number_format($selling_fee,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $cwo_discount = $cwo_discount;
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
                                                     $vmi_discount = $vmi_discount;
                                                   @endphp
                                                    {{ number_format($vmi_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $per_category_sell_discount = $per_category_sell_discount;
                                                   @endphp
                                                    {{ number_format($per_category_sell_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $total_sell_discount = $total_sell_discount;
                                                   @endphp
                                                    {{ number_format($total_sell_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $dops_discount = $dops_discount;
                                                   @endphp
                                                    {{ number_format($dops_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $dbs_discount = $dbs_discount;
                                                   @endphp
                                                    {{ number_format($dbs_discount,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $reach = $reach;
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
                                                     $shelf_management_discount = $shelf_management_discount;
                                                   @endphp
                                                    {{ number_format($shelf_management_discount,2,".",",") }} 
                                                 </td>
                                                  <td style="text-align: right;">
                                                   @php
                                                     $display_allowance = $display_allowance;
                                                   @endphp
                                                    {{ number_format($display_allowance,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $bleach_management_project = $bleach_management_project;
                                                   @endphp
                                                    {{ number_format($bleach_management_project,2,".",",") }} 
                                                 </td>
                                                 <td style="text-align: right;">
                                                   @php
                                                     $business_development_fund_discount = $business_development_fund_discount;
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
                                                     $others = $others;
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
                                            
                                          </tbody>
                                        </table>

                                        <br /><br />
    
      <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-6 invoice-col">
        <span style="">
          Prepared By: <br /><br /><br />
          <u style="font-weight: bold;">{{ $prepared_by }}</u>
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
        @elseif($principal_name == 'PPMC')
          
        @endif






    
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<script type="text/javascript"> 
     window.addEventListener("load", window.print());
</script>