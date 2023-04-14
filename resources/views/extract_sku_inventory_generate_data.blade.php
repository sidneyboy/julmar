<table class="table table-bordered table-hover table-sm table-striped" id="example1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Description</th>
            <th>Sku Type</th>
            <th>Unit Cost(VAT EX)</th>
            <th>Price 1</th>
            <th>Price 2</th>
            <th>Price 3</th>
            <th>Price 4</th>
            <th>Price 5</th>
            <th>FUC</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sku as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->sku_code }}</td>
                <td>{{ $data->description }}</td>
                <td>{{ $data->sku_type }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{-- <table class="table table-bordered table-hover table-sm table-striped" id="example1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Description</th>
            <th>Sku Type</th>
            <th>Running Inventory</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sku as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->sku_code }}</td>
                <td>{{ $data->description }}</td>
                <td>{{ $data->sku_type }}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
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
