@extends('template.template') @section('title', 'Data Products') @section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary mb-2 mr-2" href="{{ route('create-product') }}">Create</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Products DataTable</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $idx => $row)    
                            <tr>
                                <td>{{ $idx+1 }}</td>
                                <td>[{{ $row->productCode  }}] {{ $row->productName }}</td>
                                <td>{{ $row->productStock }}</td>
                                <td>
                                    <img class="img-fluid" src="{{ $row->productImage }}" alt="{{ $row->productName }}.jpg" width="30" />
                                </td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('edit-product', $row->id) }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger" href="{{ route('delete-product', $row->id) }}" id="delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>

@endsection
