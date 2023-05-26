<a href="{{ url('customer_list_show_map', ['location_id' => $location_id]) }}" target="_blank"
    class="btn btn-sm float-right btn-primary">Show In Map</a>
<br /><br />
<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped" id="example1"
        style="width:100%;font-size:13px;">
        <thead>
            <tr>
                <th style="text-align: center;">STORE NAME</th>
                <th style="text-align: center;">KOB</th>
                <th style="text-align: center;">CREDIT TERM</th>
                <th style="text-align: center;">CREDIT<br />LINE<br />AMOUNT</th>
                <th style="text-align: center;">LOCATION</th>
                <th style="text-align: center;">BRGY/PUROK/SITIO</th>
                <th style="text-align: center;">DETAILED<br />LOCATION</th>
                <th style="text-align: center;">CONTACT<br />PERSON</th>
                <th style="text-align: center;">CONTACT<br />NUMBER</th>
                <th style="text-align: center;">ADDITIONAL<br />INFORMATION</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($customer as $data)
                <tr>
                    {{-- <td style="text-align: center;text-transform: uppercase;">{{ $data->id }}</td> --}}
                    <td style="text-align: center;text-transform: uppercase;">{{ $data->store_name }}</td>
                    <td style="text-align: center;text-transform: uppercase;">{{ $data->kind_of_business }}
                    </td>
                    <td style="text-align: center;text-transform: uppercase;">{{ $data->credit_term }}</td>
                    <td style="text-align: center;text-transform: uppercase;">
                        {{ $data->credit_line_amount }}</td>
                    <td style="text-align: center;text-transform: uppercase;">
                        {{ $data->location->location }}

                    </td>
                    <td style="text-align: center;text-transform: uppercase;">
                        {{ $data->detailed_location }}</td>
                    <td style="text-align: center;text-transform: uppercase;">
                        {{ $data->detailed_location }}</td>
                    <td style="text-align: center;text-transform: uppercase;">{{ $data->contact_person }}
                    </td>
                    <td style="text-align: center;text-transform: uppercase;">{{ $data->contact_number }}
                    </td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle=modal
                            data-target="#exampleModal{{ $data->id }}">
                            VIEW <i class="fas fa-info-circle"></i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ADDITION
                                            INFORMATION</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="font-weight: bold;text-align: center;">
                                                        PRICE
                                                        LEVEL PER PRINCIPAL</th>
                                                </tr>
                                                <tr>
                                                    <th>Principal</th>
                                                    <th>Price Level</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->customer_principal_price as $price_level)
                                                    <tr>
                                                        <td>{{ $price_level->principal->principal }}</td>
                                                        <td>{{ $price_level->price_level }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Principal</th>
                                                    <th>Discount Rate %</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->customer_discount as $discount_rate)
                                                    <tr>
                                                        <td>{{ $discount_rate->principal->principal }}</td>
                                                        <td style="text-align: center;">
                                                            {{ number_format($discount_rate->customer_discount, 2, '.', ',') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">STORE CODE PER PRINCIPAL</th>
                                                </tr>
                                                <tr>
                                                    <th>PRINCIPAL</th>
                                                    <th>STORE CODE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->customer_principal_code as $store_code)
                                                    <tr>
                                                        <td>{{ $store_code->principal->principal }}</td>
                                                        <td>{{ $store_code->store_code }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

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
