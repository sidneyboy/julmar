<div class="table table-responsive">
     <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th style="text-align: center;">ID #</th>
            <th style="text-align: center;">Principal</th>
            <th style="text-align: center;">Received ID</th>
            <th style="text-align: center;">Driver</th>
            <th style="text-align: center;">Remarks</th>
            <th style="text-align: center;">Total Amount Return</th>
            <th style="text-align: center;">Returned By</th>
            <th style="text-align: center;">Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($return_to_principal_data as $data)
            <tr>
              <td style="text-align: center;"><a target="_blank" href="{{ route('return_to_principal_show_list_details', $data->id ."=". $data->principal->principal) }}">{{ $data->id }}</a></td>
              <td style="text-align: center;text-transform: uppercase;">{{ $data->principal->principal }}</td>
              <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $data->received_id ."=". $data->principal->principal) }}" target="_blank">{{ $data->received_id }}</a></td>
              <td style="text-align: center;text-transform: uppercase;">{{ $data->personnel->full_name }}</td>
              <td style="text-align: center;text-transform: uppercase;">{{ $data->remarks }}</td>
              <td style="text-align: right;">{{ number_format($data->total_amount_return,2,".",",") }}</td>
              <td style="text-align: center;text-transform: uppercase;">{{ $data->user->name }}</td>
              <td style="text-align: center;">{{ $data->date }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
</div>