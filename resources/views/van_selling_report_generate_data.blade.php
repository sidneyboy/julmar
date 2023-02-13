<form id="van_selling_report_generate_clearing">
	<div class="table table-responsive" id="printableArea">
		<table class="table table-bordered table-hover" id="example2">
			<thead>
				<tr>
					<th>PRINCIPAL</th>
					<th>CODE</th>
					<th>DESCRIPTION</th>
					<th>REFERENCE</th>
					<th>BUTAL EQUIVALENT</th>
					<th>QTY CASE</th>
					<th>SKU TYPE</th>
					<th>T - VAN LOAD</th>
					<th>T - SALES</th>
					<th>INVENTORY ADJUSTMENTS</th>
					<th>ENCODER ADJUSTMENTS</th>
					<th>PCM</th>
					<th>END</th>
					<th>U/P</th>
					<th>RUNNING BALANCE</th>
				</tr>
			</thead>
			<tbody>
				@for ($i=0; $i < count($van_selling_ledger); $i++)
				<tr>
					<td style="text-align: center;">{{ $van_selling_ledger[$i]->principal }}</td>
					<td style="text-align: center;">
						<button class="btn btn-block btn-info itemized" value="{{ $van_selling_ledger[$i]->sku_code .",". $van_selling_ledger[$i]->customer_id }}" >{{ $van_selling_ledger[$i]->sku_code }}</button>
					</td>
					<td style="text-align: center;">{{ $van_selling_ledger[$i]->description }}</td>
					<td style="text-align: center;">{{ $van_selling_ledger[$i]->reference }}</td>
					{{-- @if($van_selling_ledger[$i]->sku_code == $sku_code_array[$i])
					<td style="text-align: right">
						{{ $butal_equivalent_array[$i] }}
					</td>
					<td style="text-align: right">
						@if($butal_equivalent_array[$i] == '0')
						NO BUTAL EQUIVALENT
						@else
						{{ number_format(($van_selling_ledger[$i]->beg + $van_selling_ledger[$i]->total_van_load - $van_selling_ledger[$i]->total_sales) / $butal_equivalent_array[$i],2,".",",") }}
						@endif
					</td>
					@endif --}}
					<td style="text-align: right">
						{{ $butal_equivalent_array[$i] }}
					</td>
					<td style="text-align: right">
						@if($butal_equivalent_array[$i] == '0')
						NO BUTAL EQUIVALENT
						@else
						{{ number_format(($van_selling_ledger[$i]->beg + $van_selling_ledger[$i]->total_van_load - $van_selling_ledger[$i]->total_sales) / $butal_equivalent_array[$i],2,".",",") }}
						@endif
					</td>
					<td>BUTAL</td>
					{{-- <td style="text-align: right">{{ $van_selling_ledger[$i]->total_beg }}</td> --}}
					<td style="text-align: right">{{ $van_selling_ledger[$i]->total_van_load }}</td>
					<td style="text-align: right">{{ $van_selling_ledger[$i]->total_sales }}</td>
					<td style="text-align: right">{{ $van_selling_ledger[$i]->total_inventory_adjustments }}</td>
					<td style="text-align: right">
						@if($van_selling_ledger[$i]->total_adjustments < 0)
						@php
						$explode = explode('-', $van_selling_ledger[$i]->total_adjustments);
						$adjusted_quantity = $explode[1];
						$adjustments = $adjusted_quantity;
						echo "(". $adjustments .")";
						@endphp
						@else
						@php
						$adjustments = $van_selling_ledger[$i]->total_adjustments;
						echo $adjustments;
						@endphp
						@endif
					</td>
					<td>
						{{ $van_selling_ledger[$i]->total_pcm }}
					</td>
					<td style="text-align: right">
						@php
						echo $ending_balance = $van_selling_ledger[$i]->beg + $van_selling_ledger[$i]->total_van_load - $van_selling_ledger[$i]->total_sales + $adjustments - $van_selling_ledger[$i]->total_pcm + $van_selling_ledger[$i]->total_inventory_adjustments + $van_selling_ledger[$i]->total_clearing ;
						@endphp
					</td>
					@if($van_selling_ledger[$i]->sku_code == $sku_code_array[$i])
					<td style="text-align: right">
						{{ $unit_price_array[$i] }}
					</td>
					<td style="text-align: right">
						@php
						// $running_balance = $running_balance_array[$i];
						$running_balance = $ending_balance * $unit_price_array[$i];
						$sum_running_balance[] = $running_balance;
						echo $running_balance;
						@endphp
					</td>
					@endif
				</tr>
				@endfor
			</tbody>
			<tfoot>
			<tr>
				<th style="text-align: center;font-weight: bold;">GRAND TOTAL</th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th colspan="" rowspan="" headers="" scope=""></th>
				<th style="text-align: right">
					{{ array_sum($sum_running_balance) }}
					<input type="hidden" name="running_balance_amount" value="{{ array_sum($sum_running_balance) }}">
					<input type="hidden" name="customer_id" value="{{ $customer_id }}">
					{{-- <input type="hidden" name="date_from" value="{{ $date_from }}">
					<input type="hidden" name="date_to" value="{{ $date_to }}"> --}}
					<input type="hidden" name="store_name" value="{{ $customer->store_name }}">
				</th>
			</tr>
			</tfoot>
		</table>
	</div>
	<div class="row">
		<div class="col-md-6">
			<input type="button" class="btn btn-success btn-block" onclick="printDiv('printableArea')" value="PRINT TABLE" />
		</div>
		<div class="col-md-6">
			<button type="button" class="btn btn-info btn-block" onclick="exportTableToCSV('{{ $customer->store_name }}.csv')">EXPORT TABLE TO EXCEL</button>
		</div>
		<div class="col-md-12">
			<label>&nbsp;</label>
			<button type="submit" class="btn btn-block btn-warning">CLEAR DATA</button>
		</div>
	</div>
</form>

<script type="text/javascript">
	$(".itemized").on('click',(function(e){
       e.preventDefault();
       $('.loading').show();
       var itemized = $(this).val();
         $.ajax({
           url: "van_selling_report_itemized",
           type: "POST",
           data:  'itemized=' + itemized,
           success: function(data){
             console.log(data);
              $('.loading').hide();
              $('#van_selling_report_itemized_page').show();
              $('#van_selling_report_itemized_page').html(data);
           },
         });
   	}));

	function printDiv(divName) {
	     var printContents = document.getElementById(divName).innerHTML;
	     var originalContents = document.body.innerHTML;

	     document.body.innerHTML = printContents;

	     window.print();

	     document.body.innerHTML = originalContents;
	}

	$("#example1").DataTable();
    $('#example2').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
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

	function exportTableToCSV(filename) {
	    var csv = [];
	    var rows = document.querySelectorAll("#printableArea tr");
	    
	    for (var i = 0; i < rows.length; i++) {
	        var row = [], cols = rows[i].querySelectorAll("td, th");
	        
	        for (var j = 0; j < cols.length; j++) 
	            row.push(cols[j].innerText);
	        
	        csv.push(row.join(","));        
	    }

	    // Download CSV file
	    downloadCSV(csv.join("\n"), filename);
	}

    $("#van_selling_report_generate_clearing").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_report_generate_clearing",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
          	$('.loading').hide();
          	$('#van_selling_report_itemized_page').show();
            $('#van_selling_report_itemized_page').html(data);
          },
        });
    }));



</script>