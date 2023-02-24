<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm" id="example1">
        <thead>
            <tr>
                <th>Date</th>
                <th>#</th>
                <th>Principal</th>
                <th>Remarks</th>
                <th>Transacted By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bodega_out as $data)
                <tr>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                    <td><a href="{{ route('bodega_out_show_details', $data->id) }}"
                            target="_blank">{{ $data->id }}</a></td>
                    <td>{{ $data->principal->principal }}</td>
                    <td>{{ $data->remarks }}</td>
                    <td>{{ $data->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "buttons": [{
                extend: 'copyHtml5',
                footer: true
            },
            {
                extend: 'excelHtml5',
                footer: true
            },
            {
                extend: 'csvHtml5',
                footer: true
            },
            {
                extend: 'print',
                footer: true
            }
        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
