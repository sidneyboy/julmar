@extends('layouts.master')
@section('title', 'VS Report')
@section('navbar')
@section('sidebar')
@section('content')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLING REPORT</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_pcm_report_generate_data">
        <div class="row">
          <div class="col-md-6">
            <label>Salesman:</label>
            <select class="form-control select2bs4" name="location_id" id="location_id" required style="width:100%;">
              <option value="" default>SELECT AGENT</option>
              @foreach($customer as $data)
              <option value="{{ $data->id }}">{{ $data->store_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label>Date Range:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="reservation" name="date_range" required>
                </div>
          </div>
          <div class="col-md-12">
            <div id="van_selling_report_show_input_page"></div>
          </div>
          <div class="col-md-12">
            <br />
            <button type="submit" id="generate" class="btn btn-success btn-sm float-right">Generate</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
    
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">REPORT DATA</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div id="van_selling_pcm_report_generate_data_page"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div class="row">
        <div class="col-md-12">
          <div id="van_selling_report_itemized_page"></div>
        </div>
      </div>
    </div>
    <!-- /.card-footer-->
  </div>



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

  //  $(function() {
  //   $('input[name="date_range"]').daterangepicker({
  //     opens: 'left'
  //   }, function(start, end, label) {

  //      var date_range = $('#reservation').val();
  //      var location_id = $('#location_id').val();
    
  //       $.ajax({
  //         url: "van_selling_report_show_input",
  //         type: "POST",
  //         data:  'date_range=' + date_range + '&location_id=' + location_id,
  //         success: function(data){
  //           console.log(data);
            
  //            if (data == 'error_input') {
              
  //            let timerInterval
  //             Swal.fire({
  //               title: 'LOCATION FIELD NEEDED',
  //               html: 'RELOADING PAGE!',
  //               timer: 2000,
  //               timerProgressBar: true,
  //               didOpen: () => {
  //                 Swal.showLoading()
  //                 timerInterval = setInterval(() => {
  //                   const content = Swal.getContent()
  //                   if (content) {
  //                     const b = content.querySelector('b')
  //                     if (b) {
  //                       b.textContent = Swal.getTimerLeft()
  //                     }
  //                   }
  //                 }, 100)
  //               },
  //               willClose: () => {
  //                 clearInterval(timerInterval)
  //               }
  //             }).then((result) => {
  //               /* Read more about handling dismissals below */
  //               if (result.dismiss === Swal.DismissReason.timer) {
  //                 console.log('I was closed by the timer')
  //                   location.reload();
  //               }
  //             })
  //            }else{
  //             $('#van_selling_report_show_input_page').html(data);
  //             $('#generate').show();
  //            }

  //         },
  //       });
  //   });
  // });
 


  

  $("#van_selling_pcm_report_generate_data").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_pcm_report_generate_data",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             if (data == 'no_data_found') {
              Swal.fire(
                'NO DATA FOUND!',
                'CANNOT PROCEED!',
                'error'
              )
              $('.loading').hide();
             }else{
              $('#van_selling_pcm_report_generate_data_page').html(data);
              $('#van_selling_report_itemized_page').hide();
              $('.loading').hide();
             }
            
          },
        });
    }));
</script>
</body>
</html>
@endsection