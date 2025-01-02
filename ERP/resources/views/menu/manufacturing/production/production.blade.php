@extends('template.template') @section('title', 'Production Order') @section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary mb-2 mr-2" href="{{ route('create-production') }}">Create</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Production Order</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Reference</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Production Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productions as $idx => $row)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $row->productionCode }}</td>
                                    <td>[{{ $row->productCode }}] {{ $row->productName }}</td>
                                    <td>{{ $row->qtyProduction }}</td>
                                    <td>{{ $row->productionDate }}</td>
                                    <td>
                                        <span
                                            class="p-1 rounded {{ $row->productionStatus == 'Request' ? 'bg-warning' : ($row->productionStatus == 'Manufacturing Order' ? 'bg-primary' : 'bg-success') }}">{{ $row->productionStatus }}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-info"
                                            href="production/preview-production?productionCode={{ $row->productionCode }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-success"
                                            href="production/update-production?productionCode={{ $row->productionCode }}"
                                            {{ $row->productionStatus != 'Request' ? 'hidden' : '' }}>
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger"
                                            href="production/delete-production?productionCode={{ $row->productionCode }}"
                                            id="delete">
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
