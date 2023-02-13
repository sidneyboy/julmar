@extends('layouts.master')
@section('title', 'Customer Profile')
@section('navbar')
@section('sidebar')
@section('content')

<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">CUSTOMER PROFILE</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="card-body">
      <form id="customer_profile_search" method="post">
        @csrf
        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label>Search Store Name:</label>
                <select class="form-control select2" required name="customer_id" style="width:100%;">
                  <option value="" default>SELECT</option>
                  @foreach($customer as $data)
                    <option value="{{ $data->id }}">{{ $data->store_name ." - ". $data->location->location }}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label>Principal</label>
                <select class="form-control select2" style="width:100%;" name="principal" required>
                  <option value="" default>Select Principal</option>
                  @foreach($principal as $principal_data)
                    @if($principal_data->principal == 'None')
                      <option value="{{ 'All' }}">{{ 'All' }}</option>
                    @else
                      <option value="{{ $principal_data->id }}">{{ $principal_data->principal }}</option>
                    @endif
                  @endforeach
                </select>
              </div>        
          </div>
          <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block" id="trigger">PROCEED TO SEARCH</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="customer_profile_show_customer_page"></div>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('footer')
@parent
<script>
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$("#customer_profile_search").on('submit',(function(e){
      e.preventDefault();
       $('.loading').show();
        $.ajax({
          url: "customer_profile_search",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
             

             if (data == 'store_name_not_found') {
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Store not found!!',
                showConfirmButton: false,
                timer: 1500
              })
               $('.loading').hide();
             }else{
              $('#customer_profile_show_customer_page').html(data);
               $('.loading').hide();
             }
          },
    });
  }));
</script>
</body>
</html>
@endsection