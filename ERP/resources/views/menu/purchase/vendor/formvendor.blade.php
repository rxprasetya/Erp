@extends('template.template') @section('title', 'Form Vendor') @section('content')

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
                        <a href="{{ route('vendor') }}">Data Vendors</a>
                    </li>
                    <li class="breadcrumb-item">
                        {{ request()->routeIs('create-vendor') ? 'Create Vendor' : 'Update Vendor' }}</li>
                </ol>
            </div>
        </div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ request()->routeIs('create-vendor') ? 'Create Vendor' : 'Update Vendor' }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ request()->routeIs('create-vendor') ? route('insert-vendor') : route('update-vendor', $vendors->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Enter Name"
                            value="{{ request()->routeIs('create-vendor') ? '' : $vendors->name }}" />
                        @error('name')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email"
                            placeholder="Enter Email"
                            value="{{ request()->routeIs('create-vendor') ? '' : $vendors->email }}" />
                        @error('email')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="mobile">Phone</label>
                        <input type="text" class="form-control" name="mobile" id="mobile"
                            placeholder="Enter Phone Number"
                            value="{{ request()->routeIs('create-vendor') ? '' : $vendors->mobile }}" />
                        @error('mobile')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter Address">{{ request()->routeIs('create-vendor') ? '' : $vendors->address }}</textarea>
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
