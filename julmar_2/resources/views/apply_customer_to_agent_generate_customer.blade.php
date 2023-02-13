<form id="apply_customer_to_agent_save">
	<table class="table table-sm table-bordered">
		<thead>
			<tr>
				<th>
					APPLY CUSTOMERS TO AGENT: <span style="color:blue;">{{ $agent->full_name }}</span>
					<input type="hidden" name="agent_id" value="{{ $agent->id }}">
					<input type="hidden" name="location_id" value="{{ $location }}">
				</th>
			</tr>
		</thead>
	</table>
	<table id="example2" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Location</th>
				<th>Detailed Location</th>
				<th>Store Code</th>
				<th>Store Name</th>
				<th>Kind of Business</th>
				<th><input type="checkbox" class="form-control" id="select_all" style="height: 25px;width: 25px;background-color: #eee"/></th>
			</tr>
		</thead>
		<tbody>
			@foreach($customer as $data)
			<tr>
				<td>{{ $data->location->location }}</td>
				<td>{{ $data->detailed_location }}</td>
				<td>
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $data->id }}">
					  VIEW PER PRINCIPAL
					</button>

					<!-- Modal -->
					<div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">STORE CODE PER PRINCIPAL</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					       <table class="table table-bordered table-hover">
					       	<thead>
					       		<tr>
					       			<th>PRINCIPAL</th>
					       			<th>STORE CODE</th>
					       		</tr>
					       	</thead>
					       	<tbody>
					       		@foreach($data->customer_principal_code as $store_code)
					       			<tr>
					       				<td>{{ $store_code->principal->principal }}</td>
					       				<td>{{ $store_code->store_code }}</td>
					       			</tr>
					       		@endforeach
					       	</tbody>
					       </table>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="button" class="btn btn-primary">Save changes</button>
					      </div>
					    </div>
					  </div>
					</div>
				</td>
				<td>{{ $data->store_name }}</td>
				<td>{{ $data->kind_of_business }}</td>
				<td><input class="checkbox form-control" style="height: 25px;width: 25px;background-color: #eee" type="checkbox" name="customer[]" value="{{ $data->id }}"></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="row">
		<div class="col-md-12">
			<button type="submit" class="btn btn-success btn-block">SUBMIT APPLIED CUSTOMERS TO AGENT SAVED</button>
		</div>
	</div>
</form>

<script type="text/javascript">
	$("#apply_customer_to_agent_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "apply_customer_to_agent_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
          
            if(data == 'saved'){
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Customer Applied to agent. Saved!',
                showConfirmButton: false,
                timer: 1500
              })
              location.reload();
              $('.loading').hide();
            }else{
              Swal.fire(
              'Something went wrong!',
              'Redo process or contact system administrator',
              'error'
              )
              $('.loading').hide();
            }
          },
      });
    }));

	$("#example1").DataTable();
    $('#example2').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": false,
    "autoWidth": true,
    });

    var select_all = document.getElementById("select_all"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) { 
			checkboxes[i].checked = select_all.checked;
		}
	});


	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change 
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
</script>