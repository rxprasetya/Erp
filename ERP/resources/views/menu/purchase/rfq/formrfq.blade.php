@extends('template.template') @section('title', 'Form Request For Quotation Order') @section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6 mb-2">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('rfq') }}">Data RFQ Order</a>
                    </li>
                    <li class="breadcrumb-item">
                        {{ request()->routeIs('create-rfq') ? 'Create RFQ Order' : (request()->routeIs('edit-rfq') ? 'Update RFQ Order' : 'Preview RFQ Order') }}
                    </li>
                </ol>
            </div>
        </div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ request()->routeIs('create-rfq') ? 'Create RFQ Order' : $rfq->rfqCode }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ request()->routeIs('create-rfq')
                    ? route('insert-rfq')
                    : (request()->routeIs('edit-rfq')
                        ? '/rfq/update-rfq' . '?rfqCode=' . $rfq->rfqCode
                        : (request()->routeIs('preview-rfq') && $rfq->rfqStatus == 'Request'
                            ? '/rfq/validate-rfq' . '?rfqCode=' . $rfq->rfqCode
                            : '/rfq/confirm-rfq' . '?rfqCode=' . $rfq->rfqCode)) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="vendorID">Vendor</label>
                        <select class="form-control" name="vendorID" id="vendorID"
                            {{ request()->routeIs('preview-rfq') ? 'readonly' : '' }}>
                            <option value="" hidden>
                                -- Choose Item --
                            </option>
                            @foreach ($vendors as $row)
                                <option value="{{ $row->id }}"
                                    {{ request()->routeIs('create-rfq') ? '' : ($row->id == $rfq->vendorID ? 'selected' : '') }}>
                                    {{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('vendorID')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="orderDate">Order Date</label>
                        <input type="date" class="form-control" name="orderDate" id="orderDate"
                            value="{{ request()->routeIs('create-rfq') ? $date : $rfq->orderDate }}"
                            {{ request()->routeIs('preview-rfq') ? 'readonly' : '' }} />
                        @error('orderDate')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div id="dynamic-form">
                        @if (request()->routeIs('create-rfq'))
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Material</label>
                                        <select name="materialID[]" class="form-control materialID">
                                            <option value="" hidden>-- Select Material --</option>
                                            @foreach ($materials as $row)
                                                <option data-unit="{{ $row->unit }}" value="{{ $row->id }}">
                                                    [{{ $row->materialCode }}] {{ $row->materialName }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('materialID')
                                            <div class="mt-1">
                                                <span class="text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Qty</label>
                                        <div class="input-group">
                                            <input type="number" name="qtyOrder[]" class="form-control qtyOrder"
                                                placeholder="0">
                                            <span class="input-group-text unitText">-</span>
                                        </div>
                                        @error('qtyOrder')
                                            <div class="mt-1">
                                                <span class="text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Price</label>
                                        <input type="number" name="priceOrder[]" class="form-control priceOrder"
                                            placeholder="0">
                                        @error('priceOrder')
                                            <div class="mt-1">
                                                <span class="text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Total</label>
                                        <input type="number" name="totalOrder[]" class="form-control totalOrder"
                                            placeholder="0" readonly>
                                        @error('totalOrder')
                                            <div class="mt-1">
                                                <span class="text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2 align-self-end">
                                        <a class="btn btn-success btn-tambah"><i class="fa fa-plus"></i></a>
                                        <a class="btn btn-danger btn-hapus"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach ($rfqs as $order)
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Material</label>
                                            <select name="materialID[]" class="form-control materialID"
                                                {{ request()->routeIs('preview-rfq') ? 'readonly' : '' }}>
                                                <option value="" hidden>-- Select Material --</option>
                                                @foreach ($materials as $row)
                                                    <option data-unit="{{ $row->unit }}"
                                                        value="{{ $row->id }}"
                                                        {{ $row->id == $order->materialID ? 'selected' : '' }}>
                                                        [{{ $row->materialCode }}] {{ $row->materialName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('materialID')
                                                <div class="mt-1">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Qty</label>
                                            <div class="input-group">
                                                <input type="number" name="qtyOrder[]" class="form-control qtyOrder"
                                                    placeholder="0" value="{{ $order->qtyOrder }}"
                                                    {{ request()->routeIs('preview-rfq') ? 'readonly' : '' }}>
                                                <span class="input-group-text unitText">-</span>
                                            </div>
                                            @error('qtyOrder')
                                                <div class="mt-1">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Price</label>
                                            <input type="number" name="priceOrder[]" class="form-control priceOrder"
                                                placeholder="0" value="{{ $order->priceOrder }}"
                                                {{ request()->routeIs('preview-rfq') ? 'readonly' : '' }}>
                                            @error('priceOrder')
                                                <div class="mt-1">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Total</label>
                                            <input type="number" name="totalOrder[]" class="form-control totalOrder"
                                                placeholder="0" value="{{ $order->totalOrder }}"
                                                readonly>
                                            @error('totalOrder')
                                                <div class="mt-1">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 align-self-end"
                                            {{ request()->routeIs('preview-rfq') ? 'hidden' : '' }}>
                                            <a class="btn btn-success btn-tambah"><i class="fa fa-plus"></i></a>
                                            <a class="btn btn-danger btn-hapus"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (request()->routeIs('preview-rfq'))
                                <span class="text-bold text-lg">Total: </span>
                                <span class="text-bold text-lg">
                                    Rp{{ $rfqs->sum('totalOrder') }}
                                    <span
                                        class="ml-2 p-1 px-3 text-md rounded {{ request()->routeIs('preview-rfq') && $rfq->rfqStatus == 'Done' ? 'bg-success' : 'bg-danger' }}">
                                        {{ request()->routeIs('preview-rfq') && $rfq->rfqStatus == 'Done' ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </span>
                            @endif
                        @endif
                    </div>
                    <div class="card-footer bg-white float-right">
                        <button type="submit"
                            class="{{ request()->routeIs('create-rfq') || request()->routeIs('edit-rfq') || (request()->routeIs('preview-rfq') && $rfq->rfqStatus == 'Request') ? 'btn btn-primary' : 'btn btn-default' }}"
                            {{ request()->routeIs('create-rfq') || request()->routeIs('edit-rfq') || (request()->routeIs('preview-rfq') && $rfq->rfqStatus == 'Request') ? '' : 'disabled' }}>
                            {{ request()->routeIs('preview-rfq') ? 'Validate' : 'Submit' }}
                        </button>
                        <button type="{{ request()->routeIs('preview-rfq') ? 'submit' : 'reset' }}"
                            class="{{ request()->routeIs('preview-rfq') && $rfq->rfqStatus == 'Purchase Order' ? 'btn btn-primary' : 'btn btn-default' }}"
                            {{ request()->routeIs('create-rfq') || request()->routeIs('edit-rfq') || (request()->routeIs('preview-rfq') && $rfq->rfqStatus == 'Purchase Order') ? '' : 'disabled' }}>
                            {{ request()->routeIs('preview-rfq') ? 'Confirm' : 'Cancel' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
