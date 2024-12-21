@extends('template.template') @section('title', 'Bills of Materials') @section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary mb-2 mr-2" href="{{ route('create-bom') }}">Create</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bills of Materials</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Reference</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($boms as $idx => $row)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $row->bomCode }}</td>
                                    <td>[{{ $row->product->productCode }}] {{ $row->product->productName }}</td>
                                    <td>Rp{{ $row->price*1.1 }}</td>
                                    <td>
                                        <a class="btn btn-info" href="bom/preview-bom?bomCode={{ $row->bomCode }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-success" href="bom/update-bom?bomCode={{ $row->bomCode }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger" href="bom/delete-bom?bomCode={{ $row->bomCode }}" id="delete">
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