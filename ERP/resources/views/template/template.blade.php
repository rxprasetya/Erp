<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="icon" href="{{ asset('dist/img/AdminLTELogo.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.0/dist/sweetalert2.min.css">
</head>

<body class="hold-transition sidebar-mini" data-success-message="{{ session('success') }}"
    data-error-message="{{ session('error') }}">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- /.Navbar Search -->

                <!-- Navbar Fullscreen -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <!-- /.Navbar Fullscreen -->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: 0.8" />
                <span class="brand-text font-weight-light">AdminLTE</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('dist/img/avatar.png') }}" class="img-circle elevation-2"
                            alt="User Image" />
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Admin
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product') }}"
                                class="nav-link {{ request()->routeIs('product', 'create-product', 'edit-product') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('material') }}"
                                class="nav-link {{ request()->routeIs('material', 'create-material', 'edit-material') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Material</p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('bom', 'create-bom', 'edit-bom', 'preview-bom', 'production', 'create-production', 'edit-production', 'preview-production') ? 'menu-is-opening menu-open' : '' }}">
                            <a href=""
                                class="nav-link {{ request()->routeIs('bom', 'create-bom', 'edit-bom', 'preview-bom', 'production', 'create-production', 'edit-production', 'preview-production') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Manufacturing
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('bom') }}"
                                        class="nav-link {{ request()->routeIs('bom', 'create-bom', 'edit-bom', 'preview-bom') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bills Of Materials</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('production') }}"
                                        class="nav-link {{ request()->routeIs('production', 'create-production', 'edit-production', 'preview-production') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Production</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('vendor', 'create-vendor', 'edit-vendor', 'rfq', 'create-rfq', 'edit-rfq', 'preview-rfq') ? 'menu-is-opening menu-open' : '' }}">
                            <a href=""
                                class="nav-link {{ request()->routeIs('vendor', 'create-vendor', 'edit-vendor', 'rfq', 'create-rfq', 'edit-rfq', 'preview-rfq') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cart-plus"></i>
                                <p>
                                    Purchase
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('vendor') }}"
                                        class="nav-link {{ request()->routeIs('vendor', 'create-vendor', 'edit-vendor') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Vendor</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('rfq') }}"
                                        class="nav-link {{ request()->routeIs('rfq', 'create-rfq', 'edit-rfq', 'preview-rfq') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Request For Quotation</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('customer', 'create-customer', 'edit-customer', 'rfq-sales', 'create-rfq-sales', 'edit-rfq-sales', 'preview-rfq-sales') ? 'menu-is-opening menu-open' : '' }}">
                            <a href=""
                                class="nav-link {{ request()->routeIs('customer', 'create-customer', 'edit-customer', 'rfq-sales', 'create-rfq-sales', 'edit-rfq-sales', 'preview-rfq-sales') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-cart-arrow-down"></i>
                                <p>
                                    Sale
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('customer') }}"
                                        class="nav-link {{ request()->routeIs('customer', 'create-customer', 'edit-customer') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Customer</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('rfq-sales') }}" class="nav-link {{ request()->routeIs('rfq-sales', 'create-rfq-sales', 'edit-rfq-sales', 'preview-rfq-sales') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Request For Quotation</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content')
            </section>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2024 <a href="#">AdminLTE</a>.</strong>
            All rights reserved.
        </footer>
        <!-- /.main-footer -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>



    <!-- Dynamic Form -->
    <script src="{{ asset('assets/js/dynamic-form.js') }}"></script>
    <script src="{{ asset('assets/js/input-group.js') }}"></script>
    <script src="{{ asset('assets/js/ajax.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.0/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>

</body>

</html>
