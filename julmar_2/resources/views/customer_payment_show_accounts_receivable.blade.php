<form id="customer_payment_generate_summary">
    @csrf
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="text-align: center;">OR #</th>
                    <th style="text-align: center;">DR #</th>
                    <th style="text-align: center;">DUE DATE</th>
                    <th style="text-align: center;">OUTSTANDING BALANCE</th>
                    <th style="text-align: center;">CASH</th>
                    <th style="text-align: center;">CHECK</th>
                    <th style="text-align: center;">CHECK DETAILS<br />(<span style="color:blue;">CHECK # AND CHECK
                            DATE</span>)</th>
                    <th style="text-align: center;">REMARKS</th>
                    <th style="text-align: center;">DELIVERED</th>
                    <th style="text-align: center;">ATTACHMENTS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($select_all_data_from_sales_order_printed as $data)
                    <tr>
                        <td><input type="text" name="or_number[{{ $data->id }}]" class="form-control"></td>
                        <td>
                            <input type="hidden" name="delivery_receipt[{{ $data->id }}]"
                                value="{{ $data->delivery_receipt }}">
                            {{ $data->delivery_receipt }}
                        </td>
                        <td>
                            <input type="hidden" name="due_date[{{ $data->id }}]"
                                value="{{ date('Y-m-d', strtotime($data->date . $data->customer->credit_term)) }}">
                            {{ date('Y-m-d', strtotime($data->date . $data->customer->credit_term)) }}
                        </td>

                        <td style="text-align: right;color:green;font-weight: bold;">
                            @php
                                $sum_total_amount[] = $data->total;
                            @endphp


                            @if (array_sum($customer_previous_payment) != 0)
                                @php
                                    $prev_collection = $customer_previous_payment[$data->id];
                                @endphp
                            @else
                                @php
                                    $prev_collection = 0;
                                @endphp
                            @endif

                            @php
                                $total_payable_amount = $data->total - $data->total_payment - $prev_collection - $rgs_prev_collection[$data->id] - $bo_prev_collection[$data->id];
                            @endphp
                            {{ number_format($total_payable_amount, 2, '.', ',') }}
                            <input type="hidden" name="outstanding_balance[{{ $data->id }}]"
                                value="{{ $total_payable_amount }}">
                            <input type="hidden" name="bo_prev_collection[{{ $data->id }}]"
                                value="{{ $bo_prev_collection[$data->id] }}">
                            <input type="hidden" name="rgs_prev_collection[{{ $data->id }}]"
                                value="{{ $rgs_prev_collection[$data->id] }}">
                            <input type="hidden" name="prev_collection[{{ $data->id }}]"
                                value="{{ $prev_collection }}">
                            <input type="hidden" name="total_dr_amount[{{ $data->id }}]"
                                value="{{ $data->total_amount }}">
                            <input type="hidden" name="agent_id[{{ $data->id }}]" value="{{ $data->agent->id }}"
                                class="form-control">

                            <input type="hidden" name="id[]" value="{{ $data->id }}">
                            <input type="hidden" name="customer_id[{{ $data->id }}]"
                                value="{{ $data->customer_id }}">
                            <input type="hidden" name="sales_order_number[{{ $data->id }}]"
                                value="{{ $data->sales_order_number }}">
                            <input type="hidden" name="principal_id[{{ $data->id }}]"
                                value="{{ $data->principal->id }}">
                            <input type="hidden" name="principal_name[{{ $data->id }}]"
                                value="{{ $data->principal->principal }}">
                            <input type="hidden" name="agent[{{ $data->id }}]"
                                value="{{ $data->agent->full_name }}">
                        </td>
                        <td><input type="text" name="cash_amount[{{ $data->id }}]" class="currency-default"
                                value="0"
                                style="display: block;
						width: 100%;
						height: calc(2.25rem + 2px);
						padding: .375rem .75rem;
						font-size: 1rem;
						font-weight: 400;
						line-height: 1.5;
						color: #495057;
						background-color: #fff;
						background-clip: padding-box;
						border: 1px solid #ced4da;
						border-radius: .25rem;
						box-shadow: inset 0 0 0 transparent;
					transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center">
                        </td>

                        <td><input type="text" name="check_amount[{{ $data->id }}]" class="currency-default"
                                value="0"
                                style="display: block;
						width: 100%;
						height: calc(2.25rem + 2px);
						padding: .375rem .75rem;
						font-size: 1rem;
						font-weight: 400;
						line-height: 1.5;
						color: #495057;
						background-color: #fff;
						background-clip: padding-box;
						border: 1px solid #ced4da;
						border-radius: .25rem;
						box-shadow: inset 0 0 0 transparent;
					transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center">
                        </td>
                        <td>
                            <input type="text" placeholder="Check #" name="check_number[{{ $data->id }}]"
                                class="form-control"><br />
                            <input type="date" name="check_date[{{ $data->id }}]" class="form-control">
                        </td>
                        <td><input type="text" name="remarks[{{ $data->id }}]" class="form-control"></td>
                        <td>

                            @if ($data->date_delivered != '')
                                <input type="date" name="date_delivered[{{ $data->id }}]"
                                    value="{{ $data->date_delivered }}" required class="form-control">
                            @else
                                <input type="date" name="date_delivered[{{ $data->id }}]" required
                                    class="form-control">
                            @endif

                        </td>
                        <td>
                            @if ($check_image[$data->id])
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal"
                                    data-target="#exampleModaldepositAttachment{{ $data->id }}">
                                    View
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModaldepositAttachment{{ $data->id }}"
                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Check/Deposit Slip</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="{{ asset('/storage/' . $check_image[$data->id]->file) }}"
                                                    class="img img-thumbnail">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="color:blue;font-weight: bold;text-align: right;font-size:20px">ADD
                            REFER:</td>
                        <td><input type="text" name="refer_cash_amount[{{ $data->id }}]"
                                class="currency-default" value="0"
                                style="display: block;
						width: 100%;
						height: calc(2.25rem + 2px);
						padding: .375rem .75rem;
						font-size: 1rem;
						font-weight: 400;
						line-height: 1.5;
						color: #495057;
						background-color: #fff;
						background-clip: padding-box;
						border: 1px solid #ced4da;
						border-radius: .25rem;
						box-shadow: inset 0 0 0 transparent;
					transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center">
                        </td>
                        <td><input type="text" name="refer_check_amount[{{ $data->id }}]"
                                class="currency-default" value="0"
                                style="display: block;
						width: 100%;
						height: calc(2.25rem + 2px);
						padding: .375rem .75rem;
						font-size: 1rem;
						font-weight: 400;
						line-height: 1.5;
						color: #495057;
						background-color: #fff;
						background-clip: padding-box;
						border: 1px solid #ced4da;
						border-radius: .25rem;
						box-shadow: inset 0 0 0 transparent;
					transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center">
                        </td>
                        <td>
                            <input type="text" placeholder="Check #"
                                name="refer_check_number[{{ $data->id }}]" class="form-control"><br />
                            <input type="date" name="refer_check_date[{{ $data->id }}]" class="form-control">
                        </td>
                        <td><input type="text" name="refer_remarks[{{ $data->id }}]" class="form-control">
                        </td>

                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="14">
                        <button class="btn btn-info btn-block" type="submit">GENERATE FINAL SUMMARY</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>


    {{-- <div cass="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
				<tr>
					<th colspan="10">GENERATED CUSTOMER ACCOUNTS PAYABLE PER PRINCIPAL</th>
				</tr>
                <tr>
                    <th>STORE NAME</th>
                    <th>DR</th>
                    <th>PRINCIPAL</th>
                    <th>OUTSTANDING BALANCE</th>
                    <th>CASH</th>
                    <th>CHECK</th>
                    <th style="text-align: center;">CHECK DETAILS<br />(<span style="color:blue;">CHECK # AND CHECK DATE</span>)</th>
                    <th>REMARKS</th>
                    <th>PAYMENT STATUS</th>
                    <th>DELIVERY DATE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice as $data)
                    <tr>
                        <td>{{ $data->customer->store_name }}</td>
                        <td>{{ $data->delivery_receipt }}</td>
                        <td>{{ $data->principal->principal }}</td>
                        <td style="text-align: right">{{ number_format($data->total - $data->total_payment, 2, '.', ',') }}
                        </td>
                        <td><input type="text" name="cash_amount[{{ $data->id }}]" class="currency-default"
                                value="0"
                                style="display: block;
							width: 100%;
							height: calc(2.25rem + 2px);
							padding: .375rem .75rem;
							font-size: 1rem;
							font-weight: 400;
							line-height: 1.5;
							color: #495057;
							background-color: #fff;
							background-clip: padding-box;
							border: 1px solid #ced4da;
							border-radius: .25rem;
							box-shadow: inset 0 0 0 transparent;
						transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center">
                        </td>
                        <td><input type="text" name="check_amount[{{ $data->id }}]" class="currency-default"
                                value="0"
                                style="display: block;
							width: 100%;
							height: calc(2.25rem + 2px);
							padding: .375rem .75rem;
							font-size: 1rem;
							font-weight: 400;
							line-height: 1.5;
							color: #495057;
							background-color: #fff;
							background-clip: padding-box;
							border: 1px solid #ced4da;
							border-radius: .25rem;
							box-shadow: inset 0 0 0 transparent;
						transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center">
                        </td>
                    </tr>
					<tr>
						<td colspan="4" style="color:blue;font-weight: bold;text-align: right;font-size:20px">ADD REFER:</td>
						<td><input type="text" name="refer_cash_amount[{{ $data->id }}]" class="currency-default" value="0" style="display: block;
							width: 100%;
							height: calc(2.25rem + 2px);
							padding: .375rem .75rem;
							font-size: 1rem;
							font-weight: 400;
							line-height: 1.5;
							color: #495057;
							background-color: #fff;
							background-clip: padding-box;
							border: 1px solid #ced4da;
							border-radius: .25rem;
							box-shadow: inset 0 0 0 transparent;
						transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center"></td>
						<td><input type="text" name="refer_check_amount[{{ $data->id }}]" class="currency-default" value="0" style="display: block;
							width: 100%;
							height: calc(2.25rem + 2px);
							padding: .375rem .75rem;
							font-size: 1rem;
							font-weight: 400;
							line-height: 1.5;
							color: #495057;
							background-color: #fff;
							background-clip: padding-box;
							border: 1px solid #ced4da;
							border-radius: .25rem;
							box-shadow: inset 0 0 0 transparent;
						transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center"></td>
						<td>
							<input type="text" placeholder="Check #" name="refer_check_number[{{ $data->id }}]" class="form-control"><br />
							<input type="date" name="refer_check_date[{{ $data->id }}]" class="form-control">
						</td>
						<td><input type="text" name="refer_remarks[{{ $data->id }}]" class="form-control"></td>
						<td></td>
					</tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
</form>
<script type="text/javascript">
    $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({
        decimal: '_',
        thousands: '*'
    });
    $('[class=integer-default]').maskNumber({
        integer: true
    });
    $('[class=integer-data-attribute]').maskNumber({
        integer: true
    });
    $('[class=integer-configuration]').maskNumber({
        integer: true,
        thousands: '_'
    });

    $("#example1").DataTable();
    $('#example2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });

    $("#customer_payment_generate_summary").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $.ajax({
            url: "customer_payment_generate_summary",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);

                if (data == 'no_collection') {
                    Swal.fire(
                        'NO COLLECTION INPUT',
                        'CANNOT PROCEED',
                        'error'
                    )
                    $('.loading').hide();
                } else {
                    $('.loading').hide();
                    $('#customer_payment_generate_summary_page').html(data);
                }
            },
        });
    }));
</script>
