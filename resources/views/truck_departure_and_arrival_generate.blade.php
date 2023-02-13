<form id="truck_departure_and_arrival_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="5">SUMMARY</th>
                </tr>
                <tr>
                    <th>Plate No</th>
                    <th>Departure Date</th>
                    <th>Departure Time</th>
                    <th>Arrival Date</th>
                    <th>Arrival Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $truck_and_sales_invoice->truck->plate_no }}</td>
                    @if ($truck_and_sales_invoice->departure_date == null)
                        <td>{{ $date }}</td>
                        <td>{{ date('h:i a', strtotime($time)) }}</td>
                        <td></td>
                        <td>
                            <input type="hidden" value="{{ $date }}" name="date">
                            <input type="hidden" value="{{ $time }}" name="time">
                            <input type="hidden" value="departure" name="condition">
                        </td>
                    @else
                        <td>
                            <input type="hidden" value="{{ $date }}" name="date">
                            <input type="hidden" value="{{ $time }}" name="time">
                            <input type="hidden" value="arrival" name="condition">
                        </td>
                        <td></td>
                        <td>{{ $date }}</td>
                        <td>{{ date('h:i a', strtotime($time)) }}</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" value="{{ $truck_id }}" name="truck_id">
    <input type="hidden" value="{{ $truck_and_sales_invoice->id }}" name="truck_and_sales_invoice_id">
    <button type="submit" class="btn btn-block btn-success">Submit</button>

</form>

<script>
    $("#truck_departure_and_arrival_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        // $('#sales_order_migrate_summary_page').show();
        $.ajax({
            url: "truck_departure_and_arrival_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data = 'saved') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    location.reload();
                }
            },
        });
    }));
</script>
