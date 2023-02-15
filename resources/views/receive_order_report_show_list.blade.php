<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home"
                    role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">BO ALLOWANCE</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                    href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile"
                    aria-selected="false">INPUT VAT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill"
                    href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages"
                    aria-selected="false">RECEIVED SKU's</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill"
                    href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings"
                    aria-selected="false">JOURNAL ENTRY REGISTER</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-three-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                aria-labelledby="custom-tabs-three-home-tab">
                <center>
                    <h4 style="font-weight: bold;">JULMAR COMMERCIAL, INC.</h4>
                    <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
                    <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
                </center>
                <br />
                <center>
                    <span style="font-weight: bold;font-size:18px;">SUMMARY OF BO ALLOWANCES</span><br />
                    <span style="font-size:15px;">
                        {{ $date }}
                    </span><br />
                    Principal: <span style="font-weight: bold;font-size:15px;"> <?php echo $principal_name; ?></span>
                </center><br />

                @php
                    $sum_bo_allowance_tab_received_bo_allowance = [];
                    $sum_bo_allowance_tab_received_vatable_purchase = [];
                    $sum_bo_allowance_tab_bo_adjustment_bo_allowace = [];
                    $sum_bo_allowance_tab_return_vatable_purchase = [];
                    $sum_bo_allowance_tab_return_bo_allowace = [];
                    $sum_bo_allowance_tab_invoice_cost_adjustment_vatable_purchase = [];
                    $sum_bo_allowance_tab_invoice_cost_adjustment_bo_allowace = [];
                @endphp

                <table class="table table-bordered table-hovered example2" style="font-size:18px;">
                    <thead>
                        <tr>
                            <th style="text-align: center">RECEIVING REPORT</th>
                            <th style="text-align: center;">INVOICE NO.</th>
                            <th style="text-align: center">DATE</th>
                            <th style="text-align: center;background-color:#a4ff4f">VATABLE<br />PURCHASE</th>
                            <th style="text-align: center;background-color:#a4ff4f">BO<br />ALLOWANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($received_counter != 0)
                            @foreach ($received_order_data as $data)
                                <tr>
                                    <td style="text-align: center;"><a
                                            href="{{ route('received_order_report_show_details', $data->id . '=' . $principal_name) }}"
                                            target="_blank">{{ 'RR - ' . $data->id }}</a></td>
                                    <td style="text-align: center;text-transform: uppercase;">
                                        @if ($data->invoice_image != '')
                                            <button type="button" class="btn btn-link" data-toggle="modal"
                                                style="text-transform: uppercase;"
                                                data-target="#exampleModal_received_deliveries_id">
                                                {{ $data->dr_si }}
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal_received_deliveries_id"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog mw-100 w-75" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"
                                                                style="color:blue;font-weight: bold;">INVOICE IMAGE</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/' . $data->invoice_image) }}"
                                                                style="width:100%;">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ $data->dr_si }}
                                        @endif
                                    </td>
                                    <td style="text-align: center">{{ $data->date }}</td>
                                    <td style="text-align: right;color:green;font-weight: bold;">
                                        @php
                                            $sum_bo_allowance_tab_received_vatable_purchase[] = $data->total_vatable_purchase;
                                        @endphp
                                        {{ number_format($data->total_vatable_purchase, 2, '.', ',') }}
                                    </td>
                                    <td style="text-align: right;color:green;font-weight: bold;">
                                        @php
                                            $sum_bo_allowance_tab_received_bo_allowance[] = $data->total_bo_allowance_discount;
                                        @endphp
                                        {{ number_format($data->total_bo_allowance_discount, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @php
                                $sum_bo_allowance_tab_received_vatable_purchase[] = 0;
                                $sum_bo_allowance_tab_received_bo_allowance[] = 0;
                            @endphp
                        @endif

                        @if ($bo_counter != 0)
                            @foreach ($bo_adjustment_data as $data)
                                <tr>
                                    <td style="text-align: center;">
                                        <a href="{{ route('bo_allowance_adjustments_show_details', $data->id . '=' . $data->principal->principal . '=' . $data->particulars) }}"
                                            target="_blank">DM - BO {{ $data->id }}</a>

                                    </td>
                                    <td style="text-align: center;text-transform: uppercase;">
                                        @if ($data->invoice_image != '')
                                            <button type="button" class="btn btn-link" data-toggle="modal"
                                                style="text-transform: uppercase;"
                                                data-target="#exampleModal_received_deliveries_id">
                                                {{ $data->received->dr_si }}
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal_received_deliveries_id"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog mw-100 w-75" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"
                                                                style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/' . $data->invoice_image) }}"
                                                                style="width:100%;">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ $data->received->dr_si }}
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{ $data->date }}</td>
                                    <td style="text-align: right;font-weight: bold;color:green;">
                                        {{ number_format(0, 2, '.', ',') }}
                                    </td>
                                    <td style="text-align: right;font-weight: bold;color:green;">
                                        @php
                                            $sum_bo_allowance_tab_bo_adjustment_bo_allowace[] = $data->bo_allowance_deduction;
                                        @endphp
                                        {{ number_format($data->bo_allowance_deduction, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @php
                                $sum_bo_allowance_tab_bo_adjustment_bo_allowace[] = 0;
                            @endphp
                        @endif


                        @if ($return_counter != 0)
                            @foreach ($return_order_data as $data)
                                <tr>
                                    <td style="text-align: center;"><a target="_blank"
                                            href="{{ route('return_to_principal_show_list_details', $data->id . '=' . $data->principal->principal) }}">RET
                                            - {{ $data->id }}</a></td>
                                    {{-- <td style="text-align: center;">RET - {{ $data->id }}</td> --}}
                                    <td style="text-align: center;text-transform: uppercase;">
                                        @if ($data->invoice_image != '')
                                            <button type="button" class="btn btn-link" data-toggle="modal"
                                                style="text-transform: uppercase;"
                                                data-target="#exampleModal_received_deliveries_id">
                                                {{ $data->received->dr_si }}
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal_received_deliveries_id"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog mw-100 w-75" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"
                                                                style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/' . $data->invoice_image) }}"
                                                                style="width:100%;">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ $data->received->dr_si }}
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{ $data->date }}</td>
                                    <td style="text-align: right;background: color:red;font-weight: bold;color:red;">
                                        @php
                                            
                                            $sum_bo_allowance_tab_return_vatable_purchase[] = $data->return_vatable_purchase;
                                        @endphp
                                        {{ number_format($data->return_vatable_purchase * -1, 2, '.', ',') }}
                                    </td>
                                    <td style="text-align: right;background: color:red;font-weight: bold;color:red;">
                                        @php
                                            $sum_bo_allowance_tab_return_bo_allowace[] = ($data->return_vatable_purchase * $data->principal_discount->total_bo_allowance_discount) / 100;
                                        @endphp

                                        {{ number_format((($data->return_vatable_purchase * $data->principal_discount->total_bo_allowance_discount) / 100) * -1, 2, '.', ',') }}
                                    </td>
                            @endforeach
                        @else
                            @php
                                $sum_bo_allowance_tab_return_vatable_purchase[] = 0;
                                $sum_bo_allowance_tab_return_bo_allowace[] = 0;
                            @endphp
                        @endif

                        @if ($invoice_cost_counter != 0)
                            @foreach ($invoice_cost_data as $data)
                                <tr>
                                    <td style="text-align: center;">
                                        {{-- <td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $data->id ."=". $principal_name) }}" target="_blank">{{ "RR - ". $data->id }}</a></td> --}}
                                        <a href="{{ route('invoice_cost_adjustments_show_details', $data->id . '=' . $data->principal->principal . '=' . $data->particulars) }}"
                                            target="_blank">INVOICE - ADJUSTMENT {{ $data->id }}</a>
                                        {{--  INVOICE - ADJUSTMENT {{ $data->id }}</a> --}}
                                    </td>
                                    <td style="text-align: center;text-transform: uppercase;">
                                        @if ($data->invoice_image != '')
                                            <button type="button" class="btn btn-link" data-toggle="modal"
                                                style="text-transform: uppercase;"
                                                data-target="#exampleModal_received_deliveries_id">
                                                {{ $data->received->dr_si }}
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal_received_deliveries_id"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog mw-100 w-75" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"
                                                                style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/' . $data->invoice_image) }}"
                                                                style="width:100%;">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ $data->received->dr_si }}
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{ $data->date }}</td>
                                    <td style="text-align: right;font-weight: bold;color">
                                        @php
                                            $sum_bo_allowance_tab_invoice_cost_adjustment_vatable_purchase[] = $data->vatable_purchase;
                                        @endphp
                                        @if ($data->vatable_purchase > 0)
                                            <span
                                                style="color:green;">{{ number_format($data->vatable_purchase, 2, '.', ',') }}</span>
                                        @else
                                            <span
                                                style="color:red">{{ number_format($data->vatable_purchase, 2, '.', ',') }}</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;font-weight: bold;color">
                                        @php
                                            $sum_bo_allowance_tab_invoice_cost_adjustment_bo_allowace[] = $data->total_bo_allowance;
                                        @endphp
                                        @if ($data->total_bo_allowance > 0)
                                            <span
                                                style="color:green">{{ number_format($data->total_bo_allowance, 2, '.', ',') }}</span>
                                        @else
                                            <span
                                                style="color:red">{{ number_format($data->total_bo_allowance, 2, '.', ',') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @php
                                $sum_bo_allowance_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                $sum_bo_allowance_tab_invoice_cost_adjustment_bo_allowace[] = 0;
                            @endphp
                        @endif

                        @if ($received_counter == 0 and $bo_counter == 0 and $invoice_cost_counter != 0 and $return_counter)
                            <tr>
                                <td colspan="5" style="font-weight: bold;text-align: center">NO DATA FOUND!</td>
                            </tr>
                        @endif

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                            <td style="text-align: right;background-color:#a4ff4f;font-weight: bold">
                                {{ number_format(array_sum($sum_bo_allowance_tab_received_vatable_purchase) - array_sum($sum_bo_allowance_tab_return_vatable_purchase) + array_sum($sum_bo_allowance_tab_invoice_cost_adjustment_vatable_purchase), 2, '.', ',') }}
                            </td>
                            <td style="text-align: right;background-color:#a4ff4f;font-weight: bold">
                                {{ number_format(array_sum($sum_bo_allowance_tab_received_bo_allowance) - array_sum($sum_bo_allowance_tab_return_bo_allowace) + array_sum($sum_bo_allowance_tab_bo_adjustment_bo_allowace) + array_sum($sum_bo_allowance_tab_invoice_cost_adjustment_bo_allowace), 2, '.', ',') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <a target="_blank" class="btn btn-success float-right"
                    href="{{ route('received_order_report_print', $date_from . '=' . $date_to . '=' . $principal_id . '=' . $principal_name . '=BO ALLOWANCE') }}">PRINT
                    THIS</a>
            </div>


            <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                aria-labelledby="custom-tabs-three-profile-tab">
                <center>
                    <h4 style="font-weight: bold;">JULMAR COMMERCIAL, INC.</h4>
                    <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
                    <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
                </center>
                <br />
                <center>
                    <span style="font-weight: bold;font-size:18px;">SUMMARY OF VAT INPUTS</span><br />
                    <span style="font-size:15px;">
                        {{ $date }}
                    </span><br />
                    Principal: <span style="font-weight: bold;font-size:15px;"> <?php echo $principal_name; ?></span>
                </center><br />
                <table class="table table-bordered table-hovered example2" style="font-size:18px;" id="example2">
                    <thead>
                        <tr>
                            <th style="text-align: center">Receiving Report</th>
                            <th style="text-align: center;">Invoice No</th>
                            <th style="text-align: center">Date</th>
                            <th style="text-align: center;background-color:#a4ff4f">Vatable Purchase</th>
                            <th style="text-align: center;background-color:#a4ff4f">Input Vat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($received_counter != 0)
                            @foreach ($received_order_data as $data)
                                <tr>
                                    <td style="text-align: center;"><a
                                            href="{{ route('received_order_report_show_details', $data->id . '=' . $principal_name) }}"
                                            target="_blank">{{ 'RR - ' . $data->id }}</a></td>
                                    <td style="text-align: center;text-transform: uppercase;">
                                        @if ($data->invoice_image != '')
                                            <button type="button" class="btn btn-link" data-toggle="modal"
                                                style="text-transform: uppercase;"
                                                data-target="#exampleModal_input_vat_id">
                                                {{ $data->dr_si }}
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal_input_vat_id" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog mw-100 w-75" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"
                                                                style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/' . $data->invoice_image) }}"
                                                                style="width:100%;">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ $data->dr_si }}
                                        @endif
                                    </td>
                                    <td style="text-align: center">{{ $data->date }}</td>
                                    <td style="text-align: right;color:green;font-weight: bold;">
                                        @php
                                            $sum_vat_amount_tab_received_vatable_purchase[] = $data->total_vatable_purchase;
                                        @endphp
                                        {{ number_format($data->total_vatable_purchase, 2, '.', ',') }}
                                    </td>
                                    <td style="text-align: right;color:green;font-weight: bold;">
                                        @php
                                            $sum_vat_amount_tab_received_vat_amount[] = $data->total_vat_amount;
                                        @endphp
                                        {{ number_format($data->total_vat_amount, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @php
                                $sum_vat_amount_tab_received_vatable_purchase[] = 0;
                                $sum_vat_amount_tab_received_vat_amount[] = 0;
                            @endphp
                        @endif
                        @if ($return_counter != 0)
                            @for ($i = 0; $i < $return_counter; $i++)
                                <tr>
                                    <td style="text-align-last: center;"><a target="_blank"
                                            href="{{ route('return_to_principal_show_list_details', $return_order_data[$i]->id . '=' . $return_order_data[$i]->principal->principal) }}">RET
                                            - {{ $return_order_data[$i]->id }}</a></td>
                                    <td style="text-align-last: center;text-transform: uppercase;">
                                        @if ($data->invoice_image != '')
                                            <button type="button" class="btn btn-link" data-toggle="modal"
                                                style="text-transform: uppercase;"
                                                data-target="#exampleModal_input_vat_id">
                                                {{ $return_order_data[$i]->received->dr_si }}
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal_input_vat_id" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog mw-100 w-75" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"
                                                                style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/' . $data->invoice_image) }}"
                                                                style="width:100%;">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ $return_order_data[$i]->received->dr_si }}
                                        @endif
                                    </td>
                                    <td style="text-align-last: center;">{{ $return_order_data[$i]->date }}</td>
                                    <td style="text-align: right;color:red;font-weight: bold;">
                                        @php
                                            $sum_vat_amount_tab_return_vatable_purchase[] = $return_order_data[$i]->return_vatable_purchase;
                                        @endphp
                                        {{ number_format($return_order_data[$i]->return_vatable_purchase * -1, 2, '.', ',') }}
                                    </td>
                                    <td style="text-align: right;color:red;font-weight: bold;">
                                        @php
                                            $sum_vat_amount_tab_return_vat_amount[] = $return_order_data[$i]->return_vat_amount;
                                        @endphp
                                        {{ number_format($return_order_data[$i]->return_vat_amount * -1, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endfor
                        @else
                            @php
                                $sum_vat_amount_tab_return_vatable_purchase[] = 0;
                                $sum_vat_amount_tab_return_vat_amount[] = 0;
                            @endphp
                        @endif
                        @if ($bo_counter != 0)
                            @for ($i = 0; $i < $bo_counter; $i++)
                                <tr>
                                    <td style="text-align-last: center;">
                                        <a href="{{ route('bo_allowance_adjustments_show_details', $bo_adjustment_data[$i]->id . '=' . $bo_adjustment_data[$i]->principal->principal . '=' . $bo_adjustment_data[$i]->particulars) }}"
                                            target="_blank">DM - BO {{ $bo_adjustment_data[$i]->id }}</a>
                                    </td>
                                    <td style="text-align-last: center;text-transform: uppercase;">
                                        @if ($data->invoice_image != '')
                                            <button type="button" class="btn btn-link" data-toggle="modal"
                                                style="text-transform: uppercase;"
                                                data-target="#exampleModal_input_vat_id">
                                                {{ $bo_adjustment_data[$i]->received->dr_si }}
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal_input_vat_id" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog mw-100 w-75" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"
                                                                style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/' . $data->invoice_image) }}"
                                                                style="width:100%;">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ $bo_adjustment_data[$i]->received->dr_si }}
                                        @endif
                                    </td>
                                    <td style="text-align-last: center;">{{ $bo_adjustment_data[$i]->date }}</td>
                                    <td style="text-align: right;color:green;font-weight: bold;">
                                        {{ number_format(0, 2, '.', ',') }}
                                    </td>
                                    <td style="text-align: right;color:red;font-weight: bold;">
                                        @php
                                            $sum_vat_amount_tab_bo_allowance_vat_amount[] = $bo_adjustment_data[$i]->vat_deduction;
                                        @endphp
                                        {{ number_format($bo_adjustment_data[$i]->vat_deduction * -1, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endfor
                        @else
                            @php
                                $sum_vat_amount_tab_bo_allowance_vat_amount[] = 0;
                            @endphp
                        @endif

                        @if ($invoice_cost_counter != 0)
                            @for ($i = 0; $i < $invoice_cost_counter; $i++)
                                <tr>
                                    <td style="text-align: center;">
                                        <a href="{{ route('invoice_cost_adjustments_show_details', $invoice_cost_data[$i]->id . '=' . $invoice_cost_data[$i]->principal->principal . '=' . $invoice_cost_data[$i]->particulars) }}"
                                            target="_blank">INVOICE - ADJUSTMENT {{ $invoice_cost_data[$i]->id }}</a>
                                    </td>
                                    <td style="text-align: center;text-transform: uppercase;">

                                        @if ($data->invoice_image != '')
                                            <button type="button" class="btn btn-link" data-toggle="modal"
                                                style="text-transform: uppercase;"
                                                data-target="#exampleModal_input_vat_id">
                                                {{ $invoice_cost_data[$i]->received->dr_si }}
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal_input_vat_id" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog mw-100 w-75" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"
                                                                style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/' . $data->invoice_image) }}"
                                                                style="width:100%;">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ $invoice_cost_data[$i]->received->dr_si }}
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{ $invoice_cost_data[$i]->date }}</td>
                                    <td style="text-align: right;font-weight: bold;color">
                                        @php
                                            $sum_vat_amount_tab_invoice_cost_adjustment_vatable_purchase[] = $invoice_cost_data[$i]->vatable_purchase;
                                        @endphp
                                        @if ($invoice_cost_data[$i]->vatable_purchase > 0)
                                            <span
                                                style="color:green;">{{ number_format($invoice_cost_data[$i]->vatable_purchase, 2, '.', ',') }}</span>
                                        @else
                                            <span
                                                style="color:red">{{ number_format($invoice_cost_data[$i]->vatable_purchase, 2, '.', ',') }}</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;font-weight: bold;color">
                                        @php
                                            $sum_vat_amount_tab_invoice_cost_adjustment_vat_amount[] = $invoice_cost_data[$i]->vat_amount;
                                        @endphp
                                        @if ($invoice_cost_data[$i]->vat_amount > 0)
                                            <span
                                                style="color:green">{{ number_format($invoice_cost_data[$i]->vat_amount, 2, '.', ',') }}</span>
                                        @else
                                            <span
                                                style="color:red">{{ number_format($invoice_cost_data[$i]->vat_amount, 2, '.', ',') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        @else
                            @php
                                $sum_vat_amount_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                $sum_vat_amount_tab_invoice_cost_adjustment_vat_amount[] = 0;
                            @endphp
                        @endif

                        @if ($received_counter == 0 and $bo_counter == 0 and $invoice_cost_counter != 0 and $return_counter)
                            <tr>
                                <td colspan="5" style="font-weight: bold;text-align: center">NO DATA FOUND!</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                            <td style="text-align: right;background-color:#a4ff4f;font-weight: bold">
                                {{ number_format(array_sum($sum_vat_amount_tab_received_vatable_purchase) - array_sum($sum_vat_amount_tab_return_vatable_purchase) + array_sum($sum_vat_amount_tab_invoice_cost_adjustment_vatable_purchase), 2, '.', ',') }}
                            </td>
                            <td style="text-align: right;background-color:#a4ff4f;font-weight: bold">
                                {{ number_format(array_sum($sum_vat_amount_tab_received_vat_amount) - array_sum($sum_vat_amount_tab_return_vat_amount) - array_sum($sum_vat_amount_tab_bo_allowance_vat_amount) + array_sum($sum_vat_amount_tab_invoice_cost_adjustment_vat_amount), 2, '.', ',') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <a target="_blank" class="btn btn-success float-right"
                    href="{{ route('received_order_report_print', $date_from . '=' . $date_to . '=' . $principal_id . '=' . $principal_name . '=VAT INPUTS') }}">PRINT
                    THIS</a>
            </div>




            <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel"
                aria-labelledby="custom-tabs-three-messages-tab">
                <center>
                    <h4 style="font-weight: bold;">JULMAR COMMERCIAL, INC.</h4>
                    <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
                    <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
                </center>
                <center>
                    <span style="font-weight: bold;font-size:18px;">SUMMARY OF RECEIVED DELIVERIES</span><br />
                    <span style="font-size:15px;">
                        {{ $date }}
                    </span><br />
                    Principal: <span style="font-weight: bold;font-size:15px;"> <?php echo $principal_name; ?></span>
                </center>

                <br />

                @php
                    
                @endphp

                <div class="table table-responsive">
                    <table class="table table-bordered table-hovered example2" style="font-size:18px;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Reference<br />#</th>
                                <th style="text-align: center;">Invoice<br />No</th>
                                <th style="text-align: center;">Date</th>
                                <th style="text-align: center;background-color:#a4ff4f">Vatable<br />Purchase</th>
                                <th style="text-align: center;background-color:#a4ff4f">Discount</th>
                                <th style="text-align: center;background-color:#a4ff4f">BO <br />Allowance</th>
                                <th style="text-align: center;background-color:#a4ff4f">Net <br />Of<br />Discount</th>
                                <th style="text-align: center;background-color:#a4ff4f">Value<br />Added<br />Tax</th>
                                <th style="text-align: center;background-color:#a4ff4f">Freight</th>
                                <th style="text-align: center;background-color:#a4ff4f">Net<br />Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($received_counter != 0)
                                @foreach ($received_order_data as $received_data)
                                    <tr>
                                        <td style="text-align: center;">
                                            <a target="_blank"
                                                href="{{ route('received_order_report_show_details', $received_data->id . '=' . $principal_name) }}">RR
                                                - {{ $received_data->id }}</a>

                                        </td>
                                        <td style="text-align: center;text-transform: uppercase;">
                                            @if ($received_data->invoice_image != '')
                                                <button type="button" class="btn btn-link" data-toggle="modal"
                                                    style="text-transform: uppercase;"
                                                    data-target="#exampleModal_received_deliveries_id">
                                                    {{ $received_data->dr_si }}
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal_received_deliveries_id"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog mw-100 w-75" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"
                                                                    style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{ asset('/images/' . $received_data->invoice_image) }}"
                                                                    style="width:100%;">

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                {{ $received_data->dr_si }}
                                            @endif
                                        </td>
                                        <td style="text-align: center;">{{ $received_data->date }}</td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format($received_data->total_vatable_purchase, 2, '.', ',') }}
                                            @php
                                                $sum_received_tab_vatable_purchase[] = $received_data->total_vatable_purchase;
                                            @endphp
                                        </td>
                                        <td style="text-align: right;font-weight: bold;">
                                            @php
                                                $sum_received_tab_total_discount[] = $received_data->total_discount;
                                            @endphp
                                            {{ number_format($received_data->total_discount, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                                $sum_received_tab_bo_allowance[] = $received_data->total_bo_allowance_discount;
                                            @endphp
                                            {{ number_format($received_data->total_bo_allowance_discount, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                                $sum_received_tab_net_discount[] = $received_data->total_discount + $received_data->total_bo_allowance_discount;
                                            @endphp
                                            {{ number_format($received_data->total_discount + $received_data->total_bo_allowance_discount, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                                $sum_received_tab_vat_amount[] = $received_data->total_vat_amount;
                                            @endphp
                                            {{ number_format($received_data->total_vat_amount, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                                $sum_received_tab_freight[] = $received_data->total_freight;
                                            @endphp
                                            {{ number_format($received_data->total_freight, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                                $sum_received_tab_net_of_amount[] = $received_data->grand_total_final_cost;
                                            @endphp
                                            {{ number_format($received_data->grand_total_final_cost, 2, '.', ',') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @php
                                    $sum_received_tab_vatable_purchase[] = 0;
                                    $sum_received_tab_total_discount[] = 0;
                                    $sum_received_tab_bo_allowance[] = 0;
                                    $sum_received_tab_net_discount[] = 0;
                                    $sum_received_tab_vat_amount[] = 0;
                                    $sum_received_tab_freight[] = 0;
                                    $sum_received_tab_net_of_amount[] = 0;
                                @endphp
                            @endif
                            @if ($return_counter != 0)
                                @foreach ($return_order_data as $return_data)
                                    <tr>
                                        <td style="text-align: center;">
                                            <a target="_blank"
                                                href="{{ route('return_to_principal_show_list_details', $return_data->id . '=' . $return_data->principal->principal) }}">RET
                                                - {{ $return_data->id }}</a>

                                        </td>
                                        <td style="text-align: center;text-transform: uppercase;">
                                            @if ($return_data->received->invoice_image != '')
                                                <button type="button" class="btn btn-link" data-toggle="modal"
                                                    style="text-transform: uppercase;"
                                                    data-target="#exampleModal_received_return_deliveries_id">
                                                    {{ $return_data->received->dr_si }}
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade"
                                                    id="exampleModal_received_return_deliveries_id" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog mw-100 w-75" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"
                                                                    style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{ asset('/images/' . $return_data->received->invoice_image) }}"
                                                                    style="width:100%;">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                {{ $return_data->received->dr_si }}
                                            @endif
                                        </td>
                                        <td style="text-align: center;">{{ $return_data->date }}</td>
                                        <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                                $sum_received_tab_return_vatable_purchase[] = $return_data->return_vatable_purchase;
                                            @endphp
                                            {{ number_format($return_data->return_vatable_purchase * -1, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;font-weight: bold;">
                                            @php
                                                $sum_received_tab_return_total_discount[] = round($return_data->return_less_discount - ($return_data->return_vatable_purchase * $return_data->principal_discount->total_discount) / 100, 2);
                                            @endphp
                                            {{--  {{  number_format(round($return_data->return_less_discount - $return_data->return_vatable_purchase * ($return_data->principal_discount->total_discount)/100,2)*-1,2,".",",") }} --}}

                                            {{ number_format((($return_data->return_vatable_purchase * $return_data->principal_discount->total_discount) / 100) * -1, 2, '.', ',') }}


                                        </td>
                                        <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                                $sum_received_tab_return_bo_allowance[] = round(($return_data->return_vatable_purchase * $return_data->principal_discount->total_bo_allowance_discount) / 100, 2);
                                            @endphp
                                            {{ number_format(round((($return_data->return_vatable_purchase * $return_data->principal_discount->total_bo_allowance_discount) / 100) * -1, 2), 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                                $sum_received_tab_return_net_discount[] = round($return_data->return_net_discount, 2);
                                            @endphp
                                            {{ number_format(round($return_data->return_net_discount * -1, 2), 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                                $sum_received_tab_return_vat_amount[] = round($return_data->return_vat_amount, 2);
                                            @endphp
                                            {{ number_format(round($return_data->return_vat_amount * -1, 2), 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color:red;font-weight: bold;">0.00</td>
                                        <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                                $sum_received_tab_return_net_of_deduction[] = round($return_data->return_net_of_deduction, 2);
                                            @endphp
                                            {{ number_format(round($return_data->return_net_of_deduction * -1, 2), 2, '.', ',') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @php
                                    $sum_received_tab_return_vatable_purchase[] = 0;
                                    $sum_received_tab_return_total_discount[] = 0;
                                    $sum_received_tab_return_bo_allowance[] = 0;
                                    $sum_received_tab_return_net_discount[] = 0;
                                    $sum_received_tab_return_vat_amount[] = 0;
                                    $sum_received_tab_return_net_of_deduction[] = 0;
                                @endphp
                            @endif

                            @if ($bo_counter != 0)
                                @foreach ($bo_adjustment_data as $bo_data)
                                    <tr>
                                        <td style="text-align: center;">
                                            {{-- <a href="{{ route('bo_allowance_adjustments_show_details', $bo_adjustment_data[$i]->id ."=". $bo_adjustment_data[$i]->principal->principal ."=". $bo_adjustment_data[$i]->particulars) }}" target="_blank">DM - BO {{ $bo_adjustment_data[$i]->id }}</a> --}}
                                            DM - BO {{ $bo_data->id }}
                                        </td>
                                        <td style="text-align: center;text-transform: uppercase;">
                                            @if ($bo_data->received->invoice_image != '')
                                                <button type="button" class="btn btn-link" data-toggle="modal"
                                                    style="text-transform: uppercase;"
                                                    data-target="#exampleModal_received_bo_deliveries_id">
                                                    {{ $bo_data->received->dr_si }}
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal_received_bo_deliveries_id"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog mw-100 w-75" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"
                                                                    style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{ asset('/images/' . $bo_data->received->invoice_image) }}"
                                                                    style="width:100%;">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                {{ $bo_data->received->dr_si }}
                                            @endif
                                        </td>
                                        <td style="text-align: center;">{{ $bo_data->date }}</td>
                                        <td style="text-align: right;color:green;font-weight: bold;;">
                                            {{ number_format(0, 2, '.', ',') }}
                                            @php
                                                $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                                            @endphp
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;;">
                                            {{ number_format(0, 2, '.', ',') }}
                                            @php
                                                $sum_received_tab_bo_adjustment_total_discount[] = 0;
                                            @endphp
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format($bo_data->bo_allowance_deduction, 2, '.', ',') }}
                                            @php
                                                $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = $bo_data->bo_allowance_deduction;
                                            @endphp
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format(0, 2, '.', ',') }}</td>
                                        <td style="text-align: right;color:red;font-weight: bold;">
                                            {{ number_format($bo_data->vat_deduction * -1, 2, '.', ',') }}
                                            @php
                                                $sum_received_tab_bo_adjustment_vat_deduction[] = $bo_data->vat_deduction;
                                            @endphp
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format(0, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color: red;font-weight: bold;">
                                            {{ number_format($bo_data->net_deduction * -1, 2, '.', ',') }}
                                            @php
                                                $sum_received_tab_bo_adjustment_net_deduction[] = $bo_data->net_deduction;
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @php
                                    $sum_received_tab_bo_adjustment_bo_allowance_deduction[] = 0;
                                    $sum_received_tab_bo_adjustment_vat_deduction[] = 0;
                                    $sum_received_tab_bo_adjustment_net_deduction[] = 0;
                                    $sum_received_tab_bo_adjustment_vatable_purchase[] = 0;
                                    $sum_received_tab_bo_adjustment_total_discount[] = 0;
                                @endphp
                            @endif

                            @if ($invoice_cost_counter != 0)
                                @foreach ($invoice_cost_data as $invoice_data)
                                    <tr>
                                        <td style="text-align: center;">
                                            {{-- <a href="{{ route('bo_allowance_adjustments_show_details', $invoice_cost_data[$i]->id ."=". $invoice_cost_data[$i]->principal->principal ."=". $invoice_cost_data[$i]->particulars) }}" target="_blank">INVOICE - ADJUSTMENT {{ $invoice_cost_data[$i]->id }}</a> --}}
                                            INVOICE - ADJUSTMENT {{ $invoice_data->id }}
                                        </td>
                                        <td style="text-align: center;text-transform: uppercase;">
                                            @if ($invoice_data->received->invoice_image != '')
                                                <button type="button" class="btn btn-link" data-toggle="modal"
                                                    style="text-transform: uppercase;"
                                                    data-target="#exampleModal_received_invoice_deliveries_id">
                                                    {{ $invoice_data->received->dr_si }}
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade"
                                                    id="exampleModal_received_invoice_deliveries_id" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog mw-100 w-75" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"
                                                                    style="color:blue;font-weight: bold;">INVOICE IMAGE
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{ asset('/images/' . $invoice_data->received->invoice_image) }}"
                                                                    style="width:100%;">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                {{ $invoice_data->received->dr_si }}
                                            @endif
                                        </td>
                                        <td style="text-align: center;">{{ $invoice_data->date }}</td>
                                        <td style="text-align: right;color:green;font-weight: bold;;">

                                            @php
                                                $received_tab_invoice_cost_adjustment_vatable_purchase = $invoice_data->vatable_purchase;
                                                $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                            @endphp
                                            @if ($received_tab_invoice_cost_adjustment_vatable_purchase > 0)
                                                <span
                                                    style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase, 2, '.', ',') }}</span>
                                            @else
                                                <span
                                                    style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vatable_purchase, 2, '.', ',') }}</span>
                                            @endif

                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                                $received_tab_invoice_cost_adjustment_less_discount = $invoice_data->less_discount;
                                                $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                            @endphp
                                            @if ($received_tab_invoice_cost_adjustment_less_discount > 0)
                                                <span
                                                    style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_less_discount, 2, '.', ',') }}</span>
                                            @else
                                                <span
                                                    style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_less_discount, 2, '.', ',') }}</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                                $received_tab_invoice_cost_adjustment_bo_allowance = $invoice_data->total_bo_allowance;
                                                $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                            @endphp
                                            @if ($received_tab_invoice_cost_adjustment_bo_allowance > 0)
                                                <span
                                                    style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance, 2, '.', ',') }}</span>
                                            @else
                                                <span
                                                    style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_bo_allowance, 2, '.', ',') }}</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            @php
                                                $received_tab_invoice_cost_adjustment_net_discount = $invoice_data->net_discount;
                                                $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                            @endphp
                                            @if ($received_tab_invoice_cost_adjustment_net_discount > 0)
                                                <span
                                                    style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_discount, 2, '.', ',') }}</span>
                                            @else
                                                <span
                                                    style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_discount, 2, '.', ',') }}</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;color:red;font-weight: bold;">
                                            @php
                                                $received_tab_invoice_cost_adjustment_vat_amount = $invoice_data->vat_amount;
                                                $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                            @endphp
                                            @if ($received_tab_invoice_cost_adjustment_vat_amount > 0)
                                                <span
                                                    style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount, 2, '.', ',') }}</span>
                                            @else
                                                <span
                                                    style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_vat_amount, 2, '.', ',') }}</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;color:green;font-weight: bold;">
                                            {{ number_format(0, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right;color: red;font-weight: bold;">
                                            @php
                                                $received_tab_invoice_cost_adjustment_net_adjustment = $invoice_data->net_adjustment;
                                                $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                                            @endphp
                                            @if ($received_tab_invoice_cost_adjustment_net_adjustment > 0)
                                                <span
                                                    style="color:green">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment, 2, '.', ',') }}</span>
                                            @else
                                                <span
                                                    style="color:red">{{ number_format($received_tab_invoice_cost_adjustment_net_adjustment, 2, '.', ',') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @php
                                    $sum_received_tab_invoice_cost_adjustment_vatable_purchase[] = 0;
                                    $sum_received_tab_invoice_cost_adjustment_less_discount[] = 0;
                                    $sum_received_tab_invoice_cost_adjustment_bo_allowance[] = 0;
                                    $sum_received_tab_invoice_cost_adjustment_net_discount[] = 0;
                                    $sum_received_tab_invoice_cost_adjustment_vat_amount[] = 0;
                                    $sum_received_tab_invoice_cost_adjustment_net_adjustment[] = 0;
                                @endphp
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                                <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ number_format(array_sum($sum_received_tab_vatable_purchase) + array_sum($sum_received_tab_return_vatable_purchase) + array_sum($sum_received_tab_invoice_cost_adjustment_vatable_purchase), 2, '.', ',') }}
                                </td>
                                <td>
                                    {{ number_format(array_sum($sum_received_tab_total_discount) + array_sum($sum_received_tab_return_total_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_less_discount), 2, '.', ',') }}
                                </td>
                                <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ number_format(array_sum($sum_received_tab_bo_allowance) - array_sum($sum_received_tab_return_bo_allowance) + array_sum($sum_received_tab_bo_adjustment_bo_allowance_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_bo_allowance), 2, '.', ',') }}
                                </td>
                                <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ number_format(array_sum($sum_received_tab_net_discount) - array_sum($sum_received_tab_return_net_discount) + array_sum($sum_received_tab_invoice_cost_adjustment_net_discount), 2, '.', ',') }}
                                </td>
                                <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ number_format(array_sum($sum_received_tab_vat_amount) - array_sum($sum_received_tab_return_vat_amount) - array_sum($sum_received_tab_bo_adjustment_vat_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_vat_amount), 2, '.', ',') }}
                                </td>
                                <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">0</td>
                                <td style="text-align: right;font-weight: bold;background-color: #a4ff4f;">
                                    {{ number_format(array_sum($sum_received_tab_net_of_amount) - array_sum($sum_received_tab_return_net_of_deduction) - array_sum($sum_received_tab_bo_adjustment_net_deduction) + array_sum($sum_received_tab_invoice_cost_adjustment_net_adjustment), 2, '.', ',') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>







            <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel"
                aria-labelledby="custom-tabs-three-settings-tab">

                @php
                    $counter = 0;
                @endphp

                <center>
                    <h4 style="font-weight: bold;">JULMAR COMMERCIAL, INC.</h4>
                    <h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
                    <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
                </center>
                <center>
                    <span style="font-weight: bold;">JOURNAL ENTRY REGISTER</span><br />
                    <span>{{ $date }}</span><br />
                    Principal: <span style="font-weight: bold;"> <?php echo $principal_name; ?></span>
                </center><br />
                <table class="table table-bordered table-hovered" style="font-size:18px;">
                    <thead>
                        <tr>
                            <th colspan="5" style="text-align: center;font-weight: bold">GCI JOURNAL ENTRY</th>
                            <th style="text-align: center;background-color:#a4ff4f">DR</th>
                            <th style="text-align: center;background-color:#a4ff4f">CR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($received_counter != 0)
                            @foreach ($received_order_data as $data)
                                <tr>
                                    <td style="text-align: center"><a
                                            href="{{ route('received_order_report_show_details', $data->id . '=' . $principal_name) }}"
                                            target="_blank">{{ 'RR - ' . $data->id }}</a></td>
                                    <td>
                                        @php
                                            echo $counter += 1;
                                        @endphp. INVENTORY <span
                                            style="text-transform: uppercase;">{{ $principal_name }}</span></td>
                                    <td><span style="color:blue;font-style:italic">[ {{ $data->date }} ]</span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;color:green;font-weight: bold">
                                        <?php
                                        echo number_format($data->received_jer->dr, 2, '.', ',');
                                        $sum_dr[] = $data->received_jer->dr;
                                        ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>ACCOUNTS PAYABLE <span
                                        style="text-transform: uppercase;">{{ $principal_name }}</span></td>
                                <td><span style="color:blue;font-style:italic">[ {{ $data->date }} ]</span></td>
                                <td></td>

                                <td style="text-align: right;color:green;font-weight: bold">
                                    <?php
                                    echo number_format($data->received_jer->cr, 2, '.', ',');
                                    $sum_cr[] = $data->received_jer->cr;
                                    ?>
                                </td>
                            @endforeach


                        @endif
                        @foreach ($return_order_data as $return)
                            <tr>
                                <td style="text-align: center"><a target="_blank"
                                        href="{{ route('return_to_principal_show_list_details', $return->id . '=' . $return->principal->principal) }}">RET
                                        - {{ $return->id }}</a></td>
                                <td>
                                    @php
                                        echo $counter += 1;
                                    @endphp. ACCOUNTS PAYABLE <span
                                        style="text-transform: uppercase;">{{ $principal_name }}</span></td>
                                <td> <span style="color:blue;font-style:italic">[ {{ $return->date }} ]</span></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right;color:green;font-weight: bold">
                                    <?php
                                    echo number_format($return->return_jer->dr, 2, '.', ',');
                                    $sum_dr[] = $return->return_jer->dr;
                                    ?>
                                </td>
                                <td></td>
                            </tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> INVENTORY <span style="text-transform: uppercase;">{{ $principal_name }}</span>
                            </td>
                            <td><span style="color:blue;font-style:italic">[ {{ $return->date }} ]</span></td>
                            <td></td>

                            <td style="text-align: right;color:green;font-weight: bold">
                                <?php
                                echo number_format($return->return_jer->cr, 2, '.', ',');
                                $sum_cr[] = $return->return_jer->cr;
                                ?>
                            </td>
                        @endforeach
                        @foreach ($bo_adjustment_data as $bo)
                            <tr>
                                <td style="text-align: center"> <a
                                        href="{{ route('bo_allowance_adjustments_show_details', $bo->id . '=' . $bo->principal->principal . '=' . $bo->particulars) }}"
                                        target="_blank">DM - BO {{ $bo->id }}</a></td>
                                <td>
                                    @php
                                        echo $counter += 1;
                                    @endphp. ACCOUNTS PAYABLE <span
                                        style="text-transform: uppercase;">{{ $principal_name }}</span></td>
                                <td> <span style="color:blue;font-style:italic">[ {{ $bo->date }} ]</span></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right;color:green;font-weight: bold">
                                    <?php
                                    echo number_format($bo->bo_jer->dr, 2, '.', ',');
                                    $sum_dr[] = $bo->bo_jer->dr;
                                    ?>
                                </td>
                                <td></td>
                            </tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> INVENTORY <span style="text-transform: uppercase;">{{ $principal_name }}</span>
                            </td>
                            <td><span style="color:blue;font-style:italic">[ {{ $bo->date }} ]</span></td>
                            <td></td>

                            <td style="text-align: right;color:green;font-weight: bold">
                                <?php
                                echo number_format($bo->bo_jer->cr, 2, '.', ',');
                                $sum_cr[] = $bo->bo_jer->cr;
                                ?>
                            </td>
                        @endforeach
                        @foreach ($invoice_cost_data as $invoice)
                            @if ($invoice->invoice_cost_jer->dr < 0)
                                <tr>
                                    <td style="text-align: center"> <a
                                            href="{{ route('bo_allowance_adjustments_show_details', $invoice->id . '=' . $invoice->principal->principal . '=' . $invoice->particulars) }}"
                                            target="_blank">INVOICE - ADJUSTMENT {{ $invoice->id }}</a></td>
                                    <td>
                                        @php
                                            echo $counter += 1;
                                        @endphp. ACCOUNTS PAYABLE <span
                                            style="text-transform: uppercase;">{{ $principal_name }}</span></td>
                                    <td> <span style="color:blue;font-style:italic">[ {{ $invoice->date }} ]</span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;color:green;font-weight: bold">
                                        <?php
                                        echo number_format($invoice->invoice_cost_jer->dr * -1, 2, '.', ',');
                                        
                                        ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> INVENTORY <span style="text-transform: uppercase;">{{ $principal_name }}</span>
                                </td>
                                <td><span style="color:blue;font-style:italic">[ {{ $invoice->date }} ]</span></td>
                                <td></td>

                                <td style="text-align: right;color:green;font-weight: bold">
                                    <?php
                                    echo number_format($invoice->invoice_cost_jer->cr * -1, 2, '.', ',');
                                    
                                    ?>
                                </td>
                            @else
                                <tr>
                                    <td style="text-align: center"> <a
                                            href="{{ route('bo_allowance_adjustments_show_details', $invoice->id . '=' . $invoice->principal->principal . '=' . $invoice->particulars) }}"
                                            target="_blank">INVOICE - ADJUSTMENT {{ $invoice->id }}</a></td>
                                    <td>
                                        @php
                                            echo $counter += 1;
                                        @endphp. INVENTORY <span
                                            style="text-transform: uppercase;">{{ $principal_name }}</span></td>
                                    <td> <span style="color:blue;font-style:italic">[ {{ $invoice->date }} ]</span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;color:green;font-weight: bold">
                                        <?php
                                        echo number_format($invoice->invoice_cost_jer->dr, 2, '.', ',');
                                        
                                        ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> ACCOUNTS PAYABLE <span
                                        style="text-transform: uppercase;">{{ $principal_name }}</span> </td>
                                <td><span style="color:blue;font-style:italic">[ {{ $invoice->date }} ]</span></td>
                                <td></td>

                                <td style="text-align: right;color:green;font-weight: bold">
                                    <?php
                                    echo number_format($invoice->invoice_cost_jer->cr, 2, '.', ',');
                                    
                                    ?>
                                </td>
                            @endif
                        @endforeach

                        @if ($received_counter == 0 and $bo_counter == 0 and $invoice_cost_counter != 0)
                            <tr>
                                <td colspan="4" style="font-weight: bold;text-align: center">NO DATA FOUND!</td>
                            </tr>
                        @endif


                    </tbody>
                </table>
            </div>






        </div>
    </div>
</div>
<!-- /.card -->
</div>




<script type="text/javascript">
    $("#example1").DataTable();
    $('.example2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });
</script>
