
	<table class="table table-bordered table-hover" id="example2">
		<thead>
			<tr>
				<td>EXPORT CODE</td>
				<td>AGEMT</td>
				<td>CUSTOMER</td>
				<td>PRINCIPAL</td>
				<td>DELIVERY RECEIPT</td>
				<td>DATE</td>
				<td>RGS STATUS</td>
				<td>BO STATUS</td>
				<td>RETURNED BY</td>
				<td>VIEW DETAILS</td>
			</tr>
		</thead>
		<tbody>
			@foreach($pcm_upload as $data)
			<tr>
				<td>{{ $data->bo_rgs_export_code }}</td>
				<td>{{ $data->agent->full_name }}</td>
				<td>{{ $data->customer->store_name }}</td>
				<td>{{ $data->principal->principal }}</td>
				<td>
					<button type="button" class="btn btn-info btn-block pcm_id" value="{{ $data->id }}">{{ $data->delivery_receipt }}</button>
				</td>
				<td>{{ $data->date }}</td>
				<td>{{ $data->rgs_status }}</td>
				<td>{{ $data->bo_status }}</td>
				<td style="text-transform: uppercase;">{{ $data->returned_by }}</td>
				<td>VIEW DETAILS</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="hidden" id="employee_name" value="{{ $employee_name }}">
<script type="text/javascript">


  
  $(".pcm_id" ).click(function() {
     var pcm_id = $(this).val();
     var employee_name = $('#employee_name').val(); 
     $('.loading').show();       
      $.post({
      type: "POST",
      url: "/pcm_upload_report_generate_details",
      data: 'pcm_id=' + pcm_id + '&employee_name=' + employee_name,
      success: function(data){

      //console.log(data);
	      $('.loading').hide();  
	      $('#pcm_upload_report_generate_details_page').html(data);

      },
      error: function(error){
        console.log(error);
      }
    });
  });

	$("#example1").DataTable();
    $('#example2').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    });
</script>
