<table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th style="text-align: center;">CODE</th>
                <th style="text-align: center;">DESCRIPTION</th>
                <th style="text-align: center;">ARQ</th>
                <th style="text-align: center;">CATEGORY</th>
                <th style="text-align: center;">PRINCIPAL</th>
                <th style="text-align: center;">UOM</th>
                <th style="text-align: center;">TYPE</th>
                <th style="text-align: center;">ESE</th>
                <th style="text-align: center;">EBS</th>
                <th style="text-align: center;">ROP</th>
                <th style="text-align: center;">UNIT COST</th>
                <th style="text-align: center;">REMARKS</th>
                <th style="text-align: center;"><i class="fas fa-edit"></i></th>
            </tr>
        </thead>
        <tbody>
            @for ($i=0; $i < $data_counter; $i++) 
                <tr>
                    <td style="text-align: center;">{{ $sku_data[$i]->sku_code }}</td>
                    <td style="text-align: center;">{{ $sku_data[$i]->description }}</td>
                    <td style="text-align: center;">{{ $remaining_quantity[$i] }}</td>
                    <td style="text-align: center;">{{ $sku_data[$i]->skuCategory->category }}</td>
                    <td style="text-align: center;">{{ $sku_data[$i]->skuPrincipal->principal }}</td>
                    <td style="text-align: center;">{{ $sku_data[$i]->unit_of_measurement }}</td>
                    <td style="text-align: center;">{{ $sku_data[$i]->sku_type }}</td>
                    <td style="text-align: center;">{{ $sku_data[$i]->equivalent_sku_entryNo }}</td>
                    <td style="text-align: center;">{{ $sku_data[$i]->equivalent_butal_pcs }}</td>
                    <td style="text-align: center;">{{ $sku_data[$i]->reorder_point }}</td>
                    <td style="text-align: right;text-align: center;">
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $sku_data[$i]->id }}">
                        {{ number_format($sku_data[$i]->sku_price_details_one->unit_cost,2,".",",")  }}
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $sku_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel" style="text-align: center;font-weight: bold;text-transform: uppercase;">{{ $sku_data[$i]->description }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">INVOICE COST</th>
                                                    <th style="text-align: center;">PRICE 1</th>
                                                    <th style="text-align: center;">PRICE 2</th>
                                                    <th style="text-align: center;">PRICE 3</th>
                                                    <th style="text-align: center;">PRICE 4</th>
                                                    <th style="text-align: center;">UPDATED</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                @foreach($sku_data[$i]->sku_price_details as $price_details)
                                                <tr>
                                                     <td>{{ number_format($price_details->unit_cost,2,".",",") }}</td>
                                                    <td>{{ number_format($price_details->price_1,2,".",",") }}</td>
                                                    <td>{{ number_format($price_details->price_2,2,".",",") }}</td>
                                                    <td>{{ number_format($price_details->price_3,2,".",",") }}</td>
                                                    <td>{{ number_format($price_details->price_4,2,".",",") }}</td>
                                                    <td>
                                                        @if(is_null($price_details->created_at))
                                                        MIGRATED
                                                        @else
                                                        {{ $price_details->created_at }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: center;">{{ $sku_data[$i]->remarks }}</td>
                    <td style="text-align: center;">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_sku{{ $sku_data[$i]->id }}">
                        <i class="fas fa-edit"></i>
                        </button>
                        <div class="modal fade" id="update_sku{{ $sku_data[$i]->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-weight: bold;">UPDATE SKU INFORMATION <span style="color:blue;">{{ $sku_data[$i]->sku_type }}</span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('update.sku.post') }}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Sku code:</label>
                                                        <input type="text" name="sku_code" style="text-align: center;" value="{{ $sku_data[$i]->sku_code }}" class="form-control">
                                                        <input type="hidden" name="sku_id" value="{{ $sku_data[$i]->id }}">
                                                        <input type="hidden" name="principal_name" value="{{ $sku_data[$i]->skuPrincipal->principal }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Description:</label>
                                                        <input type="text" name="description" value="{{ $sku_data[$i]->description }}"  class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Category:</label>
                                                        <select name="category_id" class="form-control select2">
                                                            <option value={{ $sku_data[$i]->category_id }} default>{{ $sku_data[$i]->skuCategory->category }}</option>
                                                            @foreach($select_sku_category as $category)
                                                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Principal:</label>
                                                        <select name="principal_id" class="form-control select2">
                                                            <option value={{ $sku_data[$i]->principal_id }} default>{{ $sku_data[$i]->skuPrincipal->principal }}</option>
                                                            @foreach($select_sku_principal as $principal)
                                                            <option value="{{ $principal->id }}">{{ $principal->principal }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>UOM:</label>
                                                        <input type="text" style="text-align: center;" name="unit_of_measurement" value="{{ $sku_data[$i]->unit_of_measurement }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Sku type:</label>
                                                        <select name="sku_type" value="{{ $sku_data[$i]->sku_type }}" class="form-control select2">
                                                            <option value={{ $sku_data[$i]->sku_type }} default>{{ $sku_data[$i]->sku_type }}</option>
                                                            <option value="Case">Case</option>
                                                            <option value="Butal">Butal</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @if($sku_data[$i]->skuPrincipal->principal != 'EPI')
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Equivalent Sku:</label>
                                                        <select name="equivalent_sku_entryNo" class="form-control select2">
                                                            @foreach($select_sku_equivalent as $equivalent)
                                                            <option value={{ $equivalent->id }} default>{{ $equivalent->sku_code ." - ". $equivalent->description ." - ". $equivalent->sku_type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @else
                                                
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submi"t class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>