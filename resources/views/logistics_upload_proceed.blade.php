<form id="logistics_upload_save">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-striped table-sm" style="font-size:14px;">
            <thead>
                @for ($i = 0; $i < 1; $i++)
                    <tr>
                        <th class="text-center align-middle">{{ $csv[$i][0] }}</th>
                        <th class="text-center align-middle">{{ $csv[$i][1] }}</th>
                        <th class="text-center align-middle">{{ $csv[$i][2] }}</th>
                        <th class="text-center align-middle">{{ $csv[$i][3] }}</th>
                        <th class="text-center align-middle">{{ $csv[$i][4] }}
                            <input type="hidden" name="logistics_id" value="{{ $csv[$i][4] }}">
                        </th>
                        <td colspan="10"></td>
                    </tr>
                @endfor
                @for ($i = 1; $i < 2; $i++)
                    <tr>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][0]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][1]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][2]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][3]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][4]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][5]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][6]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][7]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][8]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][9]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][10]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][11]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][12]) }}</th>
                        <th class="text-center align-middle">{{ strtoupper($csv[$i][13]) }}</th>
                    </tr>
                @endfor
            </thead>
            <tbody>
                @for ($i = 2; $i < count($csv); $i++)
                    <tr>
                        <td class="text-center align-middle">
                            {{ strtoupper($csv[$i][0]) }}
                            <input type="hidden" name="sales_invoice_id[]" value="{{ $csv[$i][0] }}">
                        </td>
                        <td class="text-center align-middle">
                            {{ strtoupper($csv[$i][1]) }}
                            <input type="hidden" name="customer_id[]" value="{{ $csv[$i][1] }}">
                        </td>
                        <td class="text-center align-middle">{{ strtoupper($csv[$i][2]) }}</td>
                        <td class="text-center align-middle">{{ strtoupper($csv[$i][3]) }}</td>
                        <td class="text-center align-middle">{{ strtoupper($csv[$i][4]) }}</td>
                        <td class="text-center align-middle">{{ strtoupper($csv[$i][5]) }}</td>
                        <td class="text-center align-middle">{{ strtoupper($csv[$i][6]) }}</td>
                        <td class="text-center align-middle">{{ strtoupper($csv[$i][7]) }}</td>
                        <td class="text-center align-middle">{{ strtoupper($csv[$i][8]) }}</td>
                        <td class="text-center align-middle">
                            {{ strtoupper($csv[$i][9]) }}
                            <input type="hidden" name="deducted_amount[]" value="{{ $csv[$i][9] }}">
                        </td>
                        <td class="text-center align-middle">{{ strtoupper($csv[$i][10]) }}</td>
                        <td class="text-center align-middle">{{ strtoupper($csv[$i][11]) }}</td>
                        <td class="text-center align-middle">
                            {{ strtoupper($csv[$i][12]) }}
                            <input type="hidden" name="delivered_date[]" value="{{ $csv[$i][12] }}">
                        </td>
                        <td class="text-center align-middle">
                            @if ($csv[$i][13] == 'DELIVERED')
                                <p style="color:green">
                                    {{ strtoupper($csv[$i][13]) }}
                                </p>
                            @else
                                <p style="color:red">
                                    {{ strtoupper($csv[$i][13]) }}
                                </p>
                            @endif
                            <input type="hidden" name="status[]" value="{{ $csv[$i][13] }}">
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>


<script>
    $("#logistics_upload_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "logistics_upload_save",
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
</script>
