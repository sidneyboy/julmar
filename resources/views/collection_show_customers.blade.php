 <label for="">Customer</label>
 <select name="customer_id" class="form-control select2bs4" style="width:100%;" required>
    <option value="" default>Select Agent Customer</option>
     @foreach ($customer as $data)
         <option value="{{ $data->customer_id }}">{{ $data->customer->store_name }}</option>
     @endforeach
 </select>

 <script>
     $('.select2bs4').select2({
         theme: 'bootstrap4'
     })
 </script>
