 <form id="purchase_order_cart">
     <div class="row">
         <div class="col-md-12">
             <div class="form-group">
                 <label>Sku</label>
                 <select style="width:100%;" class="form-control select2bs4" autofocus required name="sku" id="sku">
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
                 <input style="width:100%;" type="number" name="quantity" required id="quantity"
                     class="form-control next_input_box">
             </div>
         </div>

         <div class="col-md-12">
             <input type="hidden" name="principal_id" value="{{ $principal_id }}">
             <input type="hidden" name="sku_type" value="{{ $sku_type }}">
             <button class="btn float-right btn-sm btn-primary next_input_box" type="submit">Add To
                 Order</button>
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

     //  function submitData() {
     //      var form = document.input_form;
     //      var dataString = $(form).serialize();
     //      $('.loading').show();
     //      $.ajax({
     //          type: 'POST',
     //          url: '/purchase_order_cart',
     //          data: dataString,
     //          success: function(data) {

     //              console.log(data);

     //          }
     //      });
     //      return false;
     //  }

     $("#purchase_order_cart").on('submit', (function(e) {
         e.preventDefault();
         //$('.loading').show();
         $('#hide_if_trigger').hide();
         $.ajax({
             url: "purchase_order_cart",
             type: "POST",
             data: new FormData(this),
             contentType: false,
             cache: false,
             processData: false,
             success: function(data) {
                 //console.log(data);
                 $('#show_data').html(data);
                 $('.loading').hide();
                 $('#quantity').val('');
                 $('#sku').val(null).trigger("change");
                 $('#sku').select2('open');
             },
             error: function(error) {
                 Swal.fire(
                     'Cannot Proceed',
                     'Please Contact IT Support',
                     'error'
                 )
             }
         });
     }));
 </script>
