@extends('layouts.master')

@section('title', 'LOGISTIC UPDATE DR STATUS')

@section('navbar')


@section('sidebar')


@section('content')

    <br />
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">LOGISTIC UPDATE DR STATUS</h3>

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
                <form id="dr_update_status_generate">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Select DR:</label>
                                <select name="sales_invoice_id[]" style="width:100%;" class="form-control select2" multiple required>
                                    @foreach ($sales_invoice as $data)
                                        <option value="{{ $data->id }}">{{ $data->delivery_receipt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <br />
                                <button type="submit" class="btn btn-info btn-block">Proceed</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="dr_update_status_generate_page"></div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">Summary</h3>

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
                <div id="dr_update_status_generate_final_summary_page"></div>
            </div>
            <!-- /.card-body -->
    
        </div>

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

        $('#select-all').click(function(event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });

        $('#example3').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });

        $("#dr_update_status_generate").on('submit', (function(e) {
            e.preventDefault();
            //$('.loading').show();
            // $('#sales_order_migrate_summary_page').show();
            $.ajax({
                url: "dr_update_status_generate",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                   $('#dr_update_status_generate_page').html(data);
                },
            });
        }));
    </script>
    </body>

    </html>
@endsection
