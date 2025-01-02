@extends('template.template') @section('title', 'Dashboard') @section('content')
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="logo-ticketin" height="60" width="60" />
    </div>
    <!-- Content Wrapper. Contains page content -->
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $products }}</h3>
                        <p>Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-coffee"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $materials }}</h3>
                        <p>Materials</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-buffer"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 class="text-white">{{ $purchases }}</h3>
                        <p class="text-white">Purchases</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-cart"></i>
                    </div>
                    <a href="" class="small-box-footer"><span class="text-white">More info
                            <i class="fas fa-arrow-circle-right"></i></span></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $sales }}</h3>
                        <p>Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-cart"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Admin Dashboard</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            Welcome Admin, let's start creating your amazing application!
        </div>
        <!-- /.card-body -->
        <div class="card-footer">AdminLTE</div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->
@endsection