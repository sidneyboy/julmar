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
    <div class="row">
      <div class="col-12">
        <center>
           <h2 class="page-header">
            <img src="{{ asset('/adminLte/julmar.png') }}" style="width:50px;" alt=""> JULMAR COMMERCIAL. INC,
           </h2>
        </center>
      </div>
      <!-- /.col -->
    </div><br />
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col">
        <center>
        <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
        <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
        </center>
        <br />
        <center>
        <span style="font-weight: bold;font-size:18px;">BO ALLOWANCE ADJUSTMENTS #: {{ $id }} ({{ $principal_name }}) </span><br />
        <span style="font-size:15px;">
      </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
     
        <div class="table table-responsive">
           <table class="table table-bordered table-hover">
             <thead>
              <tr>
                <th colspan="8">Note: {{ $particulars }}</th>
              </tr>
               <tr>
                <th style="text-align: center;">Code</th>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">UOM</th>
                <th style="text-align: center;">Quantity Received</th>
                <th style="text-align: center;">Unit Cost</th>
                <th style="text-align: center;">Adjusted Unit Cost</th>
                <th style="text-align: center;">Adjustment</th>
                <th style="text-align: center;">Amount</th>
               </tr>
             </thead>
             <tbody>
               @foreach ($bo_adjustments_details as $data)
                 <tr>
                   <td style="text-transform: uppercase;text-align: center">{{ $data->sku->sku_code }}</td>
                   <td style="text-transform: uppercase;text-align: center">{{ $data->sku->description }}</td>
                   <td style="text-transform: uppercase;text-align: center">{{ $data->sku->unit_of_measurement }}</td>
                   <td style="text-align: center;">{{ $data->quantity }}</td>
                   <td style="text-align: right;">{{ number_format($data->unit_cost,2,".",",") }}</td>
                   <td style="text-align: right;">{{ number_format($data->adjusted_amount,2,".",",") }}</td>
                   <td style="text-align: right;">
                    @php
                      $amount = $data->unit_cost - $data->adjusted_amount;
                    @endphp
                    {{ number_format($amount,2,".",",") }}
                  </td>
                   <td style="text-align: right;">
                      @php
                        $total_amount = $data->quantity * $amount;
                        $sum_total_amount[] = $total_amount;
                      @endphp
                      {{ number_format($total_amount,2,".",",") }}
                   </td>
                 </tr>
               @endforeach
                 <tr>
                   <td colspan="7" style="font-weight: bold;text-align: center">GRAND TOTAL</td>
                   <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_total_amount),2,".",",") }}</td>
                 </tr>
             </tbody>
           </table>
           <table class="table table-bordered table-hover">
              <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY OF DEDUCTION:</td>
                <td></td>
              </tr>
              <tr>
                <td style="font-weight: bold;">BO ALLOWANCE</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                  
                   {{ number_format($bo_total_adjusted_amount->bo_allowance_deduction,2,".",",") }}
              
                </td>
              </tr>
              <tr>
                <td>VAT DEDUCTION</td>
                <td style="text-align: right;font-size: 15px;">
                  
                   {{ number_format($bo_total_adjusted_amount->vat_deduction,2,".",",") }}

                 
                </td>
              </tr>
              <tr>
                <td style="font-weight: bold;">NET DEDUCTION</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                 
                   {{ number_format($bo_total_adjusted_amount->net_deduction,2,".",",") }} 
                  
                  
                </td>
              </tr>
            </table>
           <table class="table table-bordered table-hovered">
              <thead>
                <tr>
                  <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                  <th style="text-align: center;">DR</th>
                  <th style="text-align: center;">CR</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center;">ACCOUNTS PAYABLE - {{ $principal_name }}</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;">{{ number_format($bo_total_adjusted_amount->net_deduction,2,".",",")  }}</td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td style="text-align: center;">INVENTORY - {{ $principal_name }}</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;">{{ number_format($bo_total_adjusted_amount->net_deduction,2,".",",") }}</td>
                </tr>
              </tbody>
            </table>
        </div>
      
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <br /><br />
    
      <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-6 invoice-col">
        <span style="text-align: center;">
          Purchased By: <br />
          <u style="font-weight: bold;"></u>
        </span>
        </div>
        <div class="col-sm-6 invoice-col">
          <span style="text-align: center;">
            Prepared By:<br />
            <u style="font-weight: bold;"> {{ $prepared_by->name }}</u>
          </span>
        </div>
      </div>
      <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-12 invoice-col">
        <span style="text-align: center;">
          Date: <br />
          <u style="font-weight: bold;">
            {{ $date }}
          </u>
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