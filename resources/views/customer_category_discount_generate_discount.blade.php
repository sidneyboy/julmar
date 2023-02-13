<form id="customer_category_discount_save_form" method="post">
@csrf
<input type="hidden" name="customer_id" value="{{ $customer_id }}">
<input type="hidden" name="principal_id" value="{{ $principal_id }}">
<input type="hidden" name="category_id" value="{{ $category_id }}">

<div class="row">
	@if($number_of_discounts == 1)
			@for ($i=0; $i < $number_of_discounts; $i++)
				<div class="col-md-6">
					<label>Discount Rate</label>
					<input type="text" name="discount_rate[]" class="currency-default" style="display: block;
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
					transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
				</div>
			@endfor
				<div class="col-md-6">
					<label>&nbsp;</label>
					<button class="btn btn-success btn-block">Save</button>
				</div>
	@elseif($number_of_discounts == 2)
			@for ($i=0; $i < $number_of_discounts; $i++)
				<div class="col-md-6">
					<label>Discount Rate</label>
					<input type="text" name="discount_rate[]" class="currency-default" style="display: block;
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
					transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
				</div>
			@endfor
				<div class="col-md-12">
					<label>&nbsp;</label>
					<button class="btn btn-success btn-block">Save</button>
				</div>
	@elseif($number_of_discounts == 3)
			@for ($i=0; $i < $number_of_discounts; $i++)
				<div class="col-md-4">
					<label>Discount Rate</label>
					<input type="text" name="discount_rate[]" class="currency-default" style="display: block;
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
					transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
				</div>
			@endfor
				<div class="col-md-12">
					<label>&nbsp;</label>
					<button class="btn btn-success btn-block">Save</button>
				</div>
	@else
		@for ($i=0; $i < $number_of_discounts; $i++)
			<div class="col-md-3">
				<label>Discount Rate</label>
				<input type="text" name="discount_rate[]" required class="currency-default" style="display: block;
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
				transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
			</div>
		@endfor
			<div class="col-md-12">
				<label>&nbsp;</label>
				<button class="btn btn-success btn-block">Save</button>
			</div>
	@endif
</div>
</form>
<script type="text/javascript">
	$('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});



  $("#customer_category_discount_save_form").on('submit',(function(e){
        e.preventDefault();
        //$('.loading').show();
          $.ajax({
            url: "customer_category_discount_save",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              console.log(data);
    //             if(data != 'error'){
    //              Swal.fire({
				//   position: 'top-end',
				//   icon: 'success',
				//   title: 'Your work has been saved',
				//   showConfirmButton: false,
				//   timer: 1500
				// })
    //              $('#customer_discount_save')[0].reset();
				//  $('#principal').select2('val',0);
				//  $('#store').select2('val',0);
				//  $('#number_of_discounts').select2('val',0);
				//  $('#customer_discount_show_input_page').hide();
				 
    //              $('.loading').hide();
                  
    //             }else{
    //               Swal.fire(
    //               'Something went wrong!',
    //               'Redo process or contact system administrator',
    //               'error'
    //               )
    //               $('.loading').hide();
    //             }
            },
      });
    }));


</script>