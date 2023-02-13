<form id="apply_customer_to_agent_save">
	<table class="table table-sm table-bordered">
		<thead>
			<tr>
				<th>
					APPLIED CUSTOMERS TO AGENT: <span style="color:blue;">{{ $applied_customer_to_agent[0]->agent->full_name }}</span>
					
				</th>
			</tr>
		</thead>
	</table>
	<table id="example2" class="table table-bordered table-hover" >
		<thead>
			<tr>
				<th>Location</th>
				<th>Detailed Location</th>
				<th>Store Code</th>
				<th>Store Name</th>
				<th>Kind of Business</th>
				<th>Option</th>
			</tr>
		</thead>
		<tbody>
			@foreach($applied_customer_to_agent as $data)
			<tr>
				<td>{{ $data->customer->location->location }}</td>
				<td>{{ $data->customer->detailed_location }}</td>
				<td>
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal{{ $data->id }}">
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
					        		@foreach($data->customer->customer_principal_code as $store_code)
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
				<td>{{ $data->customer->store_name }}</td>
				<td>{{ $data->customer->kind_of_business }}</td>
				<td><button type="button" class="btn btn-danger btn-block remove_sku" value='Edit' id="{{ $data->id }}"><i class="fas fa-trash-alt"></i></button></td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<table id="export_customer_agent" style="display: none;">
		<thead>
			<tr>
				<th>{{ $agent }}</th>
				<th>export_customer_applied_to_agent</th>
				<th>{{ $date ."". $time }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($applied_customer_to_agent as $data)
			<tr>
				<td>{{ $data->customer->id }}</td>
				<td>{{ $data->customer->location->id }}</td>
				<td>{{ $data->customer->credit_line_amount }}</td>
				<td>{{ $data->customer->store_name }}</td>
				<td>{{ $data->customer->kind_of_business }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<table id="export_customer_price_per_principal" style="display: none;">
		<thead>
			<tr>
				<th>{{ $agent }}</th>
				<th>export_customer_price_per_principal</th>
				<th>{{ $date ."". $time }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($applied_customer_to_agent as $key => $data) 
	          @foreach($data->customer->customer_principal_price as $price_data)
	          	<tr>
	          		<td>{{ $price_data->customer_id }}</td>
	          		<td>{{ $price_data->principal_id }}</td>
	          		<td>{{ $price_data->price_level }}</td>
	          	</tr>
	          @endforeach
	        @endforeach
		</tbody>
	</table>

	<table id="export_customer_principal_code" style="display: none;">
		<thead>
			<tr>
				<th>{{ $agent }}</th>
				<th>export_customer_principal_code</th>
				<th>{{ $date ."". $time }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($applied_customer_to_agent as $data)
				@foreach($data->customer->customer_principal_code as $store)
					<tr>
						<td>{{ $store->customer_id }}</td>
						<td>{{ $store->principal_id }}</td>
						<td>{{ $store->store_code }}</td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>

	<div class="row">
		<div class="col-md-4">
			<button class="btn btn-success btn-flat btn-sm btn-block" style="font-weight: bold;" onclick="event.preventDefault(); export_customer_applied_to_agent('{{ $applied_customer_to_agent[0]->agent->full_name .'-CUSTOMER APPLIED TO AGENT-'. $date ."". $time }}.csv')">EXPORT CUSTOMER APPLIED TO AGENT</button>
		</div>
		<div class="col-md-4">
			<button class="btn btn-info btn-flat btn-sm btn-block" style="font-weight: bold;" onclick="event.preventDefault(); export_customer_principal_code('{{ $applied_customer_to_agent[0]->agent->full_name .'-CUSTOMER CODE PER PRINCIPAL-'. $date ."". $time }}.csv')">EXPORT CUSTOMER CODE PER PRINCIPAL</button>
		</div>
		<div class="col-md-4">
			<button class="btn btn-warning btn-flat btn-sm btn-block" style="font-weight: bold;" onclick="event.preventDefault(); export_customer_price_per_principal('{{ $applied_customer_to_agent[0]->agent->full_name .'-CUSTOMER PRICE PER PRINCIPAL-'. $date ."". $time }}.csv')">EXPORT CUSTOMER PRICE PER PRINCIPAL</button>
		</div>
	</div>
	
</form>

<script type="text/javascript">
	

	$("#example1").DataTable();
    $('#example2').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": false,
    "autoWidth": true,
    });

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
                    url: "apply_customer_to_agent_report_remove",
                    type: "GET",
                    data:  'id=' + id,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                    
                       if(data == 'deleted'){
                        $('.loading').hide();
                        $("#trigger").click();
                        Swal.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success'
                        )
                       }else if(data == 'error'){
                        $('.loading').hide();
                          Swal.fire(
                            'Error!',
                            'Something went wrong, call admin',
                            'Error'
                          )
                       }
                   },
                });
              }
            })
        });
     });

   function downloadCSV(csv, filename) {
	    var csvFile;
	    var downloadLink;

	    // CSV file
	    csvFile = new Blob([csv], {type: "text/csv"});

	    // Download link
	    downloadLink = document.createElement("a");

	    // File name
	    downloadLink.download = filename;

	    // Create a link to the file
	    downloadLink.href = window.URL.createObjectURL(csvFile);

	    // Hide download link
	    downloadLink.style.display = "none";

	    // Add the link to DOM
	    document.body.appendChild(downloadLink);

	    // Click download link
	    downloadLink.click();
	}

	
	function export_customer_principal_code(filename) {
		$('.loading').show();		    
		var csv = [];
		var rows = document.querySelectorAll("#export_customer_principal_code tr");
		for (var i = 0; i < rows.length; i++) {
			var row = [], cols = rows[i].querySelectorAll("td, th");
			for (var j = 0; j < cols.length; j++)
					row.push(cols[j].innerText);
					csv.push(row.join(","));
			}
		downloadCSV(csv.join("\n"), filename);
		$('.loading').hide();		
	}

	function export_customer_applied_to_agent(filename) {
		$('.loading').show();	

		var csv = [];
		var rows = document.querySelectorAll("#export_customer_agent tr");
		for (var i = 0; i < rows.length; i++) {
			var row = [], cols = rows[i].querySelectorAll("td, th");
			for (var j = 0; j < cols.length; j++)
					row.push(cols[j].innerText);
					csv.push(row.join(","));
			}
		downloadCSV(csv.join("\n"), filename);
		$('.loading').hide();	


	}

	function export_customer_price_per_principal(filename) {
		$('.loading').show();	

		var csv = [];
		var rows = document.querySelectorAll("#export_customer_price_per_principal tr");
		for (var i = 0; i < rows.length; i++) {
			var row = [], cols = rows[i].querySelectorAll("td, th");
			for (var j = 0; j < cols.length; j++)
					row.push(cols[j].innerText);
					csv.push(row.join(","));
			}
		downloadCSV(csv.join("\n"), filename);
		$('.loading').hide();	


	}
</script>