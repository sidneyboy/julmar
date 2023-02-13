<form id="van_selling_pcm_generate_final_summary">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Associated Salesman: <span
                        style="color:blue;text-transform: uppercase;">{{ $pcm_type }}</span></label>
                <input type="hidden" name="pcm_type" value="{{ $pcm_type }}" required class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Associated Salesman:</label>
                <input type="text" value="{{ $salesman_name }}" required class="form-control">
                <input type="hidden" name="agent_name" value="{{ $salesman_name }}" required class="form-control">
                <input type="hidden" name="agent_id" value="{{ $salesman_id }}" required class="form-control">

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Remitted By:</label>
                <input type="text" class="form-control" required name="remitted_by">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>PCM #:</label>
                <input type="text" name="pcm_number" required class="form-control">
            </div>
        </div>
        <div class="col-md-3">
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
                        <th>Principal</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                      {{--   <th>Sub-Total</th> --}}
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($van_selling_pcm_data as $data)
                        <tr>
                            <td>{{ $data->attributes->principal }}</td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name }}</td>
                            <td style="text-align: right">{{ $data->quantity }}</td>
                           {{--  <td style="text-align: right">{{ number_format($data->price, 4, '.', ',') }}</td> --}}
                            <td style="text-align: right">
                                {{-- @php
                                    $sub_total = $data->price * $data->quantity;
                                    $total_sum[] = round($sub_total, 2);
                                    echo number_format($sub_total, 2, '.', ',');
                                @endphp --}}
                                <input type="text" class="form-control" required name="price[{{$data->id}}]" value="{{ $data->price }}">
                            </td>
                            <td>{{ $data->attributes->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
              {{--   <tfoot>
                    <tr>
                        <th style="text-align: center" colspan="5">Total</th>
                        <th style="text-align: right">{{ number_format(array_sum($total_sum), 2, '.', ',') }}</th>
                        <th></th>
                    </tr>
                </tfoot> --}}
            </table>
        @else
        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>
                    <th>Principal</th>
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
                        <td>{{ $data->attributes->principal }}</td>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td style="text-align: right">{{ $data->quantity }}</td>
                        <td><input id="price"  style="text-align: right" onkeypress="return isNumberKey(event)" 
                            type="text" name="price[{{ $data->id }}]" class="form-control"></td>
                        <td>{{ $data->attributes->remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="row">
        <button type="submit" class="btn btn-info btn-block">Proceed To Final Summary</button>
    </div>
</form>

<script>
    $('.select2').select2();

    $("#van_selling_pcm_generate_final_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $.ajax({
            url: "van_selling_pcm_generate_final_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                // if (data == 'existing_pcm_number') {
                //     $('.loading').hide();
                //     Swal.fire(
                //         'Existing Pcm Number!!',
                //         'Cannot Proceed!',
                //         'error'
                //     )
                // } else {
                   
                // }
                 $('.loading').hide();
                    $('#van_selling_pcm_generate_final_summary_page').html(data);
            },
        });
    }));

    function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>
