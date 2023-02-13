@if ($search_for == 'search_per_principal')
    <div class="row">
        <div class="col-md-12">
            <label>SELECT PRINCIPAL:</label>
            <select class="form-control select2" name="principal" style="width:100%;" required>
                <option value="" default>SELECT PRINCIPAL</option>
                <option value="all_principal">ALL PRINCIPAL</option>
                @foreach ($principal as $data)
                    <option value="{{ $data->principal }}">{{ $data->principal }}</option>
                @endforeach
            </select>
        </div>
    </div>
@elseif($search_for == 'search_per_account')
    <div class="row">
        <div class="col-md-6">
            <label>SELECT ACCOUNT:</label>
            <select class="form-control select2" name="account" style="width:100%;" required>
                <option value="" default>SELECT ACCOUNT</option>
                @foreach ($van_selling_upload_ledger as $data)
                    <option value="{{ $data->store_name }}">{{ $data->store_name }}</option>
                @endforeach
            </select>
        </div>
		<div class="col-md-6">
			<label>SELECT PRINCIPAL:</label>
			<select class="form-control select2" name="principal" style="width:100%;" required>
				<option value="" default>SELECT PRINCIPAL</option>
				<option value="all_principal">ALL PRINCIPAL</option>
				@foreach ($principal as $data)
					<option value="{{ $data->principal }}">{{ $data->principal }}</option>
				@endforeach
			</select>
		</div>
    </div>
	
@else
<div class="row">
	<div class="col-md-6">
		<label>SELECT LOCATION:</label>
		<select class="form-control select2" name="location" style="width:100%;" required>
			<option value="" default>SELECT LOCATION</option>
			@foreach ($location as $data)
				<option value="{{ $data->location }}">{{ $data->location }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-6">
		<label>SELECT PRINCIPAL:</label>
		<select class="form-control select2" name="principal" style="width:100%;" required>
			<option value="" default>SELECT PRINCIPAL</option>
			<option value="all_principal">ALL PRINCIPAL</option>
			@foreach ($principal as $data)
				<option value="{{ $data->principal }}">{{ $data->principal }}</option>
			@endforeach
		</select>
	</div>
</div>
@endif

<script type="text/javascript">
    $('.select2').select2()
</script>
