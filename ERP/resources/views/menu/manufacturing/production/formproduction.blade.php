@extends('template.template') @section('title', 'Form Production Order') @section('content')
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
                        <a href="{{ route('production') }}">Data Production Order</a>
                    </li>
                    <li class="breadcrumb-item">
                        {{ request()->routeIs('create-production') ? 'Create Production' : (request()->routeIs('edit-production') ? 'Update Production' : 'Preview Production') }}
                    </li>
                </ol>
            </div>
        </div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ request()->routeIs('create-production') ? 'Create Production Order' : $production->productionCode }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ request()->routeIs('create-production')
                    ? route('insert-production')
                    : (request()->routeIs('edit-production')
                        ? '/production/update-production' . '?productionCode=' . $production->productionCode
                        : (request()->routeIs('preview-production') && $production->productionStatus == 'Request'
                            ? '/production/validate-production' . '?productionCode=' . $production->productionCode
                            : '/production/confirm-production' . '?productionCode=' . $production->productionCode)) }} "
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="bomID">Product</label>
                                <select name="bomID[]" id="bomID" class="form-control"
                                    {{ request()->routeIs('preview-production') ? 'readonly' : '' }}>
                                    <option value="" hidden>-- Select Product --</option>
                                    @foreach ($boms as $row)
                                        <option value="{{ $row->bomCode }}"
                                            {{ request()->routeIs('edit-production') || (request()->routeIs('preview-production') && $row->productID == $production->bom->productID) ? 'selected' : '' }}>
                                            [{{ $row->product->productCode }}]
                                            {{ $row->product->productName }}</option>
                                    @endforeach
                                </select>
                                @error('bomID')
                                    <div class="mt-1">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="qtyProduction">Qty to Product</label>
                                <input type="number" class="form-control" name="qtyProduction" id="qtyProduction"
                                    placeholder="0"
                                    value="{{ request()->routeIs('create-production') ? '' : $production->qtyProduction }}"
                                    {{ request()->routeIs('preview-production') ? 'readonly' : '' }} />
                                @error('qtyProduction')
                                    <div class="mt-1">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="productionDate">Production Date</label>
                                <input type="date" class="form-control" name="productionDate" id="productionDate"
                                    value="{{ request()->routeIs('create-production') ? $date : $production->productionDate }}"
                                    {{ request()->routeIs('preview-production') ? 'readonly' : '' }} />
                                @error('productionDate')
                                    <div class="mt-1">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group materials">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="materialName">Material</label>
                                <input class="form-control" type="text" name="materialName[]" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="toConsume">To Consume</label>
                                <input class="form-control" type="number" name="toConsume[]" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="reserved">Reserved</label>
                                <input class="form-control" type="number" name="reserved[]" readonly>
                            </div>
                            @if (request()->routeIs('preview-production') && $production->productionStatus == 'Done')
                                <div class="col-sm-2">
                                    <label for="consumed">Consumed</label>
                                    <input class="form-control" type="number" name="consumed[]" readonly>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-white float-right">
                        <{{ request()->routeIs('preview-production') && $production->productionStatus == 'Request' ? 'a' : 'button type=submit' }}
                            class="btn btn-primary"
                            {{ request()->routeIs('preview-production') && $production->productionStatus == 'Request' ? 'id=check' : '' }}
                            {{ request()->routeIs('preview-production') && $production->productionStatus == 'Done' ? 'hidden' : '' }}>
                            <span class="text-light">
                                {{ request()->routeIs('preview-production') && $production->productionStatus == 'Request' ? 'Check for Available' : (request()->routeIs('preview-production') && $production->productionStatus == 'Manufacturing Order' ? 'Done' : 'Submit') }}
                            </span>
                            </{{ request()->routeIs('preview-production') && $production->productionStatus == 'Request' ? 'a' : 'button' }}>
                            <button
                                type="{{ request()->routeIs('preview-production') && $production->productionStatus == 'Request' ? 'submit' : 'reset' }}"
                                class="btn btn-default"
                                {{ request()->routeIs('preview-production') && $production->productionStatus == 'Request' ? 'disabled' : '' }}
                                {{ (request()->routeIs('preview-production') && $production->productionStatus == 'Done') || (request()->routeIs('preview-production') && $production->productionStatus == 'Manufacturing Order') ? 'hidden' : '' }}>
                                {{ request()->routeIs('preview-production') && $production->productionStatus == 'Request' ? 'Confirm' : 'Cancel' }}
                            </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
