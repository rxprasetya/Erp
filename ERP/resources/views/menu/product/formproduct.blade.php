@extends('template.template') @section('title', 'Form Product') @section('content')

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
                        <a href="{{ route('product') }}">Data Product</a>
                    </li>
                    <li class="breadcrumb-item">{{ request()->routeIs('create-product') ? 'Create Product' : 'Update Product' }}</li>
                </ol>
            </div>
        </div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ request()->routeIs('create-product') ? 'Create Product' : 'Update Product' }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ request()->routeIs('create-product') ? route('insert-product') : route('update-product', $products->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="productCode">Code</label>
                        <input type="text" class="form-control" name="productCode" id="productCode"
                            placeholder="Enter Product Code"
                            value="{{ request()->routeIs('create-product') ? '' : $products->productCode }}" />
                        @error('productCode')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="productName">Name</label>
                        <input type="text" class="form-control" name="productName" id="productName"
                            placeholder="Enter Product Name"
                            value="{{ request()->routeIs('create-product') ? '' : $products->productName }}" />
                        @error('productName')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="productImage">Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="productImage" id="productImage" />
                                <label class="custom-file-label" for="productImage">Choose file</label>
                            </div>
                            @error('productImage')
                                <div class="mt-1">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer bg-white float-right">
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
