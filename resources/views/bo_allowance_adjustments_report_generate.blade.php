@extends('layouts.master')

@section('title', 'Return To Principal REPORT')

@section('navbar')


@section('sidebar')


@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">BO ALLOWANCE ADJUSTMENT DETAILED REPORT</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover table-sm table-striped">
                        <thead>
                            {{-- <tr>
                                <th colspan="10">Particulars:
                                    {{ $bo_adjustments_details[0]->bo_allowance_adjustment->particulars }}</th>
                            </tr> --}}
                            <tr>
                                <th class="text-center align-middle">CODE</th>
                                <th class="text-center align-middle">DESCRIPTIOn</th>
                                <th class="text-center align-middle">UOM</th>
                                <th class="text-center align-middle">QTY</th>
                                <th class="text-center align-middle">COST ADJUSTMENT</th>
                                <th class="text-center align-middle">BO DISCOUNT</th>
                                <th class="text-center align-middle">BO ALLOWANCE</th>
                                <th class="text-center align-middle">VAT</th>
                                <th class="text-center align-middle">FREIGHT</th>
                                <th class="text-center align-middle">TOTAL COST</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bo_adjustments_details as $data)
                                <td style="text-transform: uppercase;text-align: center;">{{ $data->sku->sku_code }}
                                </td>
                                <td style="text-transform: uppercase;text-align: center;">{{ $data->sku->description }}
                                </td>
                                <td style="text-transform: uppercase;text-align: center;">{{ $data->sku->unit_of_measurement }}
                                </td>
                                <td style="text-align: right">{{ $data->quantity }}</td>
                                <td style="text-align: right">
                                    {{ number_format($data->bo_cost_adjustment, 2, '.', ',') }}
                                </td>
                                <td style="text-align: right">
                                    {{ number_format($data->bo_discount, 2, '.', ',') }}%
                                </td>
                                <td style="text-align: right">
                                    {{ number_format($data->quantity * $data->bo_cost_adjustment, 2, '.', ',') }}
                                </td>
                                <td style="text-align: right">
                                    {{ number_format($data->vat, 2, '.', ',') }}
                                </td>
                                <td style="text-align: right">
                                    {{ number_format($data->freight, 2, '.', ',') }}
                                </td>
                                <td style="text-align: right">
                                    {{ number_format($data->total_cost, 2, '.', ',') }}
                                    @php
                                        $sum_total_amount[] = $data->total_cost;
                                    @endphp
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <table class="table table-bordered table-hover table-striped table-sm float-right" style="width:35%;margin-bottom:10px;">
                    <tr>
                        <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY:
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">BO ALLOWANCE</td>
                        <td style="font-weight: bold; text-align: right;font-size: 15px;">
                            @php
                                $bo_allowance_deduction = array_sum($sum_total_amount);
                            @endphp
                            {{ number_format($bo_allowance_deduction, 2, '.', ',') }}
                            <input type="hidden" name="bo_allowance_deduction" value="{{ $bo_allowance_deduction }}">
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">NET DEDUCTION</td>
                        <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                            @php
                                $vat_deduction = array_sum($sum_total_amount) * 0.12;
                            @endphp
                            <input type="hidden" name="vat_deduction" value="{{ $vat_deduction }}">
                            @php
                                $net_deduction = $bo_allowance_deduction;
                            @endphp
                            {{ number_format($net_deduction, 2, '.', ',') }}
                            <input type="hidden" name="net_deduction" value="{{ $net_deduction }}">
                        </td>
                    </tr>
                </table>
                
                @if ($net_deduction < 0)
                    <table class="table table-bordered table-hover table-striped table-sm">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                                <th style="text-align: center;">DR</th>
                                <th style="text-align: center;">CR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;">ACCOUNTS PAYABLE -
                                    {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                                <td></td>
                                <td style="font-weight: bold;text-align: center;">
                                    {{ number_format($net_deduction * -1, 2, '.', ',') }}
                                </td>
                                <td></td>

                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: center;">INVENTORY -
                                    {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                                <td></td>
                                <td style="font-weight: bold;text-align: center;">
                                    {{ number_format($net_deduction * -1, 2, '.', ',') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <table class="table table-bordered table-hover table-striped table-sm">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                                <th style="text-align: center;">DR</th>
                                <th style="text-align: center;">CR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;">INVENTORY -
                                    {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                                <td></td>
                                <td style="font-weight: bold;text-align: center;">
                                    {{ number_format($net_deduction, 2, '.', ',') }}
                                </td>
                                <td></td>

                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: center;">ACCOUNTS PAYABLE -
                                    {{ $bo_adjustments_details[0]->bo_allowance_adjustment->principal->principal }}</td>
                                <td></td>
                                <td style="font-weight: bold;text-align: center;">
                                    {{ number_format($net_deduction, 2, '.', ',') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

@endsection


@section('footer')
    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    </body>

    </html>
@endsection
