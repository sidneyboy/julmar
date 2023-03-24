<table class="table table-bordered table-hover table-sm table-striped" id="example1">
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

<script>
   $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: false,
            ordering: true,
            info: false,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
