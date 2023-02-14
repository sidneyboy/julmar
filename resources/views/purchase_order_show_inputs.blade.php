 <form id="input_form" class="input_form" method="post" name="input_form">

     <div class="row">
         <div class="col-md-12">
             <div class="panel panel-default">
                 <div class="panel-heading">
                     <center><span style="color:red;display: none;font-style: italic;" id="errorField">ALL FIELDS ARE
                             REQUIRED!! ***</span></center>
                 </div>
             </div>
         </div>
         <div class="col-md-4">
             <div class="form-group">
                 <input style="width:100%;" type="hidden" name="principal_id" id="principal_id"
                     value="{{ $principal_id }}">
                 <label>Delivery Term</label>
                 <input type="text" id="delivery_term" name="delivery_term" class="form-control" required>
             </div>
         </div>
         <div class="col-md-4">
             <div class="form-group">
                 <label>Payment Term</label>
                 <select style="width:100%;" class="form-control" id="payment_term" name="payment_term">
                     <option value="" default>Select Payment Term</option>
                     <option value="COD">CASH ON DELIVERY</option>
                     <option value="30 Days">30 Days</option>
                     <option value="45 Days">45 Days</option>
                     <option value="60 Days">60 Days</option>
                     <option value="90 Days">90 Days</option>
                     <option value="None">None</option>
                 </select>
             </div>
         </div>
         <div class="col-md-4">
             <div class="form-group">
                 <label>Sales Order Number</label>
                 <input type="text" name="sales_order_number" required class="form-control">
             </div>
         </div>
         <div class="col-md-12">
             <div class="form-group">
                 <label>Particular Note:</label>
                 <textarea class="form-control" name="particulars" id="particulars"></textarea>
             </div>
         </div>
         <div class="col-md-12">
             <div class="form-group">
                 <label>Discount</label>
                 <select style="width:100%;" class="form-control" name="discount" id="discount">
                     <option value="" default>Select Discount</option>
                     @foreach ($principal_discount as $discount)
                         <option value="{{ $discount->id }}">
                             {{ 'Discount ' . $discount->total_discount . '% | Bo Allowance' . $discount->total_bo_allowance_discount . '% ' }}
                         </option>
                     @endforeach
                 </select>
             </div>
         </div>
         <div class="col-md-12">
             <div class="form-group">
                 <label>Sku</label>
                 <select style="width:100%;" class="form-control select2bs4" name="sku" id="sku">
                     <option value="" default>Select Item</option>
                     @foreach ($sku_principal as $sku)
                         <option value="{{ $sku->id }}">
                             {{ $sku->sku_code . ' - ' . $sku->sku_type . ' - ' . $sku->description }}</option>
                     @endforeach
                 </select>
             </div>
         </div>
         <div class="col-md-12">
             <div class="form-group">
                 <label>Quantity</label>
                 <input style="width:100%;" type="number" name="quantity" id="quantity"
                     class="form-control next_input_box">
             </div>

         </div>

         <div class="col-md-12">
             <button class="btn float-right btn-sm btn-primary next_input_box" type="submit" name="submit"
                 value="Submit" onclick="return submitData()" style="font-weight: bold;">Add To Order</button>
         </div>
     </div>
 </form>
 <script>
     $(function() {
         $('.select2').select2()

         $('.select2bs4').select2({
             theme: 'bootstrap4'
         })
     });

     function submitData() {
         var form = document.input_form;
         var dataString = $(form).serialize();
         $('.loading').show();
         $.ajax({
             type: 'POST',
             url: '/purchase_order_cart',
             data: dataString,
             success: function(data) {
                 $('#show_data').html(data);
                 $('.loading').hide();
                 $('#quantity').val('');
                 $('#sku').val(null).trigger("change");
                 $('#sku').select2('open');
                 console.log(data);

             }
         });
         return false;
     }
 </script>
