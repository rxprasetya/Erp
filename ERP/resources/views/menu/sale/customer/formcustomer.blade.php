@extends('template.template') @section('title', 'Form Customer') @section('content')

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
                        <a href="{{ route('customer') }}">Data Customers</a>
                    </li>
                    <li class="breadcrumb-item">
                        {{ request()->routeIs('create-customer') ? 'Create Customer' : 'Update Customer' }}</li>
                </ol>
            </div>
        </div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ request()->routeIs('create-customer') ? 'Create Customer' : 'Update Customer' }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ request()->routeIs('create-customer') ? route('insert-customer') : route('update-customer', $customers->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="customerName">Name</label>
                        <input type="text" class="form-control" name="customerName" id="customerName"
                            placeholder="Enter Name"
                            value="{{ request()->routeIs('create-customer') ? '' : $customers->customerName }}" />
                        @error('customerName')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customerEmail">Email</label>
                        <input type="email" class="form-control" name="customerEmail" id="customerEmail"
                            placeholder="Enter Email"
                            value="{{ request()->routeIs('create-customer') ? '' : $customers->customerEmail }}" />
                        @error('customerEmail')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customerMobile">Phone</label>
                        <input type="text" class="form-control" name="customerMobile" id="customerMobile"
                            placeholder="Enter Phone Number"
                            value="{{ request()->routeIs('create-customer') ? '' : $customers->customerMobile }}" />
                        @error('customerMobile')
                            <div class="mt-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customerAddress">Address</label>
                        <textarea class="form-control" name="customerAddress" id="customerAddress" rows="3" placeholder="Enter Address">{{ request()->routeIs('create-customer') ? '' : $customers->customerAddress }}</textarea>
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
