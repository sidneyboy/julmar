<center>
<h4 style="font-weight: bold;">JULMAR COMMERCIAL INC.</h4>
<h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
<h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
</center>
<br />
<h5 style="text-align: center;font-weight: bold;">Van Selling Receipt</h5>
<table class="table table-borderless" style="border:none;"> {{-- class='table table-borderless' --}}
  <thead>
    <tr>
      <th  style="width:20%;line-height:0px"><span class="float-right">Bill To:</span></th>
      <th  style="width:30%;line-height:0px;text-transform: uppercase;">{{ $van_selling->customer->store_name }}</th>
      <th  style="width:20%;line-height:0px"><span class="float-right">Dr Number:</span></th>
      <th  style="width:30%;line-height:0px">{{ $van_selling->delivery_receipt }}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="line-height:0px;"><span class="float-right">Store Code:</span></td>
      <td style="line-height:0px;">{{ $customer_principal_code->store_code }}</td>
      <td style="line-height:0px;"><span class="float-right">DR Date :</span></td>
      <td style="line-height:0px;">{{ $van_selling->date }}</td>
    </tr>
    <tr>
      <td style="line-height:0px;"><span class="float-right">Address:</span></td>
      <td style="line-height:0px;">{{ $van_selling->customer->detailed_location  }}</td>
      <td style="line-height:0px;"><span class="float-right">SO No:</span></td>
      <td style="line-height:0px;">{{ $van_selling->sales_order_number }}</td>
    </tr>
    <tr>
      <td style="line-height:0px;"><span class="float-right">Area:</span></td>
      <td style="line-height:0px;">{{ $van_selling->customer->location->location }}</td>
      <td style="line-height:0px;"><span class="float-right">CUSTOMER PO NO::</span></td>
      <td style="line-height:0px;">N/a</td>
    </tr>
    <tr>
      <td style="line-height:0px;"><span class="float-right">Transaction:</span></td>
      <td style="line-height:0px;">{{ $van_selling->mode_of_transaction }}
      </td>
      {{--    <td style="line-height:0px;"><span class="float-right">Salesman:</span></td>
      <td style="line-height:0px;">{{ $van_selling->agent->full_name }}</td> --}}
    </tr>
    <tr>
      <td style="line-height:0px;"></td>
      <td style="line-height:0px;"></td>
      <td style="line-height:0px;"><span class="float-right">Payment Terms:</span></td>
      <td style="line-height:0px;">{{ $van_selling->customer->credit_term }}</td>
    </tr>
    <tr>
      <td style="line-height:0px;"></td>
      <td style="line-height:0px;"></td>
      <td style="line-height:0px;"><span class="float-right">Due Date:</span></td>
      <td style="line-height:0px;">{{ date('Y-m-d', strtotime($van_selling->date. ' + '. $van_selling->customer->credit_term)) }}</td>
    </tr>
  </tbody>
</table>
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th style="text-align: center;">CODE</th>
      <th style="text-align: center;">DESCRIPTION</th>
      <th style="text-align: center;">UOM</th>
      <th style="text-align: center;">FINAL QUANTITY</th>
      <th style="text-align: center;">PRICE</th>
      <th style="text-align: center;">SUB-TOTAL</th>
    </tr>
  </thead>
  <tbody>
    @foreach($van_selling->van_selling_printed_details as $data)
    <tr>
      <td>{{ $data->sku->sku_code }}</td>
      <td>{{ $data->sku->description }}</td>
      <td>{{ $data->sku->unit_of_measurement }}</td>
      <td style="text-align: right;">{{ $data->quantity }}</td>
      <td style="text-align: right;">{{ number_format($data->price,2,".",",") }}</td>
      <td style="text-align: right;">
        @php
        $sum_sub_total[] = $data->amount_per_sku;
        echo number_format($data->amount_per_sku,2,".",",");
        @endphp
      </td>
    </tr>
    @endforeach
    <tr>
      <td colspan="5" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
      <td style="text-align: right">
        @php
        echo number_format(array_sum($sum_sub_total),2,".",",");
        @endphp
      </td>
    </tr>
  </tbody>
</table>


  <div class="row">
    @if($van_selling->remarks != 'CANCELLED') 
      <div class="col-md-6">
        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#exampleModal">
        PROCEED TO REPRINT
        </button>
      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#exampleModal_cancel_dr">
        CANCEL DR
        </button>
      </div>
    @else
       <button type="button" class="btn btn-danger btn-block" disabled>CANNOT REPRINT! THIS DR HAS BEEN CANCELLED</button>
    @endif
  </div>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">OPERATIONS MANAGER/HEAD AUDIT/SYSTEM ADMIN</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	    <form method="post" action="{{ route('van_selling_reinvoice_print') }}">
  		@csrf
	      <div class="modal-body">
	        <label>OM ACCESS KEY:</label>
	        <input type="password" name="access_key" id="access_key" class="form-control" required>
	        <input type="hidden" name="van_selling_id" value="{{ $van_selling->id }}">
          <input type="hidden" name="customer_id" value="{{ $van_selling->customer_id }}">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" id="submit" class="btn btn-success">Submit</button>
	      </div>
	    </form>
	    </div>
	  </div>
	</div>

  <div class="modal fade" id="exampleModal_cancel_dr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">OPERATIONS MANAGER/HEAD AUDIT/SYSTEM ADMIN</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form id="van_selling_reinvoice_cancel">
      @csrf
        <div class="modal-body">
          <label>ACCESS KEY:</label>
          <input type="password" name="access_key" id="access_key" class="form-control" required>
          <input type="hidden" name="van_selling_id" value="{{ $van_selling->id }}">
          <input type="hidden" name="customer_id" value="{{ $van_selling->customer_id }}">
          <label>REMARKS/REASON:</label>
          <input type="text" name="remarks" id="remarks" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
      </div>
    </div>
  </div>

<script type="text/javascript">
  $("#van_selling_reinvoice_cancel").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_reinvoice_cancel",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            if (data == 'saved') {
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
              })
              location.reload();
            }else{
              Swal.fire(
                'CANNOT PROCEED!',
                'YOU ARE NOT AUTHORIZED!!',
                'error'
              )
            }
          },
        });
    }));
</script>


