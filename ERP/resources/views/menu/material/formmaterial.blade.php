@extends('template.template') @section('title', 'Form Material') @section('content')

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
                        <a href="{{ route('material') }}">Data Material</a>
                    </li>
                    <li class="breadcrumb-item">{{ request()->routeIs('create-material') ? 'Create Material' : 'Update Material' }}</li>
                </ol>
            </div>
        </div>
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ request()->routeIs('create-material') ? 'Create Material' : 'Update Material' }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ request()->routeIs('create-material') ? route('insert-material') : route('update-material', $materials->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="materialCode">Code</label>
                        <input type="text" class="form-control" name="materialCode" id="materialCode"
                            placeholder="Enter Material Code"
                            value="{{ request()->routeIs('create-material') ? '' : $materials->materialCode }}" />
                    </div>
                    <div class="form-group">
                        <label for="materialName">Name</label>
                        <input type="text" class="form-control" name="materialName" id="materialName"
                            placeholder="Enter Material Name"
                            value="{{ request()->routeIs('create-material') ? '' : $materials->materialName }}" />
                    </div>
                    <div class="form-group">
                        <label for="materialCost">Cost</label>
                        <input type="number" class="form-control" name="materialCost" id="materialCost"
                            placeholder="Enter Cost"
                            value="{{ request()->routeIs('create-material') ? '' : $materials->materialCost }}" />
                    </div>
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <select class="form-control" name="unit" id="unit">
                            <option value="" hidden>-- Select Unit --</option>
                            <option value="Kg"
                                {{ request()->routeIs('create-material') ? '' : ($materials->unit == 'Kg' ? 'selected' : '') }}>
                                Kg
                            </option>
                            <option value="L"
                                {{ request()->routeIs('create-material') ? '' : ($materials->unit == 'L' ? 'selected' : '') }}>
                                L
                            </option>
                        </select>
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
