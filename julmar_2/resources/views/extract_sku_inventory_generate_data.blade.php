@if ($extract_for == 'VAN SELLING')
    <table class="table table-bordered table-hover" id="export_sku_inventory">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Description</th>
                <th>Principal</th>
                <th>Sku Type</th>
                <th>UOM</th>
                <th>Unit Price</th>
                <th>VAN SELLING INVENTORY</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sku as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ strtoupper(str_replace(',', '', $data->sku_code)) }}</td>
                    <td>{{ strtoupper(str_replace(',', '', $data->description)) }}</td>
                    <td>{{ $data->skuPrincipal->principal }}</td>
                    <td>{{ strtoupper(str_replace(',', '', $data->sku_type)) }}</td>
                    <td>{{ strtoupper(str_replace(',', '', $data->unit_of_measurement)) }}</td>
                    <td>{{ $data->sku_price_details_one->price_2 }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button class="btn btn-success btn-flat btn-sm btn-block" style="font-weight: bold;"
        onclick="exportTableToCSV('Van Selling OS Inventory.csv')">EXPORT NOW</button>

@elseif($extract_for == 'BOOKING')
    <form id="extract_sku_inventory_generate_export_data">
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Principal</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Sku Type</th>
                    <th>UOM</th>
                    <th>Category</th>
                    <th><input type="checkbox" class="form-control" id="select_all"
                            style="height: 25px;width: 25px;background-color: #eee" /></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sku as $data)
                    <tr>
                        <td>{{ $data->skuPrincipal->principal }}</td>
                        <td>{{ $data->sku_code }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->sku_type }}</td>
                        <td>{{ $data->unit_of_measurement }}</td>
                        <td>
                            @if ($data->skuCategory)
                                {{ $data->skuCategory->category }}
                            @endif
                        </td>
                        <td><input class="checkbox form-control"
                                style="heigh
				t: 25px;width: 25px;background-color: #eee" type="checkbox"
                                name="sku[]" value="{{ $data->id }}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row">
            <button type="submit" class="btn btn-info btn-block">PROCEED</button>
        </div>
    </form>
@endif


<script type="text/javascript">
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {
            type: "text/csv"
        });

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }

    function exportTableToCSV(filename) {

        $('.loading').show();
        let timerInterval
        Swal.fire({
            title: 'Extracting data!!',
            html: 'Reloading page in <b></b> milliseconds.',
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                    const content = Swal.getContent()
                    if (content) {
                        const b = content.querySelector('b')
                        if (b) {
                            b.textContent = Swal.getTimerLeft()
                        }
                    }
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                var csv = [];
                var rows = document.querySelectorAll("#export_sku_inventory tr");
                for (var i = 0; i < rows.length; i++) {
                    var row = [],
                        cols = rows[i].querySelectorAll("td, th");
                    for (var j = 0; j < cols.length; j++)
                        row.push(cols[j].innerText);
                    csv.push(row.join(","));

                }
                downloadCSV(csv.join("\n"), filename);
                location.reload();
            }
        })
    }
</script>

<script type="text/javascript">
    $("#extract_sku_inventory_generate_export_data").on('submit', (function(e) {
        e.preventDefault();
        $('.loading').show();
        $.ajax({
            url: "extract_sku_inventory_generate_export_data",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('#extract_sku_inventory_generate_export_data_page').html(data);
                $('.loading').hide();
            },
        });
    }));

    $("#example1").DataTable();
    $('#example2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
    });

    var select_all = document.getElementById("select_all"); //select all checkbox
    var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

    //select all checkboxes
    select_all.addEventListener("change", function(e) {
        for (i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = select_all.checked;
        }
    });


    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function(e) { //".checkbox" change 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if (this.checked == false) {
                select_all.checked = false;
            }
            //check "select all" if all checkbox items are checked
            if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
                select_all.checked = true;
            }
        });
    }
</script>
