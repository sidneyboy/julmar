<a href="{{ url('van_selling_customer_list_show_map',['location_id' => $location_id]) }}" target="_blank" class="btn btn-sm float-right btn-primary">Show In Map</a>
<br /><br />
<div class="table table-responsive">
    <table class="table table-bordered table-hover table-striped table-sm" style="width:100%;" id="example1">
        <thead>
            <tr>
                <th>Location</th>
                <th>Store Name</th>
                <th>KOB</th>
                <th>Barangay</th>
                <th>Address</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer as $data)
                <tr>
                    <td>{{ $data->location->location }}</td>
                    <td>{{ $data->store_name }}</td>
                    <td>{{ $data->store_type }}</td>
                    <td>{{ $data->barangay }}</td>
                    <td>{{ $data->address }}</td>
                    <td>{{ $data->contact_person }}</td>
                    <td>{{ $data->contact_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: true,
            ordering: true,
            info: true,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
