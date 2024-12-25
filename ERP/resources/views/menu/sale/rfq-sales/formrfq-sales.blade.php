@extends('template.template') @section('title', 'Form Request For Quotation Sale') @section('content')

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
                        <a href="{{ route('rfq-sales') }}">Data RFQ Sale</a>
                        {{-- <a href="{{ route('rfq-sales') }}">{{ request()->route()->getName() }}</a> --}}
                    </li>
                    <li class="breadcrumb-item">
                        {{ request()->routeIs('create-rfq-sales') ? 'Create RFQ Sale' : (request()->routeIs('edit-rfq-sales') ? 'Update RFQ Sale' : 'Preview RFQ Sale') }}
                    </li>
                </ol>
            </div>
        </div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ request()->routeIs('create-rfq-sales') ? 'Create RFQ Sale' : $rfqSale->rfqSaleCode }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ request()->routeIs('create-rfq-sales')
                    ? route('insert-rfq-sales')
                    : (request()->routeIs('edit-rfq-sales')
                        ? '/rfq-sales/update-rfq-sales' . '?rfqSaleCode=' . $rfqSale->rfqSaleCode
                        : (request()->routeIs('preview-rfq-sales') && $rfqSale->rfqSaleStatus == 'Request'
                            ? '/rfq-sales/deliver-rfq-sales' . '?rfqSaleCode=' . $rfqSale->rfqSaleCode
                            : '/rfq-sales/confirm-rfq-sales' . '?rfqSaleCode=' . $rfqSale->rfqSaleCode)) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="customerID">Customer</label>
                        <select class="form-control" name="customerID" id="customerID"
                            {{ request()->routeIs('preview-rfq-sales-sales') ? 'readonly' : '' }}>
                            <option value="" hidden>
                                -- Choose Customer --
                            </option>
                            @foreach ($customers as $row)
                                <option value="{{ $row->id }}"
                                    {{ request()->routeIs('create-rfq-sales') ? '' : ($row->id == $rfqSale->customerID ? 'selected' : '') }}>
                                    {{ $row->customerName }}</option>
                            @endforeach
                        </select>
                        @error('customerID')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="saleDate">Sale Date</label>
                        <input type="date" class="form-control" name="saleDate" id="saleDate"
                            value="{{ request()->routeIs('create-rfq-sales') ? $date : $rfqSale->saleDate }}"
                            {{ request()->routeIs('preview-rfq-sales-sales') ? 'readonly' : '' }} />
                        @error('saleDate')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div id="dynamic-form">
                        @if (request()->routeIs('create-rfq-sales'))
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Product</label>
                                        <select name="productID[]" class="form-control productID">
                                            <option value="" hidden>-- Select Product --</option>
                                            @foreach ($products as $row)
                                                <option data-unit="{{ $row->unit }}" value="{{ $row->id }}">
                                                    [{{ $row->productCode }}] {{ $row->productName }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('productID')
                                            <div class="mt-1">
                                                <span class="text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Qty</label>
                                        <input type="number" name="qtySold[]" class="form-control qtySold"
                                            placeholder="0">
                                        @error('qtySold')
                                            <div class="mt-1">
                                                <span class="text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Price</label>
                                        <input type="number" name="priceSale[]" class="form-control priceSale"
                                            placeholder="0">
                                        @error('priceSale')
                                            <div class="mt-1">
                                                <span class="text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Total</label>
                                        <input type="number" name="totalSold[]" class="form-control totalSold"
                                            placeholder="0" readonly>
                                        @error('totalSold')
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
                            @foreach ($rfqSales as $sale)
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Product</label>
                                            <select name="productID[]" class="form-control productID"
                                                {{ request()->routeIs('preview-rfq-sales') ? 'readonly' : '' }}>
                                                <option value="" hidden>-- Select Product --</option>
                                                @foreach ($products as $row)
                                                    <option data-unit="{{ $row->unit }}"
                                                        value="{{ $row->id }}"
                                                        {{ $row->id == $sale->productID ? 'selected' : '' }}>
                                                        [{{ $row->productCode }}] {{ $row->productName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('productID')
                                                <div class="mt-1">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Qty</label>
                                            <input type="number" name="qtySold[]" class="form-control qtySold"
                                                placeholder="0" value="{{ $sale->qtySold }}"
                                                {{ request()->routeIs('preview-rfq-sales') ? 'readonly' : '' }}>
                                            @error('qtySold')
                                                <div class="mt-1">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Price</label>
                                            <input type="number" name="priceSale[]" class="form-control priceSale"
                                                placeholder="0" value="{{ $sale->priceSale }}"
                                                {{ request()->routeIs('preview-rfq-sales') ? 'readonly' : '' }}>
                                            @error('priceSale')
                                                <div class="mt-1">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Total</label>
                                            <input type="number" name="totalSold[]" class="form-control totalSold"
                                                placeholder="0" value="{{ $sale->totalSold }}" readonly>
                                            @error('totalSold')
                                                <div class="mt-1">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 align-self-end"
                                            {{ request()->routeIs('preview-rfq-sales') ? 'hidden' : '' }}>
                                            <a class="btn btn-success btn-tambah"><i class="fa fa-plus"></i></a>
                                            <a class="btn btn-danger btn-hapus"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (
                                (request()->routeIs('preview-rfq-sales') && $rfqSale->rfqSaleStatus == 'Deliver') ||
                                    $rfqSale->rfqSaleStatus == 'Done')
                                <span class="text-bold text-lg">Total: </span>
                                <span class="text-bold text-lg">
                                    Rp{{ $rfqSales->sum('totalSold') }}
                                    <span
                                        class="ml-2 p-1 px-3 text-md rounded {{ request()->routeIs('preview-rfq-sales') && $rfqSale->rfqSaleStatus == 'Done' ? 'bg-success' : 'bg-danger' }}">
                                        {{ request()->routeIs('preview-rfq-sales') && $rfqSale->rfqSaleStatus == 'Done' ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </span>
                            @endif
                        @endif
                    </div>
                    <div class="card-footer bg-white float-right">
                        <button type="submit"
                            class="{{ request()->routeIs('create-rfq-sales') || request()->routeIs('edit-rfq-sales') || (request()->routeIs('preview-rfq-sales') && $rfqSale->rfqSaleStatus == 'Request') ? 'btn btn-primary' : 'btn btn-default' }}"
                            {{ request()->routeIs('create-rfq-sales') || request()->routeIs('edit-rfq-sales') || (request()->routeIs('preview-rfq-sales') && $rfqSale->rfqSaleStatus == 'Request') ? '' : 'disabled' }}>
                            {{ request()->routeIs('preview-rfq-sales') ? 'Deliver' : 'Submit' }}
                        </button>
                        <button type="{{ request()->routeIs('preview-rfq-sales') ? 'submit' : 'reset' }}"
                            class="{{ request()->routeIs('preview-rfq-sales') && $rfqSale->rfqSaleStatus == 'Deliver' ? 'btn btn-primary' : 'btn btn-default' }}"
                            {{ request()->routeIs('create-rfq-sales') || request()->routeIs('edit-rfq-sales') || (request()->routeIs('preview-rfq-sales') && $rfqSale->rfqSaleStatus == 'Deliver') ? '' : 'disabled' }}>
                            {{ request()->routeIs('preview-rfq-sales') ? 'Register Payment' : 'Cancel' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
