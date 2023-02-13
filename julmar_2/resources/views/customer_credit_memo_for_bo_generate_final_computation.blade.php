<table class="table table-bordered table-hover table-sm" >
	<thead>
		<tr>
			<th>PERSONNEL(s) INVOLVED:</th>
			<th style="text-transform: uppercase;">{{ $personnels_involved }}</th>
		</tr>
		<tr>
			
			<th>INVOLVED IN:</th>
			<th style="text-transform: uppercase;">{{ $involved_in }}</th>
		</tr>
		<tr>
			
			<th>AMOUNT:</th>
			<th>{{ number_format($amount_involved,2,".",",") }}</th>
		</tr>
		<tr>
			<th>NET CM AMOUNT</th>
			<th>{{ number_format($net_cm,2,".",",") }}</th>
		</tr>
	</thead>
</table>
