<form id="van_selling_pcm_generate_final_summary">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>PCM Type: <span style="color:blue;text-transform: uppercase;">{{ $pcm_type }}</span></label>
                <input type="hidden" name="pcm_type" value="{{ $pcm_type }}" required class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Remitted By:</label>
                <input type="text" class="form-control" required name="remitted_by">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>PCM #:</label>
                <input type="text" name="pcm_number" required class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Store Name:</label>
                <input type="text" class="form-control" required name="store_name">
            </div>
        </div>
    </div>
    <div class="table table-responsive">
        @if ($pcm_type != 'customer')
            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($van_selling_pcm_data as $data)
                        <tr>
                            <td>{{ $data->attributes->sku_code }}</td>
                            <td>{{ $data->name }}</td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                            <td style="text-align: right">
                                <input type="text" class="form-control" style="text-align: right"
                                    onkeypress="return isNumberKey(event)" required name="price[{{ $data->id }}]"
                                    value="{{ $data->price }}">
                            </td>
                            <td>{{ $data->attributes->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($van_selling_pcm_data as $data)
                        <tr>
                            <td>{{ $data->attributes->sku_code }}</td>
                            <td>{{ $data->name }}</td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                            <td><input id="price" style="text-align: right" onkeypress="return isNumberKey(event)"
                                    type="text" name="price[{{ $data->id }}]"
                                    class="form-control form-control-sm"></td>
                            <td>{{ $data->attributes->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <input type="hidden" value="{{ $customer_id }}" name="customer_id">
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <button type="submit" class="btn btn-info btn-sm float-right">Final Summary</button>

</form>

<script>
    $("#van_selling_pcm_generate_final_summary").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "van_selling_pcm_generate_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 'existing_pcm_number') {
                    $('#loader').hide();
                    Swal.fire(
                        'Existing Pcm Number!!',
                        'Cannot Proceed!',
                        'error'
                    )
                } else {
                    $('#loader').hide();
                    $('#van_selling_pcm_generate_final_summary_page').html(data);
                }
            },
            error: function(error) {
                $('#loader').hide();
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
