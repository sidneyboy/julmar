<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Julmar</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('adminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/jqvmap/jqvmap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    {{-- <link rel="stylesheet" href="{{ asset('adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css"> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

    <style>
        .center-body {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            background-color: #202628;
            position: fixed;
            z-index: 9999;
            opacity: 0.9;
        }

        .loader-circle-105 {
            position: relative;
            width: 150px;
            height: 100px;
            display: inline-block;
        }

        .loader-circle-105>div {
            position: absolute;
            height: 25px;
            width: 25px;
            border-radius: 50%;
            animation: anm-CL-105-move 3s infinite;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .loader-circle-105>div:nth-child(1) {
            border: 5px solid #2196f3;
        }

        .loader-circle-105>div:nth-child(2) {
            animation-delay: 1s;
            border: 5px solid #e91e63;
        }

        .loader-circle-105>div:nth-child(3) {
            animation-delay: 2s;
            border: 5px solid #cddc39;
        }

        @keyframes anm-CL-105-move {
            0% {
                left: 1px;
            }

            25% {
                height: 50px;
                width: 50px;
            }

            50% {
                left: 150px;
                height: 25px;
                width: 25px;
            }

            75% {
                height: 50px;
                width: 50px;
            }

            100% {
                left: 1px;
            }
        }
    </style>
</head>
<div class="center-body" id="loader" style="display:none">
    <div class="loader-circle-105">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<body class="hold-transition sidebar-mini sidebar-collapse sidebar-mini">
    {{-- dark-mode --}}
    {{-- sidebar-collapse --}}

    <div class="wrapper">
        @section('navbar')
            <!-- Preloader -->
            {{-- <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="{{ asset('adminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
                    height="60" width="60">
            </div> --}}

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark navbar-light ">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto nav-compact">
                    <!-- Navbar Search -->
                    <li class="nav-item">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                            <i class="fas fa-search"></i>
                        </a>
                        <div class="navbar-search-block">
                            <form class="form-inline">
                                <div class="input-group input-group-sm">
                                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                        aria-label="Search">
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
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                            role="button">
                            <i class="fas fa-th-large"></i>
                        </a> --}}
                        <a class="nav-link" href="{{ route('logout_page') }}" style="font-weight: bold;color:white;">
                            LOGOUT
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->
        @show
        @section('sidebar')
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-lime elevation-4 nav-compact">
                <!-- Brand Logo -->
                <a href="#" class="brand-link">
                    <img src="{{ asset('/adminLte/dist/img/julmar.png') }}" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Julmar Commercial</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ asset('adminLTE/dist/img/user.png') }}" class="img-circle elevation-2"
                                alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">{{ $user->name }}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            @if ($user->position == 'admin')
                                <li class="nav-item">
                                    <a href="{{ url('/disbursement') }}"
                                        class="nav-link {{ $active_tab == 'disbursement' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                        <p>Disbursement</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/disbursement_report') }}"
                                        class="nav-link {{ $active_tab == 'disbursement_report' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                        <p>Disbursement Report</p>
                                    </a>
                                </li>
                                <li class="nav-item {{ $main_tab == 'manage_principal_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_principal_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Principal
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/principal_ledger') }}"
                                                class="nav-link {{ $active_tab == 'principal_ledger' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Principal Ledger</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/new_principal') }}"
                                                class="nav-link {{ $active_tab == 'new_principal' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>New Principal</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/principal_discount') }}"
                                                class="nav-link {{ $active_tab == 'principal_discount' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Principal Discounts</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/new_principal_categories') }}"
                                                class="nav-link {{ $active_tab == 'new_principal_categories' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>New Categories</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('principal_payment') }}"
                                                class="nav-link {{ $active_tab == 'principal_payment' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Accounts Payable</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ $main_tab == 'manage_warehouse_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_warehouse_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Warehouse
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/receiving_draft') }}"
                                                class="nav-link {{ $active_tab == 'receiving_draft' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Received as Draft</p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="{{ url('invoice_out') }}"
                                                class="nav-link {{ $active_tab == 'invoice_out' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Invoice Out</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('warehouse_pcm') }}"
                                                class="nav-link {{ $active_tab == 'warehouse_pcm' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PCM</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item {{ $main_tab == 'manage_pcm_custodian_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_pcm_custodian_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage PCM
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('warehouse_pcm') }}"
                                                class="nav-link {{ $active_tab == 'warehouse_pcm' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Verify PCM</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ $main_tab == 'manage_logistics_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_logistics_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Logistics
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/truck_register') }}"
                                                class="nav-link {{ $active_tab == 'truck_register' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Truck</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/truck_load') }}"
                                                class="nav-link {{ $active_tab == 'truck_load' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Truck Load</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item  {{ $main_tab == 'manage_sku_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_sku_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage SKU
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/sku_add') }}"
                                                class="nav-link {{ $active_tab == 'sku_add' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>New SKU</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_list') }}"
                                                class="nav-link {{ $active_tab == 'sku_list' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>SKU List</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_barcode') }}"
                                                class="nav-link {{ $active_tab == 'sku_barcode' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>SKU Barcode</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_ledger') }}"
                                                class="nav-link {{ $active_tab == 'sku_ledger' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Inventory Ledger</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_extract_inventory') }}"
                                                class="nav-link {{ $active_tab == 'sku_extract_inventory' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Export SKU</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_update_price') }}"
                                                class="nav-link {{ $active_tab == 'sku_update_price' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Price Update</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('bodega_out') }}"
                                                class="nav-link {{ $active_tab == 'bodega_out' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Bodega Out</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('bodega_out_report') }}"
                                                class="nav-link {{ $active_tab == 'bodega_out_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Bodega Out Report </p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li
                                    class="nav-item {{ $main_tab == 'receiving_and_purchases_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'receiving_and_purchases_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            PO & Receiving
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/purchase_order') }}"
                                                class="nav-link {{ $active_tab == 'purchase_order' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PO Draft</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/purchase_order_confirmation') }}"
                                                class="nav-link {{ $active_tab == 'purchase_order_confirmation' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PO Confirmation</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/purchase_order_report') }}"
                                                class="nav-link {{ $active_tab == 'purchase_order_report' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PO Report</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/receive_order') }}"
                                                class="nav-link {{ $active_tab == 'receive_order' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Final Receiving</p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="{{ url('/receive_order_report') }}"
                                                class="nav-link {{ $active_tab == 'receive_order_report' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Received Report</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_withdrawal') }}"
                                                class="nav-link {{ $active_tab == 'sku_withdrawal' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>SKU Withdrawal</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ $main_tab == 'manage_adjustments_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_adjustments_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Adjustments
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/return_to_principal') }}"
                                                class="nav-link {{ $active_tab == 'return_to_principal' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-exchange-alt"></i>
                                                <p>Return To Principal </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/return_to_principal_reports') }}"
                                                class="nav-link {{ $active_tab == 'return_to_principal_reports' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>RTP - Report </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/bo_allowance_adjustments') }}"
                                                class="nav-link {{ $active_tab == 'bo_allowance_adjustments' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-ban"></i>
                                                <p>Bo Allowance Adj</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/bo_allowance_adjustments_report') }}"
                                                class="nav-link {{ $active_tab == 'bo_allowance_adjustments_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>BOA - Report</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/invoice_cost_adjustments') }}"
                                                class="nav-link {{ $active_tab == 'invoice_cost_adjustments' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-file-invoice"></i>
                                                <p>Invoice Cost Adj</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/invoice_cost_adjustments_report') }}"
                                                class="nav-link {{ $active_tab == 'invoice_cost_adjustments_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>ICA - Report</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/inventory_adjustments') }}"
                                                class="nav-link {{ $active_tab == 'inventory_adjustments' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-file-invoice"></i>
                                                <p>Inventory Adj</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li
                                    class="nav-item {{ $main_tab == 'transfer_sku_to_branch_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'transfer_sku_to_branch_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Transfer to Branch
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('transfer_to_branch') }}"
                                                class="nav-link {{ $active_tab == 'transfer_to_branch' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Transfer </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('transfer_to_branch_report') }}"
                                                class="nav-link {{ $active_tab == 'transfer_to_branch_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Transfer Report</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item {{ $main_tab == 'manage_agent_and_location_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_agent_and_location_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Agent & Location
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('agent') }}"
                                                class="nav-link {{ $active_tab == 'agent' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>New Agent</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('location') }}"
                                                class="nav-link {{ $active_tab == 'location' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>New Location</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ $main_tab == 'manage_customer_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_customer_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Customer
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('customer_upload') }}"
                                                class="nav-link {{ $active_tab == 'customer_upload' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Customer Upload & Update</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('customer') }}"
                                                class="nav-link {{ $active_tab == 'customer' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>New Customer</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('customer_list') }}"
                                                class="nav-link {{ $active_tab == 'customer_list' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Customer List</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('customer_profile') }}"
                                                class="nav-link {{ $active_tab == 'customer_profile' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Export Customer</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('audit_approved_customer') }}"
                                                class="nav-link {{ $active_tab == 'audit_approved_customer' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Customer Status</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('customer_principal_code_price_level') }}"
                                                class="nav-link {{ $active_tab == 'customer_principal_code_price_level' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Customer Code/Price L</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('customer_discount') }}"
                                                class="nav-link {{ $active_tab == 'customer_discount' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Customer Discount</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ $main_tab == 'manage_booking_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_booking_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Booking
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('upload_raw_data') }}"
                                                class="nav-link {{ $active_tab == 'upload_raw_data' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Upload Raw Data</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('sales_order') }}"
                                                class="nav-link {{ $active_tab == 'sales_order_migrate' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>SO Upload</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('sales_order_draft') }}"
                                                class="nav-link {{ $active_tab == 'sales_order_draft' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>SO Draft </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('sales_invoice') }}"
                                                class="nav-link {{ $active_tab == 'sales_invoice' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Print Invoice</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('sales_order_register') }}"
                                                class="nav-link {{ $active_tab == 'sales_order_register' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Sales Register Export</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('booking_pcm') }}"
                                                class="nav-link {{ $active_tab == 'booking_pcm' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PCM</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('booking_pcm_upload') }}"
                                                class="nav-link {{ $active_tab == 'booking_pcm_upload' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PCM Upload</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('warehouse_rgs_report') }}"
                                                class="nav-link {{ $active_tab == 'warehouse_rgs_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>RGS Report</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('warehouse_bo_report') }}"
                                                class="nav-link {{ $active_tab == 'warehouse_bo_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>BO Report</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ $main_tab == 'manage_van_selling_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_van_selling_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Van Selling
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_payment') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_payment' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Collection</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_actual_stocks_on_hand') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_actual_stocks_on_hand' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Actual stocks on Hand</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_import_data') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_import_data' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Upload Sales</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('vs_upload_and_export_customer') }}"
                                                class="nav-link {{ $active_tab == 'vs_upload_and_export_customer' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Import & Export CSTMR</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_customer_list') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_customer_list' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Customer List</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_inventory_adjustments') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_inventory_adjustments' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Inventory Adjustments</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_withdrawal') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_withdrawal' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Withdrawal</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_invoice') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_invoice' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Print Invoice</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_pcm') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_pcm' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PCM</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_pcm_post') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_pcm_post' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PCM Posting</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_inventory_export') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_inventory_export' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Inventory Export</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_report_date_range') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_report_date_range' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Inventory Ledger</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('van_selling_ar_ledger') }}"
                                                class="nav-link {{ $active_tab == 'van_selling_ar_ledger' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>AR Ledger</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @elseif ($user->position == 'warehouse')
                                <li class="nav-item {{ $main_tab == 'manage_warehouse_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_warehouse_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Warehouse
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/receiving_draft') }}"
                                                class="nav-link {{ $active_tab == 'receiving_draft' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Received as Draft</p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="{{ url('invoice_out') }}"
                                                class="nav-link {{ $active_tab == 'invoice_out' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Invoice Out</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('warehouse_pcm') }}"
                                                class="nav-link {{ $active_tab == 'warehouse_pcm' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PCM</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @elseif($user->position == 'inventory')
                                <li class="nav-item {{ $main_tab == 'manage_principal_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_principal_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Principal
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/principal_ledger') }}"
                                                class="nav-link {{ $active_tab == 'principal_ledger' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Principal Ledger</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/new_principal') }}"
                                                class="nav-link {{ $active_tab == 'new_principal' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>New Principal</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/principal_discount') }}"
                                                class="nav-link {{ $active_tab == 'principal_discount' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Principal Discounts</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/new_principal_categories') }}"
                                                class="nav-link {{ $active_tab == 'new_principal_categories' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>New Categories</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('principal_payment') }}"
                                                class="nav-link {{ $active_tab == 'principal_payment' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Accounts Payable</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item  {{ $main_tab == 'manage_sku_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_sku_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage SKU
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/sku_add') }}"
                                                class="nav-link {{ $active_tab == 'sku_add' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>New SKU</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_list') }}"
                                                class="nav-link {{ $active_tab == 'sku_list' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>SKU List</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_barcode') }}"
                                                class="nav-link {{ $active_tab == 'sku_barcode' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>SKU Barcode</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_ledger') }}"
                                                class="nav-link {{ $active_tab == 'sku_ledger' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Inventory Ledger</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_extract_inventory') }}"
                                                class="nav-link {{ $active_tab == 'sku_extract_inventory' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Export SKU</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_update_price') }}"
                                                class="nav-link {{ $active_tab == 'sku_update_price' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Price Update</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('bodega_out') }}"
                                                class="nav-link {{ $active_tab == 'bodega_out' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Bodega Out</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('bodega_out_report') }}"
                                                class="nav-link {{ $active_tab == 'bodega_out_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Bodega Out Report </p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item {{ $main_tab == 'receiving_and_purchases_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'receiving_and_purchases_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            PO & Receiving
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/purchase_order') }}"
                                                class="nav-link {{ $active_tab == 'purchase_order' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PO Draft</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/purchase_order_confirmation') }}"
                                                class="nav-link {{ $active_tab == 'purchase_order_confirmation' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PO Confirmation</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/purchase_order_report') }}"
                                                class="nav-link {{ $active_tab == 'purchase_order_report' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>PO Report</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/receive_order') }}"
                                                class="nav-link {{ $active_tab == 'receive_order' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Final Receiving</p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="{{ url('/receive_order_report') }}"
                                                class="nav-link {{ $active_tab == 'receive_order_report' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Received Report</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/sku_withdrawal') }}"
                                                class="nav-link {{ $active_tab == 'sku_withdrawal' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>SKU Withdrawal</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ $main_tab == 'manage_adjustments_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_adjustments_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage Adjustments
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/return_to_principal') }}"
                                                class="nav-link {{ $active_tab == 'return_to_principal' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-exchange-alt"></i>
                                                <p>Return To Principal </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/return_to_principal_reports') }}"
                                                class="nav-link {{ $active_tab == 'return_to_principal_reports' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>RTP - Report </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/bo_allowance_adjustments') }}"
                                                class="nav-link {{ $active_tab == 'bo_allowance_adjustments' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-ban"></i>
                                                <p>Bo Allowance Adj</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/bo_allowance_adjustments_report') }}"
                                                class="nav-link {{ $active_tab == 'bo_allowance_adjustments_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>BOA - Report</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/invoice_cost_adjustments') }}"
                                                class="nav-link {{ $active_tab == 'invoice_cost_adjustments' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-file-invoice"></i>
                                                <p>Invoice Cost Adj</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/invoice_cost_adjustments_report') }}"
                                                class="nav-link {{ $active_tab == 'invoice_cost_adjustments_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>ICA - Report</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/inventory_adjustments') }}"
                                                class="nav-link {{ $active_tab == 'inventory_adjustments' ? 'active' : '' }}">
                                                <i class="nav-icon fas fa-file-invoice"></i>
                                                <p>Inventory Adj</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item {{ $main_tab == 'transfer_sku_to_branch_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'transfer_sku_to_branch_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Transfer to Branch
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('transfer_to_branch') }}"
                                                class="nav-link {{ $active_tab == 'transfer_to_branch' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Transfer </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('transfer_to_branch_report') }}"
                                                class="nav-link {{ $active_tab == 'transfer_to_branch_report' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Transfer Report</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @elseif($user->position == 'custodian')
                                <li
                                    class="nav-item {{ $main_tab == 'manage_pcm_custodian_main_tab' ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $sub_tab == 'manage_pcm_custodian_sub_tab' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-solid fa-folder fa-2xs"></i>
                                        <p>
                                            Manage PCM
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('warehouse_pcm') }}"
                                                class="nav-link {{ $active_tab == 'warehouse_pcm' ? 'active' : '' }}">
                                                  <i class="nav-icon fas fa-regular fa-arrow-right fa-beat fa-2xs"></i>
                                                <p>Verify PCM</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
        @show
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <br />
            @yield('content')
        </div>

        @section('footer')
            <!-- /.content-wrapper -->
            {{-- <footer class="main-footer">
                <strong>Julmar Commercial Inc</a>.</strong>
                All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside> --}}
            <!-- /.control-sidebar -->

        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{ asset('adminLTE/plugins/jquery/jquery.min.js') }}"></script>

        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('adminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- ChartJS -->
        <script src="{{ asset('adminLTE/plugins/chart.js/Chart.min.js') }}"></script>

        <!-- Sparkline -->
        <script src="{{ asset('adminLTE/sparklines/sparkline.js') }}"></script>

        <!-- JQVMap -->
        <script src="{{ asset('adminLTE/plugins/jqvmap/jquery.vmap.min.js') }}"></script>

        <script src="{{ asset('adminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

        <!-- jQuery Knob Chart -->
        <script src="{{ asset('adminLTE/plugins/jquery-knob/jquery.knob.min.js') }}"></script>

        <!-- daterangepicker -->
        <script src="{{ asset('adminLTE/plugins/moment/moment.min.js') }}"></script>

        <script src="{{ asset('adminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>

        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('adminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

        <!-- Summernote -->
        <script src="{{ asset('adminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>

        <!-- overlayScrollbars -->
        <script src="{{ asset('adminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

        <!-- AdminLTE App -->
        <script src="{{ asset('adminLTE/dist/js/adminlte.js') }}"></script>

        <!-- AdminLTE for demo purposes -->
        {{-- <script src="{{ asset('adminLTE/dist/js/demo.js') }}"></script> --}}

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{ asset('adminLTE/dist/js/pages/dashboard.js') }}"></script>






        {{-- <script src="{{ asset('adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script> --}}
        <script src="{{ asset('adminLTE/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('adminLTE/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('adminLTE/plugins/pdfmake/vfs_fonts.js') }}"></script>
        {{-- <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('adminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script> --}}
        <script src="{{ asset('adminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
        {{-- <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script> --}}



        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(function() {
                $('.select2').select2()

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                $('#reservation').daterangepicker()



                // $("#example1").DataTable({
                //     "responsive": true,
                //     "lengthChange": false,
                //     "autoWidth": false,
                //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                // $('#example2').DataTable({
                //     "paging": true,
                //     "lengthChange": false,
                //     "searching": true,
                //     "ordering": true,
                //     "info": true,
                //     "autoWidth": false,
                //     "responsive": true,
                // });
            });
        </script>
    @show
