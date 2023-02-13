@extends('layouts.master')
@section('navbar')
@section('sidebar')
@section('content')



    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">ADD NEW SKU CATEGORY</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <form action="{{ route('new_categories_process') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('success'))
                                <div class="alert alert-success border-left-success alert-dismissible fade show"
                                    role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger border-left-danger alert-dismissible fade show"
                                    role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="">Principal</label>
                            <select name="principal_id" class="form-control select2bs4" style="width:100%;" required>
                                <option value="" default>Select</option>
                                @foreach ($principal as $data)
                                    <option value="{{ $data->id }}">{{ $data->principal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Category:</label>
                            <input type="text" class="form-control" required name="category" autofocus>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-sm float-right">Submit New Category</button>
                </div>
            </form>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->



        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">Principal Category List</h3>
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
                <table id="example2" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th>ID #</th>
                            <th>Principal</th>
                            <th>Category</th>
                            <th>Edit Category</th>
                            <th>Sub Category</th>
                            <th>Sub Category List</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->principal->principal }}</td>
                                <td>{{ $category->category }}</td>
                                <td>
                                    
                                    <button type="button" class="btn btn-sm btn-block btn-dark" data-toggle="modal"
                                        data-target="#exampleModal{{ $category->id }}">
                                        <i class="bi bi-pencil-square"></i> EDIT
                                    </button>
                                    
                                    <div class="modal fade" id="exampleModal{{ $category->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">EDIT MAIN CATEGORY
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('new_principal_categories_update', $category->id) }}"
                                                    method="POST">
                                                    
                                                    @csrf
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label>Edit Category Name:</label>
                                                            <input type="text" class="form-control" required
                                                                name="editCategory" value="{{ $category->category }}">
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-sm btn-success">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    
                                    <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal"
                                        data-target="#exampleModaladdsubcategory{{ $category->id }}">
                                        <i class="bi bi-plus-square"></i> SUB CATEGORY
                                    </button>

                                    
                                    <div class="modal fade" id="exampleModaladdsubcategory{{ $category->id }}"
                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">SUB CATEGORY</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('sku_category_add_sub_category') }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <label for="">Sub Category</label>
                                                        <input type="text" class="form-control" required
                                                            name="sub_category">
                                                        <input type="hidden" name="category_id"
                                                            value="{{ $category->id }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-sm btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    
                                    <button type="button" class="btn btn-info btn-sm btn-block" data-toggle="modal"
                                        data-target="#exampleModal">
                                        <i class="bi bi-eye-fill"></i> View
                                    </button>

                                    
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        {{ $category->category }} Sub Categories</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-hover table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Sub Category</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($category->sub_category as $details)
                                                                <tr>
                                                                    <td>{{ $details->id }}</td>
                                                                    <td>{{ $details->sub_category }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-dismiss="modal">Close</button>
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
            <!--  /.card-footer-->
        </div>

    </section>

@endsection
@section('footer')
    @parent

    </body>

    </html>
@endsection
