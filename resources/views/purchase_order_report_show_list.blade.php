<table class="table table-bordered table-sm" style="width:100%">
  <thead>
    <tr>
      <th style="text-align: center;">PO #</th>
      <th style="text-align: center;">PRINCIPAL</th>
      <th style="text-align: center;">REMARKS</th>
      <th style="text-align: center;">SO #</th>
      <th style="text-align: center;">PARTICULARS</th>
      <th style="text-align: center;">PAYMENT TERM</th>
      <th style="text-align: center;">DELIVERY TERM</th>
      <th style="text-align: center;">DATE</th>
      <th style="text-align: center;">UPDATE</th>
    </tr>
  </thead>
  <tbody>
    @if($counter != 0)
    @foreach ($purchase_order_data as $data)
    <tr>
      <td style="text-align: center;"><a href="{{ route('purchase_order_report_show_details', $data->id ."=". $data->skuPrincipal->principal ."=". $data->skuPrincipal->contact_number ."=". $data->payment_term ."=". $data->delivery_term ."=". $data->purchase_id ."=". $data->user->name ."=". $data->sales_order_number) }}"  target="_blank">{{ $data->purchase_id }}</a></td>
      <td style="text-align: center;">{{ $data->skuPrincipal->principal }}</td>
      <td style="text-align: center;">
        @php
        if($data->remarks == ''){
        echo 'NULL';
        }else{
        if ($data->remarks == 'Incomplete') {
        echo "<span style='font-weight:bold;color:red'>". $data->remarks ."</span>";
        }elseif($data->remarks == 'Received'){
        echo "<span style='font-weight:bold;color:green'>". $data->remarks ."</span>";
        }elseif($data->remarks == 'Staggered'){
        echo "<span style='font-weight:bold;color:orange'>". $data->remarks ."</span>";
        }else{
        echo $data->remarks;
        }
        }
        @endphp
      </td>
      <td>{{ $data->sales_order_number }}</td>
      <td style="text-align: center;">
        @if($data->particulars == '')
        Show
        @else
        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#particulars{{ $data->id }}">
        Show
        </button>
        <!-- Modal -->
        <div class="modal fade" id="particulars{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CONTENT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <p style="">{{ $data->particulars }}</p>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        @endif
      </td>
      <td style="text-align: center;">{{ $data->payment_term }}</td>
      <td style="text-align: center;">{{ $data->delivery_term }}</td>
      <td style="text-align: center;">{{ $data->date }}</td>
      <td style="text-align: center;">
      @if($data->po_confirmation_image != '')
        <button type="button" class="btn btn-sm btn-block btn-info" data-toggle="modal" data-target="#confirmation_image{{ $data->id }}">
        Confirmation Image
        </button>
        <!-- Modal -->
        <div class="modal fade" id="confirmation_image{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog mw-100 w-75" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">UPLOADED CONFIRMATION IMAGE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('confirmation.upload.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <div class="form-group">
                    <label>Uploaded Image</label>
                    <img src="{{  asset('/images/'. $data->po_confirmation_image) }}" style="width:100%;">
                  </div>
                  <div class="form-group">
                      @if($data->remarks == 'Received')

                      @elseif($data->remarks == 'Incomplete')
                      @else
                        <label style="text-align: left">Remarks</label>
                        <select class="form-control select2" name="remarks" required>
                          <option value="" default>Select</option>
                          <option value="Incomplete">Incomplete</option>
                          <option value="No remarks">No remarks</option>
                        </select>
                      @endif
                  </div>
 
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>


      @else


        <button type="button" class="btn btn-sm btn-block btn-info" data-toggle="modal" data-target="#upload_confirmation_image{{ $data->id }}">
        Upload and Update Remarks
        </button>
        <!-- Modal -->
        <div class="modal fade" id="upload_confirmation_image{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UPLOAD CONFIRMATION IMAGE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('confirmation.upload.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <div class="form-group">
                    <img id="blah" src="{{ asset('/adminLte/default_image.jpg') }}" style="width:100%;border-radius: 1px 1px 0px 0px;" alt="your image" class="img img-thumbnail"/>
                    <input type='file' name="image" class="form-control" onchange="readURL(this);" required/>
                    
                    <input type="hidden" name="purchase_id" value="{{ $data->id }}">
                  </div>
                  <div class="form-group">
                    
                      @if($data->remarks == 'Received')

                      @elseif($data->remarks == 'Incomplete')
                      @else
                      <label style="text-align: left">Remarks</label>
                       <select class="form-control select2" name="remarks" required>
                         <option value="" default>Select</option>
                         <option value="Incomplete">Incomplete</option>
                         <option value="No remarks">No remarks</option>
                       </select>
                      @endif
                   
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      @endif



















      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="7" style="text-align: center;color:red;font-weight: bold;">NO DATA FOUND!</td>
    </tr>
    @endif
  </tbody>
</table>
<script type="text/javascript">
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();
reader.onload = function (e) {
$('#blah').attr('src', e.target.result);
}
reader.readAsDataURL(input.files[0]);
}
}
</script>