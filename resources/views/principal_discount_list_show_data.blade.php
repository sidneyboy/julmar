@if($principal_name == 'GCI')

	<div class="table table-responsive">
		<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th style="text-align: center;">ID #</th>	
				<th style="text-align: center;">PRINCIPAL</th>
				<th style="text-align: center;">LOGISTICS FEE</th>
				<th style="text-align: center;">SELLING FEE</th>
				<th style="text-align: center;">CWO DISCOUNT</th>
				<th style="text-align: center;">BO ALLOWANCE</th>
				<th style="text-align: center;">VMI DISCOUNT</th>
				<th style="text-align: center;">PCSD</th>
				<th style="text-align: center;">TSD</th>
				<th style="text-align: center;">DOPS DISCOUNT</th>
				<th style="text-align: center;">DBS DISCOUNT</th>
				<th style="text-align: center;">REACH</th>
				<th style="text-align: center;">SMD</th>
				<th style="text-align: center;">DISPLAY ALLOWANCE</th>
				<th style="text-align: center;">BMP</th>
				<th style="text-align: center;">BDFD</th>
				<th style="text-align: center;">OTHERS</th>
				
			</tr>
		</thead>
		<tbody>
			@foreach ($principal_discounts as $data)
				<tr>
					<td style="text-align: center">{{ $data->id}}</td>
					<td style="text-align: center">{{ $principal_name}}</td>
					<td style="text-align: center">{{ $data->logistics_fee  ."%"}}</td>
					<td style="text-align: center">{{ $data->selling_fee  ."%"}}</td>
					<td style="text-align: center">{{ $data->cwo_discount  ."%"}}</td>
					<td style="text-align: center">{{ $data->bo_discount  ."%"}}</td>
					<td style="text-align: center">{{ $data->vmi_discount  ."%"}}</td>
					<td style="text-align: center">{{ $data->per_category_sell_discount  ."%"}}</td>
					<td style="text-align: center">{{ $data->total_sell_discount  ."%"}}</td>
					<td style="text-align: center">{{ $data->dops_discount  ."%"}}</td>
					<td style="text-align: center">{{ $data->dbs_discount  ."%"}}</td>
					<td style="text-align: center">{{ $data->reach  ."%"}}</td>
					<td style="text-align: center">{{ $data->shelf_management_discount  ."%"}}</td>
					<td style="text-align: center">{{ $data->display_allowance  ."%"}}</td>
					<td style="text-align: center">{{ $data->bleach_management_project  ."%"}}</td>
					<td style="text-align: center">{{ $data->business_development_fund_discount  ."%"}}</td>
					<td style="text-align: center">{{ $data->others  ."%"}}</td>

				</tr>
			@endforeach
		</tbody>
	</table>
	</div>

@elseif($principal_name == 'CIFPI')
	
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center;">ID #</th>
					<th style="text-align: center;">CATEGORY</th>
					<th style="text-align: center;">DISCOUNT 1</th>
					<th style="text-align: center;">DISCOUNT 2</th>
					<th style="text-align: center;">DISCOUNT 3</th>
					<th style="text-align: center;">DISCOUNT 4</th>
					<th style="text-align: center;">DISCOUNT 5</th>
					<th style="text-align: center;">DISCOUNT 6</th>
					<th style="text-align: center;">BO ALLOWANCE</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($principal_discounts as $data)
					<tr>
						<td style="text-align: center">{{ $data->id }}</td>
						<td style="text-align: center">{{ $data->category->category }}</td>
						<td style="text-align: center">{{ $data->discount1 ."%"}}</td>
						<td style="text-align: center">{{ $data->discount2 ."%"}}</td>
						<td style="text-align: center">{{ $data->discount3 ."%"}}</td>
						<td style="text-align: center">{{ $data->discount4 ."%"}}</td>
						<td style="text-align: center">{{ $data->discount5 ."%"}}</td>
						<td style="text-align: center">{{ $data->discount6 ."%"}}</td>
						<td style="text-align: center">{{ $data->bo_allowance ."%"}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@elseif($principal_name == 'PPMC')
	
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center;">ID #</th>
					<th style="text-align: center;">CATEGORY</th>
					<th style="text-align: center;">TRADE D-1</th>
					<th style="text-align: center;">TRADE D-2</th>
					<th style="text-align: center;">BO ALLOWANCE</th>
					<th style="text-align: center;">DSTE INC</th>
					<th style="text-align: center;">DIZER ALLOWANCE</th>
					<th style="text-align: center;">OPTIMIX</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($principal_discounts as $data)
					<tr>
						<td style="text-align: center">{{ $data->id }}</td>
						<td style="text-align: center">{{ $data->category->category }}</td>
						<td style="text-align: center">{{ $data->trade_discount_1 ."%"}}</td>
						<td style="text-align: center">{{ $data->trade_discount_2 ."%"}}</td>
						<td style="text-align: center">{{ $data->bo_allowance ."%"}}</td>
						<td style="text-align: center">{{ $data->dste_inc ."%"}}</td>
						<td style="text-align: center">{{ $data->dizer_allowance ."%"}}</td>
						<td style="text-align: center">{{ $data->optimix ."%"}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@elseif($principal_name == 'PFC')
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center">ID #</th>
					<th style="text-align: center">DISCOUNT</th>
					<th style="text-align: center">BO ALLOWANCE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($principal_discounts as $data)
				 <tr>
					<td style="text-align: center">{{ $data->id }}</td>
				 	<td style="text-align: center">{{ number_format($data->discount,2,".",",") ."%" }}</td>
				 	<td style="text-align: center">{{ number_format($data->bo_allowance,2,".",",") ."%" }}</td>
				 </tr>
				@endforeach
			</tbody>
		</table>
	</div>
@elseif($principal_name == 'EPI')
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center">ID #</th>
					<th style="text-align: center">DISCOUNT</th>
					<th style="text-align: center">BO ALLOWANCE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($principal_discounts as $data)
				 <tr>
				 	<td style="text-align: center">{{ $data->id }}</td>
				 	<td style="text-align: center">{{ number_format($data->discount,2,".",",") ."%" }}</td>
				 	<td style="text-align: center">{{ number_format($data->bo_allowance,2,".",",") ."%" }}</td>
				 </tr>
				@endforeach
			</tbody>
		</table>
	</div>
@elseif($principal_name == 'DOLE')
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center">ID #</th>
					<th style="text-align: center">DISCOUNT</th>
					<th style="text-align: center">BO ALLOWANCE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($principal_discounts as $data)
				 <tr>
				 	<td style="text-align: center">{{ $data->id }}</td>
				 	<td style="text-align: center">{{ number_format($data->discount,2,".",",") ."%" }}</td>
				 	<td style="text-align: center">{{ number_format($data->bo_allowance,2,".",",") ."%" }}</td>
				 </tr>
				@endforeach
			</tbody>
		</table>
	</div>
@elseif($principal_name == 'ALASKA')
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center">ID #</th>
					<th style="text-align: center">DISCOUNT</th>
					<th style="text-align: center">BO ALLOWANCE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($principal_discounts as $data)
				 <tr>
				 	<td style="text-align: center">{{ $data->id }}</td>
				 	<td style="text-align: center">{{ number_format($data->discount,2,".",",") ."%" }}</td>
				 	<td style="text-align: center">{{ number_format($data->bo_allowance,2,".",",") ."%" }}</td>
				 </tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endif

