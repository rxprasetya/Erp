@extends('template.template') @section('title', 'Data Vendors') @section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary mb-2 mr-2" href="{{ route('create-vendor') }}">Create</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vendors DataTable</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $idx => $row)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->mobile }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route('edit-vendor', $row->id) }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger" href="{{ route('delete-vendor', $row->id) }}">
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
