@extends('layouts.master')

@section('title', 'Receive Order')

@section('navbar')


@section('sidebar')


@section('content')

    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">RECEIVING SECTION(DRAFT)</h3>
            </div>
            <div class="card-body">
                <form id="receiving_draft_proceed">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Principal</label>
                            <select name="principal_id" class="form-control" required>
                                <option value="" default>Select</option>
                                @foreach ($principal as $data)
                                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Scan Barcode</label>
                            <input type="text" class="form-control" required name="barcode" id="barcode">

                            <input type="hidden" name="session_id" value="{{ $session_id }}">
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="show_draft"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        {{-- <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">DATA SUMMARY</h3>
            </div>
            <div class="card-body">
                <div id="show_data_final_summary"></div>
            </div>
        </div> --}}
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


        $("#receiving_draft_proceed").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            $.ajax({
                url: "receiving_draft_proceed",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('#barcode').val('');
                    if (data == 'wrong_sku') {
                        Swal.fire(
                            'kani nga sku wala ani nga principal',
                            'You clicked the button!',
                            'error'
                        )
                    } else if (data == 'existing') {
                        Swal.fire(
                            'Existing',
                            'You clicked the button!',
                            'error'
                        )
                    } else {
                        $('#show_draft').html(data);
                    }
                },
            });
        }));
    </script>

    </body>

    </html>
@endsection
