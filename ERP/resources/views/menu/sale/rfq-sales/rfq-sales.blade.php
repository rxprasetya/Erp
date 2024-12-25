@extends('template.template') @section('title', 'Request For Quotation Sale') @section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary mb-2 mr-2" href="{{ route('create-rfq-sales') }}">Create</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Request For Quotation Sale</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rfqSales as $idx => $row)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $row->rfqSaleCode }}</td>
                                    <td>{{ $row->customer->customerName }}</td>
                                    <td>Rp{{ $row->total }}</td>
                                    <td>
                                        <span
                                            class="p-1 rounded {{ $row->rfqSaleStatus == 'Request' ? 'bg-warning' : ($row->rfqSaleStatus == 'Deliver' ? 'bg-primary' : 'bg-success') }}">{{ $row->rfqSaleStatus }}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-info"
                                            href="rfq-sales/preview-rfq-sales?rfqSaleCode={{ $row->rfqSaleCode }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-success"
                                            href="rfq-sales/update-rfq-sales?rfqSaleCode={{ $row->rfqSaleCode }}"
                                            {{ $row->rfqSaleStatus != 'Request' ? 'hidden' : '' }}>
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger"
                                            href="rfq-sales/delete-rfq-sales?rfqSaleCode={{ $row->rfqSaleCode }}"
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
