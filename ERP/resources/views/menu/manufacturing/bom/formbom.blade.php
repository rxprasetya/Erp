@extends('template.template') @section('title', 'Form Bills of Materials') @section('content')
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
                        <a href="{{ route('bom') }}">Data BoM</a>
                    </li>
                    <li class="breadcrumb-item">{{ request()->routeIs('create-bom') ? 'Create BoM' : (request()->routeIs('edit-bom') ? 'Update BoM' : 'Preview BoM') }}
                    </li>
                </ol>
            </div>
        </div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ request()->routeIs('create-bom') ? 'Create Bills of Materials' : $bom->bomCode }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ request()->routeIs('create-bom') ? route('insert-bom') : '/bom/update-bom' . '?bomCode=' . $bom->bomCode }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="productID">Product</label>
                                <select name="productID" id="productID" class="form-control"
                                    {{ request()->routeIs('preview-bom') ? 'readonly' : '' }}>
                                    <option value="" hidden>-- Select Product --</option>
                                    @foreach ($products as $row)
                                        <option value="{{ $row->id }}"
                                            {{ request()->routeIs('create-bom') ? '' : ($row->id == $bom->productID ? 'selected' : '') }}>
                                            [{{ $row->productCode }}]
                                            {{ $row->productName }}</option>
                                    @endforeach
                                </select>
                                @error('productID')
                                    <div class="mt-1">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="dynamic-form">
                        @if (request()->routeIs('create-bom'))
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="materialID">Material</label>
                                        <select name="materialID[]" id="materialID" class="form-control materialID">
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
                                        <label for="qtyMaterial">Qty</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="qtyMaterial[]"
                                                id="qtyMaterial" placeholder="0" />
                                            <span class="input-group-text unitText">-</span>
                                        </div>
                                        @error('qtyMaterial')
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
                            @foreach ($boms as $material)
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="materialID">Material</label>
                                            <select name="materialID[]" id="materialID" class="form-control materialID"
                                                {{ request()->routeIs('preview-bom') ? 'readonly' : '' }}>
                                                <option value="" hidden>-- Select Material --</option>
                                                @foreach ($materials as $row)
                                                    <option data-unit="{{ $row->unit }}"
                                                        value="{{ $row->id }}"
                                                        {{ request()->routeIs('create-bom') ? '' : ($row->id == $material->materialID ? 'selected' : '') }}>
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
                                            <label for="qtyMaterial">Qty</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="qtyMaterial[]"
                                                    id="qtyMaterial" placeholder="0"
                                                    value="{{ request()->routeIs('create-bom') ? '' : $material->qtyMaterial }}"
                                                    {{ request()->routeIs('preview-bom') ? 'readonly' : '' }} />
                                                <span class="input-group-text unitText">-</span>
                                            </div>
                                            @error('qtyMaterial')
                                                <div class="mt-1">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        @if (request()->routeIs('preview-bom'))
                                            <div class="col-sm-2">
                                                <label for="">Product Cost</label>
                                                <input type="text" class="form-control" name="" id=""
                                                    placeholder="0" value="{{ $material->unitPrice }}"
                                                    {{ request()->routeIs('preview-bom') ? 'readonly' : '' }} />
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="">BoM Cost</label>
                                                <input type="text" class="form-control" name="" id=""
                                                    placeholder="0" value="{{ $material->unitPrice }}"
                                                    {{ request()->routeIs('preview-bom') ? 'readonly' : '' }} />
                                            </div>
                                        @endif
                                        <div class="col-sm-2 align-self-end"
                                            {{ request()->routeIs('preview-bom') ? 'hidden' : '' }}>
                                            <a class="btn btn-success btn-tambah"><i class="fa fa-plus"></i></a>
                                            <a class="btn btn-danger btn-hapus"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (request()->routeIs('preview-bom'))
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Unit</label>
                                            <input type="text" class="form-control" name="" id=""
                                                placeholder="0"
                                                value="[{{ $products->where('id', $bom->productID)->first()->productCode }}] {{ $products->where('id', $bom->productID)->first()->productName }}"
                                                {{ request()->routeIs('preview-bom') ? 'readonly' : '' }} />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="">Price</label>
                                            <input type="text" class="form-control" name="" id=""
                                                placeholder="0" value="Rp{{ $boms->sum('unitPrice') * 1.1 }}"
                                                {{ request()->routeIs('preview-bom') ? 'readonly' : '' }} />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="">Product Cost (+10%)</label>
                                            <input type="text" class="form-control" name="" id=""
                                                placeholder="0" value="Rp{{ $boms->sum('unitPrice') * 1.1 }}"
                                                {{ request()->routeIs('preview-bom') ? 'readonly' : '' }} />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="">BoM Cost</label>
                                            <input type="text" class="form-control" name="" id=""
                                                placeholder="0" value="Rp{{ $boms->sum('unitPrice') }}"
                                                {{ request()->routeIs('preview-bom') ? 'readonly' : '' }} />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="card-footer bg-white float-right"
                        {{ request()->routeIs('preview-bom') ? 'hidden' : '' }}>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                        <button type="reset" class="btn btn-default">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
