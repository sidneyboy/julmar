
<div class="table table-responsive">
  <form id="proceed_to_final_summary" enctype="multipart/form-data" method="post">
    @csrf
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="text-align: center;">
          <span style="text-transform: uppercase;">{{ $select_store_data->store_name }}</span>
          <input type="hidden" name="store_name" value="{{ $select_store_data->store_name }}">
          <input type="hidden" name="customer_id" value="{{ $select_store_data->id }}">
          <input type="hidden" name="store_code" value="{{ $select_store_data->store_code }}">
          <input type="hidden" name="store_location" value="{{ $select_store_data->location->location }}">
          <input type="hidden" name="detailed_location" value="{{ $select_store_data->detailed_location }}">
          <input type="hidden" name="sales_order_number" value="{{ $sales_order_number }}">
          <input type="hidden" name="salesman" value="{{ $salesman }}">
          <input type="hidden" name="sales_order_id" value="{{ $sales_order_id }}">
          <input type="hidden" name="principal_id" value="{{ $select_sales_order_details_holder[0]->sku->principal_id }}">
          <input type="hidden" name="credit_term" value="{{ $select_store_data->credit_term }}">
          <input type="hidden" name="price_level" value="{{ $price_level }}">
           <input type="hidden" name="agent_id" value="{{ $agent_id }}">
        </th>
        <th style="text-align:center;">{{ $price_level }}</th>
        <th style="text-align: center;">
          MOT: {{ $select_stores_and_method->method }}
          <input type="hidden" name="method" value="{{ $select_stores_and_method->method }}">
        </th>
        <th colspan="3" style="text-align: center;">
          CL BALANCE:
          @php
          $customer_ledger_result = DB::select(DB::raw("SELECT * FROM (SELECT * FROM customer_ledgers WHERE customer_id = '$select_store_data->id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
          echo  number_format($customer_ledger_result[0]->credit_line_balance,2,".",",");
          @endphp
          <input type="hidden" name="credit_line_balance" value="{{ $customer_ledger_result[0]->credit_line_balance }}">
          <input type="hidden" name="credit_line_amount" value="{{ $customer_ledger_result[0]->credit_line_amount }}">
          <input type="hidden" name="accounts_receivable" value="{{ $customer_ledger_result[0]->accounts_receivable_end }}">
        </th>
        <th colspan="5" style="text-align: center;">
          {{ $delivery_receipt }}
          <input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
        </th>
      </tr>
      <tr>
        <th style="text-align: center;">Code</th>
        <th style="text-align: center;">Description</th>
        <th style="text-align: center;">QO</th>
        <th style="text-align: center;">QOH</th>
        <th style="text-align: center;">ADJ</th>
        
        <th style="text-align: center;">Price</th>
        <th style="text-align: center;">CD<br />Rate 1</th>
        <th style="text-align: center;">CD<br />Rate 2</th>
        <th style="text-align: center;">CD<br />Rate 3</th>
        <th style="text-align: center;">CD<br />Rate 4</th>
        <th style="text-align: center;">Option</th>
      </tr>
    </thead>
    <tbody>
      @foreach($select_sales_order_details_holder as $data)
      <tr>
        <td style="text-align: center;">
          <input type="hidden" name="sku_id[]" value="{{ $data->sku_id }}">
          <input type="hidden" name="sku_code[]" value=" {{ $data->sku->sku_code }}">
          <input type="hidden" name="category_id[{{ $data->sku_id }}]" value=" {{ $data->sku->category_id }}">
          <input type="hidden" name="sku_type[{{ $data->sku_id }}]" value=" {{ $data->sku->sku_type }}">
          {{ $data->sku->sku_code }}
        </td>
        <td style="text-align: center;">
          {{ $data->sku->description }}
          <input type="hidden" name="description[{{ $data->sku->sku_code }}]" value="{{ $data->sku->description }}">
        </td>
        <td style="text-align: center;">
          <input type="hidden" name="quantity[{{ $data->sku->sku_code }}]" value="{{ $data->quantity }}">
          {{ $data->quantity }}
        </td>
        <td style="text-align: center;">
          @php
          $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data->sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
          echo $ledger_results[0]->running_balance;
          @endphp
          <input type="hidden" name="final_unit_cost_from_ledger[{{ $data->sku_id }}]" value="{{ $ledger_results[0]->final_unit_cost }}">
        </td>
        <td>
          @if($ledger_results[0]->running_balance == 0)
          <input style="text-align: center;color:red;" type="number" value="{{ 0 }}" class="form-control" name="final_ordered_quantity[{{ $data->sku->sku_code }}]" required>
          @elseif($ledger_results[0]->running_balance < $data->quantity)
          <input style="text-align: center;color:red;" type="number" value="{{ $ledger_results[0]->running_balance }}" class="form-control" name="final_ordered_quantity[{{ $data->sku->sku_code }}]" required>
          @else
          <input style="text-align: center;color:red;" type="number" value="{{ $data->quantity }}" class="form-control" name="final_ordered_quantity[{{ $data->sku->sku_code }}]" required>
          @endif
        </td>
        <td style="text-align: center;">
          <input type="hidden" value="{{ $data->price }}" class="form-control" name="price[{{ $data->sku->sku_code }}]" required>
          {{ number_format($data->price,2,".",",") }}
        </td>
        <td><input type="text" name="cd_rate_1[{{ $data->sku->sku_code }}]" class="currency-default" value="0" style="display: block;
          width: 100%;
          height: calc(2.25rem + 2px);
          padding: .375rem .75rem;
          font-size: 1rem;
          font-weight: 400;
          line-height: 1.5;
          color: #495057;
          background-color: #fff;
          background-clip: padding-box;
          border: 1px solid #ced4da;
          border-radius: .25rem;
          box-shadow: inset 0 0 0 transparent;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;width:100px;"></td>
        <td><input type="text" name="cd_rate_2[{{ $data->sku->sku_code }}]" class="currency-default" value="0" style="display: block;
          width: 100%;
          height: calc(2.25rem + 2px);
          padding: .375rem .75rem;
          font-size: 1rem;
          font-weight: 400;
          line-height: 1.5;
          color: #495057;
          background-color: #fff;
          background-clip: padding-box;
          border: 1px solid #ced4da;
          border-radius: .25rem;
          box-shadow: inset 0 0 0 transparent;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;width:100px;"></td>
        <td><input type="text" name="cd_rate_3[{{ $data->sku->sku_code }}]" class="currency-default" value="0" style="display: block;
          width: 100%;
          height: calc(2.25rem + 2px);
          padding: .375rem .75rem;
          font-size: 1rem;
          font-weight: 400;
          line-height: 1.5;
          color: #495057;
          background-color: #fff;
          background-clip: padding-box;
          border: 1px solid #ced4da;
          border-radius: .25rem;
          box-shadow: inset 0 0 0 transparent;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;width:100px;"></td>
        <td><input type="text" name="cd_rate_4[{{ $data->sku->sku_code }}]" class="currency-default" value="0" style="display: block;
          width: 100%;
          height: calc(2.25rem + 2px);
          padding: .375rem .75rem;
          font-size: 1rem;
          font-weight: 400;
          line-height: 1.5;
          color: #495057;
          background-color: #fff;
          background-clip: padding-box;
          border: 1px solid #ced4da;
          border-radius: .25rem;
          box-shadow: inset 0 0 0 transparent;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;width:100px;"></td>
        <td><button type="button" class="btn btn-danger remove_sku" value='Edit' id="{{ $select_sales_order_details_holder[0]->id .",". $select_sales_order_details_holder[0]->sku->principal_id  .",". $sales_order_number .",". $principal_name .",". $sku_type .",".  $salesman .",". $sales_order_id .",". $agent_id }}"><i class="fas fa-trash-alt"></i></button></td>
      </tr>
      @endforeach
      <tr>
        <td colspan="11">
          <label>Customer discount</label>
          <select class="select2" name="customer_discount[]" multiple="multiple" data-placeholder="Customer Discounts" style="width: 100%;">
            @foreach($select_customer_discount as $discount_data)
            <option selected value="{{ $discount_data->customer_discount }}">{{ $discount_data->customer_discount }}</option>
            @endforeach
          </select>
        </td>
      </tr>
    </tbody>
  </table>
  <button type="submit" class="btn btn-success btn-block">PROCEED TO FINAL SUMMARY</button>
</form>
</div>

<script type="text/javascript">

   $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });


      $('.select2').select2()
      //Initialize Select2 Elements
      $('.select2bs4').select2({
      theme: 'bootstrap4'
      })

    $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});


    $('.remove_sku').each(function() {
        $(this).click(function(){
            var id = $(this).attr('id');

            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {

                 $.ajax({
            url: "sales_order_upload_remove_sku",
            type: "GET",
            data:  'id=' + id,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              
              console.log(data);
           

              if(data == 'no data found'){
                let timerInterval
                Swal.fire({
                  title: 'No more data found',
                  html: 'Refreshing page in <b></b> milliseconds.',
                  timer: 2000,
                  timerProgressBar: true,
                  willOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                      const content = Swal.getContent()
                      if (content) {
                        const b = content.querySelector('b')
                        if (b) {
                          b.textContent = Swal.getTimerLeft()
                        }
                      }
                    }, 100)
                  },
                  onClose: () => {
                    clearInterval(timerInterval)
                  }
                }).then((result) => {
                  /* Read more about handling dismissals below */
                  if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                    $('.loading').hide();
                    location.reload();
                  }
                })
                
              }else{
                $('.loading').hide();

                $('#sales_order_migrate_summary_page').html(data);
                
                Swal.fire(
                  'Deleted!',
                  'Sku Deleted',
                  'success'
                )
              }
            },
          });









            
              }
            })















         
        });
     });


    $("#proceed_to_final_summary").on('submit',(function(e){
        e.preventDefault();
        $('.loading').show();
          $('#sales_order_migrate_final_summary_page').show();
          $.ajax({
            url: "sales_order_upload_final_summary",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              $('.loading').hide();
              console.log(data);
               $('#sales_order_migrate_final_summary_page').html(data);
            },
          });
      }));
</script>