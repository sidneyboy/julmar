@if ($uom == 'Case')
    <form class="myform" id="myform" name="myform">
      @csrf
      
      @if($count_ledger_counter != 0)
        <label>OUT FROM CASE</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">CODE</th>
                <th style="text-align: center">DESCRIPTION</th>
                <th style="text-align: center">QUANTITY</th>
                <th style="text-align: center">UNIT OF MEASUREMENT</th>
               
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-transform: uppercase;text-align: center">{{ $sku_add->sku_code }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $sku_add->description }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $convert }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $sku_add->unit_of_measurement }}
                  <input type="hidden" name="sku_id" value="{{ $sku_add->id }}">
                  <input type="hidden" name="equivalent_sku_id" value="{{ $sku_add->equivalent_sku_entryNo }}">
                </td>
              </tr>
            </tbody>
          </table>

          <label>IN TO BUTAL</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">CODE</th>
                <th style="text-align: center">DESCRIPTION</th>
                <th style="text-align: center">QUANTITY</th>
                <th style="text-align: center">UNIT OF MEASUREMENT</th>
                
              </tr>
            </thead>
            <tbody>
             
              <tr>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->sku_code }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->description }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->equivalent_butal_pcs * $convert }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->unit_of_measurement }}
                  <input type="hidden" name="equivalent_sku_id" value="{{ $sku_add->equivalent_sku_entryNo }}">
                </td>
              </tr>
             
            </tbody>
          </table>

          <label>COMPUTE FINAL UNIT COST</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">QTY CASE</th>
                <th style="text-align: center">FUC</th>
                <th style="text-align: center">FTC</th>
                <th style="text-align: center">QTY BUTAL</th>
                <th style="text-align: center">FUC</th>
                <th style="text-align: center">FTC</th>
                <!-- <td style="">ACTION</td> -->
                
              </tr>
            </thead>
            <tbody>
              @for ($i = 0; $i < $count_ledger_counter; $i++)
              <tr>
                <td style="text-align: center;">{{ $convert }}</td>
                <td style="text-align: right;">{{ number_format($ledger_results[$i]->final_unit_cost,2,".",",") }}</td>
                <td style="text-align: right;">{{ number_format($convert*$ledger_results[$i]->final_unit_cost,2,".",",") }}</td>
                <td style="text-align: center;">
                  {{ $convert*$equivalents->equivalent_butal_pcs }}
                  @php
                    $last_final_unit_cost_case = $ledger_results[$i]->final_unit_cost;
                  @endphp
                  <input type="hidden" name="transfered_quantity" value="{{ $equivalents->equivalent_butal_pcs * $convert }}">
                  <input type="hidden" name="last_final_unit_cost_case" value="{{ $ledger_results[$i]->final_unit_cost }}">
                </td>
                <td style="text-align: right;">
                  @php
                  $butal_final_unit_cost = $ledger_results[$i]->final_unit_cost / $equivalents->equivalent_butal_pcs;
                  @endphp
                  {{ number_format($butal_final_unit_cost,2,".",",")  }}
                  <input type="hidden" name="last_final_unit_cost_butal" value="{{ $butal_final_unit_cost }}">
                </td>
                <td style="text-align: right;">
                  {{  number_format($butal_final_unit_cost * $equivalents->equivalent_butal_pcs,2,".",",") }}
                </td>
              </tr>
              @endfor
            </tbody>
          </table>

          <label><u>COMPUTE FOR PRICE ONE</u></label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="3">CASE</th>
                <th style="text-align: center;" colspan="3">BUTAL</th>
              </tr>
              <tr>
                <th style="text-align: center;">QTY CASE</th>
                <th style="text-align: center;">P1</th>
                <th style="text-align: center;">TOTAL P1</th>
                <th style="text-align: center;">QTY BUTAL</th>
                <th style="text-align: center;">P1</th>
                <th style="text-align: center;">TOTAL P1</th>
              </tr>
            </thead>
            <tbody>
             
              <tr>
                <td style="text-align: center">{{ $convert }}</td>
                <td style="text-align: right">{{ number_format($sku_price->price_1,2,".",",") }}</td>
                <td style="text-align: right">
                  @php
                  $price_1_case = $convert * $sku_price->price_1
                  @endphp
                  {{ number_format($price_1_case,2,".",",") }}
                </td>
                <td style="text-align: center">
                  @php
                  $total_quantity_butal = $equivalents->equivalent_butal_pcs * $convert
                  @endphp
                  {{ $total_quantity_butal }}
                </td>
                <td style="text-align: right">
                  @php
                  $price_1 = $convert * $sku_price->price_1 / $equivalents->equivalent_butal_pcs * $convert;
                  @endphp
                  {{ number_format($price_1,2,".",",") }}
                  <input type="hidden" name="price_1_butal" value="{{ $price_1 }}">
                </td>
                <td style="text-align: right">
                  @php
                  $total_price_1 = $total_quantity_butal * $price_1;
                  @endphp
                  {{ number_format($total_price_1,2,".",",") }}
                </td>
              </tr>
             
            </tbody>
          </table>

          <label><u>COMPUTE FOR PRICE TWO</u></label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="3">CASE</th>
                <th style="text-align: center;" colspan="3">BUTAL</th>
              </tr>
              <tr>
                <th style="text-align: center;">QTY CASE</th>
                <th style="text-align: center;">P2</th>
                <th style="text-align: center;">TOTAL P2</th>
                <th style="text-align: center;">QTY BUTAL</th>
                <th style="text-align: center;">P2</th>
                <th style="text-align: center;">TOTAL P2</th>
              </tr>
            </thead>
            <tbody>
             
              <tr>
                <td style="text-align: center">{{ $convert }}</td>
                <td style="text-align: right">{{ number_format($sku_price->price_2,2,".",",") }}</td>
                <td style="text-align: right">
                  @php
                  $price_2_case = $convert * $sku_price->price_2
                  @endphp
                  {{ number_format($price_2_case,2,".",",") }}
               
                </td>
                <td style="text-align: center">
                  @php
                  $total_quantity_butal = $equivalents->equivalent_butal_pcs * $convert
                  @endphp
                  {{ $total_quantity_butal }}
                </td>
                <td style="text-align: right">
                  @php
                  $price_2 = $convert * $sku_price->price_2 / $equivalents->equivalent_butal_pcs * $convert;
                  @endphp
                  {{ number_format($price_2,2,".",",") }}
                </td>
                <td style="text-align: right">
                  @php
                  $total_price_2 = $total_quantity_butal * $price_2;
                  @endphp
                  {{ number_format($total_price_2,2,".",",") }}
                  <input type="hidden" name="price_2_butal" value="{{ $price_2 }}">
                </td>
              </tr>
              
            </tbody>
          </table>

          <label><u>COMPUTE FOR PRICE THREE</u></label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="3">CASE</th>
                <th style="text-align: center;" colspan="3">BUTAL</th>
              </tr>
              <tr>
                <th style="text-align: center;">QTY CASE</th>
                <th style="text-align: center;">P2</th>
                <th style="text-align: center;">TOTAL P2</th>
                <th style="text-align: center;">QTY BUTAL</th>
                <th style="text-align: center;">P2</th>
                <th style="text-align: center;">TOTAL P2</th>
              </tr>
            </thead>
            <tbody>
              
              <tr>
                <td style="text-align: center">{{ $convert }}</td>
                <td style="text-align: right">{{ number_format($sku_price->price_3,2,".",",") }}</td>
                <td style="text-align: right">
                   @php
                  $price_3_case = $convert * $sku_price->price_3
                  @endphp
                  {{ number_format($price_3_case,2,".",",") }}
                 
                </td>
                <td style="text-align: center">
                  @php
                  $total_quantity_butal = $equivalents->equivalent_butal_pcs * $convert
                  @endphp
                  {{ $total_quantity_butal }}
                </td>
                <td style="text-align: right">
                  @php
                  $price_3 = $convert * $sku_price->price_3 / $equivalents->equivalent_butal_pcs * $convert;
                  @endphp
                  {{ number_format($price_3,2,".",",") }}
                </td>
                <td style="text-align: right">
                  @php
                  $total_price_3 = $total_quantity_butal * $price_3;
                  @endphp
                  {{ number_format($total_price_3,2,".",",") }}
                  <input type="hidden" name="price_3_butal" value="{{ $price_3 }}">
                </td>
              </tr>
            </tbody>
          </table>

      <input type="hidden" name="fuc_prices" value="{{ $last_final_unit_cost_case ."=". $price_1_case ."=". $price_2_case ."=". $price_3_case }}">
      <button class="float-right btn btn-success btn-flat btn-sm btn-block" type="button" onclick="return saved()" style="font-weight: bold;">BODEGA OUT SAVED</button>
      @else
        <center>
          <h3 style="color:red;font-weight: bold;">INSUFFICIENT QUANTITY</h3>
          <h4 style="color:blue;">NOTE: TRANSFER CASE TO BUTAL FIRST!</h4>
        </center>

      @endif

    </form>






