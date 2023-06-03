@extends('layouts.master')
@section('title', 'Receive Order')
@section('navbar')
@section('sidebar')
@section('content')

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">RECEIVING SECTION(DRAFT)</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Purchase Order/Van #</label>
                        <select name="purchase_id" class="form-control select2bs4" style="width:100%;" id="purchase_id"
                            required>
                            <option value="" default>Select</option>
                            @foreach ($purchase_order as $data)
                                <option value="{{ $data->id }}">
                                    VAN # - {{ strtoupper($data->van_number) }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="session_id" value="{{ $session_id }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div id="show_sku_selection"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">SUMMARY</h3>
            </div>
            <div class="card-body">
                <div id="show_draft"></div>
            </div>
        </div>
    </section>

@endsection
@section('footer')
    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#purchase_id").change(function() {
            purchase_id = $(this).val();
            $.post({
                type: "POST",
                url: "/receiving_draft_sku_selection",
                data: 'purchase_id=' + purchase_id,
                success: function(data) {
                    $('#loader').hide();
                    $('#show_sku_selection').html(data);
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
        });
    </script>

    </body>

    </html>
@endsection
