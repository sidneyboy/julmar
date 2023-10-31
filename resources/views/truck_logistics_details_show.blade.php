<form id="truck_load_list_update_delivery_status">
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped table-hover" style="font-size:13px;"
            id="truck_load_details_table">
            <thead>
                <tr>
                    <th style="text-align: center;">Mode of Transaction</th>
                    <th style="text-align: center;">Delivery Receipt</th>
                    <th style="text-align: center;">Principal</th>
                    <th style="text-align: center;">Sku Type</th>
                    <th style="text-align: center;">Store Name</th>
                    <th style="text-align: center;">Amount</th>
                    <th style="text-align: center;">Delivery Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logistics_details as $details)
                    <tr>
                        <td>{{ $details->sales_invoice->mode_of_transaction }}</td>
                        <td>{{ $details->sales_invoice->delivery_receipt }}</td>
                        <td>{{ $details->sales_invoice->principal->principal }}</td>
                        <td>{{ $details->sales_invoice->sku_type }}</td>
                        <td>{{ $details->sales_invoice->customer->store_name }}</td>
                        <td>{{ number_format($details->sales_invoice->total, 2, '.', ',') }}</td>
                        <td>
                            <input type="date" name="delivery_date[{{ $details->id }}]"
                                class="form-control form-control-sm">
                            <input type="hidden" name="sales_invoice_id[{{ $details->id }}]"
                                class="form-control form-control-sm" value="{{ $details->sales_invoice_id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br />
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <select name="mark_as_status" class="form-control">
                        <option value="" default>Update delivery status</option>
                        <option value="completed">Mark as successful delivery</option>
                        <option value="failed">Mark as failed delivery</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <br />
            <input type="hidden" name="logistics_id" value="{{ $logistics_id }}">
            <button class="btn btn-sm float-right btn-success">Submit</button>
        </div>
    </div>
</form>



<script>
    $("#truck_load_list_update_delivery_status").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "truck_load_list_update_delivery_status",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                location.reload();
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

    $(document).ready(function() {
        var table = $('#truck_load_details_table').DataTable({
            responsive: false,
            paging: false,
            ordering: false,
            info: false,
            // dom: 'Bfrtip',
            // buttons: [
            //     'copyHtml5',
            //     'excelHtml5',
            //     'csvHtml5',
            //     'pdfHtml5'
            // ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
