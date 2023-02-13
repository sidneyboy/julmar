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
        <span style="font-weight: bold;font-size:18px;">INVOICE COST ADJUSTMENTS #: {{ $invoice_cost_adjustment_id }} ({{ $principal_name }}) </span><br />
        <span style="font-size:15px;">
        </div>
      </div>
      <!-- /.row -->
      <!-- Table row -->
      <div class="row">
        
        <div class="table table-responsive">
        @if($principal_name == 'CIFPI' OR $principal_name == 'PPMC')

        @else
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th style="text-align: center">Code</th>
                <th style="text-align: center">Description</th>
                <th style="text-align: center">UOM</th>
                <th style="text-align: center">Quantity Received</th>
                <th style="text-align: center">Unit<br />Cost<br />Adjustment</th>
                <th style="text-align: center">Sub-Total<br />Amount</th>
                <th style="text-align: center">Vatable<br />Purchase</th>
                <th style="text-align: center">Discount</th>
                <th style="text-align: center">Bo<br />Allowance</th>
                <th style="text-align: center">Vat<br >Amount</th>
                <th style="text-align: center">Net Adjustment</th>
              </tr>
            </thead>
            <tbody>
              @for ($i = 0; $i < $count; $i++)
                <tr>
                  <td style="text-align: center;text-transform: uppercase;">{{ $invoice_cost_adjustment_details[$i]->sku->sku_code }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $invoice_cost_adjustment_details[$i]->sku->description }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $invoice_cost_adjustment_details[$i]->sku->unit_of_measurement }}</td>
                <td style="text-align: center;text-transform: uppercase;">{{ $invoice_cost_adjustment_details[$i]->quantity }}</td>
                <td style="text-align: right">{{ number_format($invoice_cost_adjustment_details[$i]->adjustments,2,".",",") }}</td>
                <td style="text-align: right">
                  @php
                  $total_amount = $invoice_cost_adjustment_details[$i]->quantity * $invoice_cost_adjustment_details[$i]->adjustments;
                  $sum_total_amount[] = $total_amount;
                  @endphp
                  {{ number_format($total_amount,2,".",",") }}
                </td>
                <td style="text-align: right">
                  @php
                  $vatable_purchase = $total_amount/1.12;
                  $sum_vatable_purchase[] = $vatable_purchase;
                  @endphp
                  {{ number_format($vatable_purchase,2,".",",") }}
                </td>
                <td style="text-align: right">
                  @php
                  $discount = $vatable_purchase * $principal_discount->total_discount/100;
                  $sum_discount[] = $discount;
                  @endphp
                  {{ number_format($discount,2,".",",") }}
                </td>
                <td style="text-align: right">
                  @php
                  $bo_allowance = $vatable_purchase * $principal_discount->total_bo_allowance_discount/100;
                  $sum_bo_allowance[] = $bo_allowance;
                  @endphp
                  {{ number_format($bo_allowance,2,".",",") }}
                </td>
                <td style="text-align: right">
                  @php
                  $vat_amount = ($vatable_purchase - $discount - $bo_allowance)*.12;
                  $sum_vat_amount[] = $vat_amount;
                  @endphp
                  {{ number_format($vat_amount,2,".",",") }}
                </td>
                <td style="text-align: right">
                  @php
                  $total_adjusted_amount = $vatable_purchase - $discount - $bo_allowance + $vat_amount;
                  $sum_total_adjusted_amount[] = $total_adjusted_amount;
                  @endphp
                  {{ number_format($total_adjusted_amount,2,".",",") }}
                </td>
                </tr>
              @endfor
                <tr>
                  <td colspan="5" style="font-weight: bold;text-align: center">GRAND TOTAL</td>
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_total_amount),2,".",",") }}</td>
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_vat_amount),2,".",",") }}</td>
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_discount),2,".",",") }}</td>
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_bo_allowance),2,".",",") }}</td>
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_vat_amount),2,".",",") }}</td>
                  <td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_total_adjusted_amount),2,".",",") }}</td>
                </tr>
            </tbody>
          </table>
          <table class="table table-bordered table-hover">
            <tr>
              <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY OF DEDUCTION:</td>
              <td></td>
            </tr>
            <tr>
              <td style="font-weight: bold; text-align: left;width:50%;">VATABLE PURCHASE:</td>
              <td style="font-weight: bold; text-align: right;font-size: 15px;">
                
                @php
                $total_vatable_purchase = array_sum($sum_total_amount)/1.12;
                @endphp
                {{   number_format($total_vatable_purchase,2,".",",")  }}
                <input type="hidden" name="total_vatable_purchase" value={{ $total_vatable_purchase }}>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;width:50%;">LESS: DISCOUNTS</td>
              <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                @php
                $total_less_discount = array_sum($sum_discount) + array_sum($sum_bo_allowance);
                @endphp
                {{   number_format($total_less_discount,2,".",",")  }}
                <input type="hidden" name="total_less_discount" value={{ $total_less_discount }}>
              </td>
            </tr>
            <tr>
              <td style="font-weight: bold;">NET OF DISCOUNTS</td>
              <td style="font-weight: bold; text-align: right;font-size: 15px;">
                @php
                $total_net_discount = $total_vatable_purchase - $total_less_discount;
                @endphp
                {{   number_format($total_net_discount,2,".",",")  }}
                <input type="hidden" name="total_net_discount" value={{ $total_net_discount }}>
              </td>
            </tr>
            <tr>
              <td>VAT AMOUNT</td>
              <td style="text-align: right;font-size: 15px;">
                @php
                $total_vat_amount = $total_net_discount * .12;
                @endphp
                {{   number_format($total_vat_amount,2,".",",")  }}
                <input type="hidden" name="total_vat_amount" value={{ $total_vat_amount }}>
              </td>
            </tr>
            <tr>
              <td style="font-weight: bold;">NET ADJUSTMENT</td>
              <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                @php
                $total_net_adjustment = $total_net_discount + $total_vat_amount;
                @endphp
                {{   number_format($total_net_adjustment,2,".",",")  }}
                <input type="hidden" name="total_net_adjustment" value={{ $total_net_adjustment }}>
              </td>
            </tr>
          </table>

          @if ($total_net_adjustment < 0)
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
                  <td style="text-align: center;">ACCOUNTS PAYABLE {{ $principal_name }}</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;">{{ number_format($total_net_adjustment*-1, 2, '.', ',') }}</td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td style="text-align: center;">INVENTORY - {{ $principal_name }}</td>
                  <td>
                  </td>
                  <td style="font-weight: bold;text-align: center;">{{ number_format($total_net_adjustment*-1, 2, '.', ',') }}
                    
                  </td>
                </tr>
              </tbody>
            </table>
          @else
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
                  <td style="text-align: center;">INVENTORY {{ $principal_name }}</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_net_adjustment, 2, '.', ','); ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td style="text-align: center;">ACCOUNTS PAYABLE - {{ $principal_name }}</td>
                  <td></td>
                  <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_net_adjustment, 2, '.', ','); ?>
                    
                  </td>
                </tr>
              </tbody>
            </table>
          @endif
          
        @endif
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