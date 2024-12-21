@extends('template.template') @section('title', 'Data Materials') @section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary mb-2 mr-2" href="{{ route('create-material') }}">Create</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Materials DataTable</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Cost</th>
                                <th>Stock</th>
                                <th>Unit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $idx => $row)
                                <tr>
                                    <td>{{ $idx+1 }}</td>
                                    <td>[{{ $row->materialCode }}] {{ $row->materialName }}</td>
                                    <td>{{ $row->materialCost }}</td>
                                    <td>{{ $row->materialStock }}</td> 
                                    <td>{{ $row->unit }}</td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route('edit-material', $row->id) }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger" href="{{ route('delete-material', $row->id) }}" id="delete">
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