@else








      <form class="myform" id="myform" name="myform">
        @csrf
        
        @if($count_ledger_counter != 0)

          <label>OUT FROM BUTAL</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">CODE</th>
                <th style="text-align: center">DESCRIPTION</th>
                <th style="text-align: center">QUANTITY</th>
                <th style="text-align: center">UNIT OF MEASUREMENT</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-transform: uppercase;text-align: center">{{ $sku_add->sku_code }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $sku_add->description }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $sku_add->equivalent_butal_pcs }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $sku_add->unit_of_measurement }}
                  <input type="hidden" name="sku_id" value="{{ $sku_add->id }}">
                  <input type="hidden" name="equivalent_sku_id" value="{{ $sku_add->equivalent_sku_entryNo }}">
                  <input type="hidden" name="quantity" value="{{ $sku_add->equivalent_butal_pcs }}">
                </td>
              </tr>
            </tbody>
          </table>

          <label>IN TO BUTAL</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">CODE</th>
                <th style="text-align: center">DESCRIPTION</th>
                <th style="text-align: center">QUANTITY</th>
                <th style="text-align: center">UNIT OF MEASUREMENT</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->sku_code }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->description }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $convert }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->unit_of_measurement }}
                  <input type="hidden" name="equivalent_sku_id" value="{{ $sku_add->equivalent_sku_entryNo }}">
                </td>
              </tr>
            </tbody>
          </table>
                    <label>IN TO BUTAL</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="text-align: center">CODE</th>
                <th style="text-align: center">DESCRIPTION</th>
                <th style="text-align: center">QUANTITY</th>
                <th style="text-align: center">UNIT OF MEASUREMENT</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->sku_code }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->description }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $convert }}</td>
                <td style="text-transform: uppercase;text-align: center">{{ $equivalents->unit_of_measurement }}
                  <input type="hidden" name="equivalent_sku_id" value="{{ $sku_add->equivalent_sku_entryNo }}">
                </td>
              </tr>
            </tbody>
          </table>

          <label>COMPUTER FOR FINAL UNIT COST</label>
          <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="text-align: center">QTY BUTAL</th>
                  <th style="text-align: center">FUC</th>
                  <th style="text-align: center">FTC</th>
                  <th style="text-align: center">QTY CASE</th>
                  <th style="text-align: center">FUC</th>
                  <th style="text-align: center">FTC</th>
                  <!-- <td style="">ACTION</td> -->
                  
                </tr>
              </thead>
              <tbody>
                  @for ($i = 0; $i < $count_ledger_counter; $i++)
                    <tr>
                      <td style="text-align: center;">
                        @php
                          $quantity_butal = $convert * $sku_add->equivalent_butal_pcs;
                        @endphp
                        {{ $quantity_butal }}
                      </td>
                      <td style="text-align: right;">
                        @php
                          $last_final_unit_cost_butal = $ledger_results[$i]->final_unit_cost;
                        @endphp
                        {{ number_format($last_final_unit_cost_butal,2,".",",") }}
                        <input type="hidden" name="last_final_unit_cost_butal" value="{{ $last_final_unit_cost_butal }}">
                      </td>
                      <td style="text-align: right;">
                        @php
                          $final_total_cost_butal = $last_final_unit_cost_butal*$quantity_butal;
                        @endphp
                        {{ number_format($final_total_cost_butal,2,".",",") }}
                      </td>
                      <td style="text-align: center;">
                        @php
                          $quantity_case = $convert;
                        @endphp 
                          {{ $convert }}
                      </td>
                      <td style="text-align: right;">
                        @php
                        $final_unit_cost_case =  $final_total_cost_butal / $convert;
                        @endphp
                        {{ number_format($final_unit_cost_case,2,".",",")  }}
                        <input type="hidden" name="last_final_unit_cost_case" value="{{ $final_unit_cost_case }}">
                       
                      </td>
                      <td style="text-align: right;">
                         @php
                        $final_total_cost_case =  $final_unit_cost_case * $quantity_case;
                        @endphp
                        {{ number_format($final_total_cost_case,2,".",",")  }}
                      </td>
                    </tr>
                  @endfor
              </tbody>
          </table>

          <label><u>COMPUTE FOR PRICE ONE</u></label>
          <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="text-align: center;" colspan="3">BUTAL</th>
                  <th style="text-align: center;" colspan="3">CASE</th>
                </tr>
                <tr>
                  <th style="text-align: center;">QTY BUTAL</th>
                  <th style="text-align: center;">P1</th>
                  <th style="text-align: center;">TOTAL P1</th>
                  <th style="text-align: center;">QTY CASE</th>
                  <th style="text-align: center;">P1</th>
                  <th style="text-align: center;">TOTAL P1</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center">
                    @php
                      $quantity_butal = $convert * $sku_add->equivalent_butal_pcs;
                    @endphp
                    {{ $quantity_butal }}
                  </td>
                  <td style="text-align: right">
                    @php
                      $price_1_butal = $sku_price->price_1;
                    @endphp
                    {{ number_format($price_1_butal,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                      $final_total_cost_price_1_butal = $quantity_butal * $price_1_butal;
                    @endphp
                    {{ number_format($final_total_cost_price_1_butal,2,".",",") }}
                  </td>
                  <td style="text-align: center;">
                    @php
                      $quantity_case = $convert;
                    @endphp 
                      {{ $convert }}
                  </td>
                  <td style="text-align: right;">
                    @php
                    $final_unit_cost_price_1_case =  $final_total_cost_price_1_butal / $convert;
                    @endphp
                    {{ number_format($final_unit_cost_price_1_case,2,".",",")  }}
                   {{--  <input type="hidden" name="last_final_unit_cost_price_1_case" value="{{ $case_final_unit_cost }}"> --}}
                  </td>
                  <td style="text-align: right;">
                     @php
                    $final_total_cost_price_1_case =  $final_unit_cost_price_1_case * $quantity_case;
                    @endphp
                    {{ number_format($final_total_cost_price_1_case,2,".",",")  }}
                  </td>
                </tr>
              </tbody>
          </table>

          <label><u>COMPUTE FOR PRICE TWO</u></label>
          <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="text-align: center;" colspan="3">BUTAL</th>
                  <th style="text-align: center;" colspan="3">CASE</th>
                </tr>
                <tr>
                  <th style="text-align: center;">QTY BUTAL</th>
                  <th style="text-align: center;">P2</th>
                  <th style="text-align: center;">TOTAL P2</th>
                  <th style="text-align: center;">QTY CASE</th>
                  <th style="text-align: center;">P2</th>
                  <th style="text-align: center;">TOTAL P2</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center">
                    @php
                      $quantity_butal = $convert * $sku_add->equivalent_butal_pcs;
                    @endphp
                    {{ $quantity_butal }}
                  </td>
                  <td style="text-align: right">
                    @php
                      $price_2_butal = $sku_price->price_2;
                    @endphp
                    {{ number_format($price_2_butal,2,".",",") }}
                  </td>
                  <td style="text-align: right">
                    @php
                      $final_total_cost_price_2_butal = $quantity_butal * $price_2_butal;
                    @endphp
                    {{ number_format($final_total_cost_price_2_butal,2,".",",") }}
                  </td>
                  <td style="text-align: center;">
                    @php
                      $quantity_case = $convert;
                    @endphp 
                      {{ $convert }}
                  </td>
                  <td style="text-align: right;">
                    @php
                    $final_unit_cost_price_2_case =  $final_total_cost_price_2_butal / $convert;
                    @endphp
                    {{ number_format($final_unit_cost_price_2_case,2,".",",")  }}
                   {{--  <input type="hidden" name="last_final_unit_cost_price_2_case" value="{{ $case_final_unit_cost }}"> --}}
                  </td>
                  <td style="text-align: right;">
                     @php
                    $final_total_cost_price_2_case =  $final_unit_cost_price_2_case * $quantity_case;
                    @endphp
                    {{ number_format($final_total_cost_price_2_case,2,".",",")  }}
                  </td>
                </tr>
              </tbody>
          </table>

          <label><u>COMPUTE FOR PRICE THREE</u></label>
          <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="text-align: center;" colspan="3">BUTAL</th>
                  <th style="text-align: center;" colspan="3">CASE</th>
                </tr>
                <tr>
                  <th style="text-align: center;">QTY BUTAL</th>
                  <th style="text-align: center;">P2</th>
                  <th style="text-align: center;">TOTAL P2</th>
                  <th style="text-align: center;">QTY CASE</th>
                  <th style="text-align: center;">P2</th>
                  <th style="text-align: center;">TOTAL P2</th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <td style="text-align: center">
                      @php
                      $quantity_butal = $convert * $sku_add->equivalent_butal_pcs;
                      @endphp
                      {{ $quantity_butal }}
                    </td>
                    <td style="text-align: right">
                      @php
                       $price_3_butal = $sku_price->price_3;
                      @endphp
                      {{ number_format($price_3_butal,2,".",",") }}
                     
                    </td>
                    <td style="text-align: right">
                      @php
                      $final_total_cost_price_3_butal = $quantity_butal * $price_3_butal;
                      @endphp
                      {{ number_format($final_total_cost_price_3_butal,2,".",",") }}
                    </td>
                    <td style="text-align: center;">
                      @php
                      $quantity_case = $convert;
                      @endphp
                      {{ $convert }}
                    </td>
                    <td style="text-align: right;">
                      @php
                      $final_unit_cost_price_3_case =  $final_total_cost_price_3_butal / $convert;
                      @endphp
                      {{ number_format($final_unit_cost_price_3_case,2,".",",")  }}
                      {{--  <input type="hidden" name="last_final_unit_cost_price_3_case" value="{{ $case_final_unit_cost }}"> --}}
                    </td>
                    <td style="text-align: right;">
                      @php
                      $final_total_cost_price_3_case =  $final_unit_cost_price_3_case * $quantity_case;
                      @endphp
                      {{ number_format($final_total_cost_price_3_case,2,".",",")  }}
                    </td>
                  </tr>
              </tbody>
          </table>
  
          <input type="hidden" name="fuc_prices" value="{{ $last_final_unit_cost_butal ."=". $price_1_butal ."=". $price_2_butal ."=". $price_3_butal }}">

          <button class="float-right btn btn-success btn-flat btn-sm btn-block" type="button" onclick="return saved()" style="font-weight: bold;">BODEGA OUT SAVED</button>
        @else
          <center>
            <h3 style="color:red;font-weight: bold">INSUFFICIENT QUANTITY!</h3>
            <h4 style="color:blue;">NOTE: TRANSFER CASE TO BUTAL FIRST!</h4>
          </center>
        @endif


      </form>



@endif



<script>
  function saved() {
    var form = document.myform;
    var dataString = $(form).serialize();
     //$('.loading').show();
      $.ajax({
        type:'POST',
        url:'/bodega_out_saved',
        data: dataString,
        success: function(data){

          if(data == 'Saved'){
                toastr.success('BODEGA OUT DATA SUCCESSFULLY SAVED!');
                $('.loading').show();
                setTimeout(function(){
              location.reload();
            }, 2000);
                
          }else{
                toastr.error('Something went wrong, please redo process');
          }

        }
      });
    return false;
  }
</script>