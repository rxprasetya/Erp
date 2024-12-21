@extends('template.template') @section('title', 'Request For Quotation Order') @section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary mb-2 mr-2" href="{{ route('create-rfq') }}">Create</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Request For Quotation Order</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Reference</th>
                                <th>Vendor</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rfqs as $idx => $row)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $row->rfqCode }}</td>
                                    <td>{{ $row->vendor->name }}</td>
                                    <td>Rp{{ $row->total }}</td>
                                    <td>
                                        <span class="p-1 rounded {{ $row->rfqStatus == 'Request' ? 'bg-warning' : ($row->rfqStatus == 'Purchase Order' ? 'bg-primary' : 'bg-success') }}">{{ $row->rfqStatus }}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-info" href="rfq/preview-rfq?rfqCode={{ $row->rfqCode }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-success" href="rfq/update-rfq?rfqCode={{ $row->rfqCode }}" {{ $row->rfqStatus != 'Request' ? 'hidden' : '' }}>
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger" href="rfq/delete-rfq?rfqCode={{ $row->rfqCode }}" id="delete">
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
