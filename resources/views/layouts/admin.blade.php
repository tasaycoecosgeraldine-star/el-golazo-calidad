<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de Canchas Sintéticas</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/validacion.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/mis_estilos.css') }}">
    <link href="{{ asset('fullcalendar/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('fullcalendar/css/personalizado.css') }}" rel='stylesheet' />

</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark  bg-teal">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                {{-- <li class="nav-item">
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
                </li> --}}


                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-sort-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">{{ auth()->user()->nombres }}<br>
                            <font style="font-weight: bold">{{ auth()->user()->tipo }}</font>
                        </span>

                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('login') }}">
                            @method('put')
                            @csrf
                            <button class="dropdown-item dropdown-footer">
                                Cerrar Sesión <i class="fas fa-sign-out-alt" style="margin-left: 1em"></i></button>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-secondary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">

                @if (!empty($empresa_ini->logo))
                    <img src="{{ asset('Logo/' . $empresa_ini->logo) }}" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                @endif
                <span class="brand-text font-weight-light">
                    @if (isset($empresa_ini->nombre))
                        <font style="font-weight: bold; color: #20c997; font-size: 0.8em;">
                            {{ $empresa_ini->nombre }}</font>
                    @endif
                </span>

            </a>

            <!-- Sidebar -->
            <div class="sidebar ">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (auth()->user()->foto != '')
                            <img src="{{ asset('Imagen/' . auth()->user()->foto) }}" class="img-circle elevation-2"
                                alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block" style="font-size: 0.78em">
                            {{ auth()->user()->nombres }}
                        </a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ asset('panel_control') }}"
                                class="nav-link  {{ 'panel_control' == request()->segment(1) ? 'bg-teal text-white' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Panel de Control
                                </p>
                            </a>
                        </li> 
                        @if (auth()->user()->tipo == 'ADMINISTRADOR')
                            <li class="nav-item {{ 'registro' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'registro' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon far fa-futbol"></i>
                                    <p>
                                        Registro
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('registro/registro') }}"
                                            class="nav-link {{ 'registro' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Alquiler / Reserva</p>
                                        </a>
                                    </li>
                                </ul>
                                {{-- <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('registro/listado') }}"
                                        class="nav-link {{ 'listado' == request()->segment(2) ? 'bg-teal' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado</p>
                                    </a>
                                </li>
                            </ul> --}}
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('registro/cliente') }}"
                                            class="nav-link {{ 'cliente' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Clientes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'compras' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'compras' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>
                                        Compras
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('compras/compra') }}"
                                            class="nav-link {{ 'compra' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Compra</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('compras/proveedor') }}"
                                            class="nav-link {{ 'proveedor' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Proveedor</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'ventas' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'ventas' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-money-bill-alt"></i>
                                    <p>
                                        Ventas
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('ventas/venta') }}"
                                            class="nav-link {{ 'venta' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Venta</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'caja' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'caja' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cash-register"></i>
                                    <p>
                                        Caja
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('caja/apertura_cierre') }}"
                                            class="nav-link {{ 'apertura_cierre' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Apertura y Cierre</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('caja/ingreso') }}"
                                            class="nav-link {{ 'ingreso' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ingresos Extra</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('caja/egreso') }}"
                                            class="nav-link {{ 'egreso' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Egresos / Gastos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'reporte' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'reporte' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Reportes
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/caja') }}"
                                            class="nav-link {{ 'caja' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Caja</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/rango') }}"
                                            class="nav-link {{ 'rango' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Alquiler / Reserva</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/pago') }}"
                                            class="nav-link {{ 'pago' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pagos</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/rango1') }}"
                                            class="nav-link {{ 'rango1' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ventas</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/mensual') }}"
                                            class="nav-link {{ 'mensual' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p> Mensual</p>
                                        </a>
                                    </li>
                                </ul>

                            </li>
                            <li class="nav-item {{ 'almacen' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'almacen' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-box-open"></i>
                                    <p>
                                        Almacén
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('almacen/producto') }}"
                                            class="nav-link {{ 'producto' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Productos</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('almacen/categoria') }}"
                                            class="nav-link {{ 'categoria' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Categorías</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'acceso' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'acceso' == request()->segment(1) ? 'active' : '' }}">
                                    {{-- <i class="nav-icon fas fa-clipboard-list"></i> --}}
                                    <i class=" nav-icon fas fa-shield-alt"></i>
                                    <p>
                                        Acceso
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('acceso/usuario') }}"
                                            class="nav-link {{ 'usuario' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Usuarios</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'configuracion' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'configuracion' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>
                                        Configuración
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/mi_perfil') }}"
                                            class="nav-link {{ 'mi_perfil' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Mi perfíl</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/ajustes') }}"
                                            class="nav-link {{ 'ajustes' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ajustes</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/localidad') }}"
                                            class="nav-link {{ 'localidad' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Campos Deportivos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/unidad_medida') }}"
                                            class="nav-link {{ 'unidad_medida' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>U. Medida</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item {{ 'registro' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'registro' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon far fa-futbol"></i>
                                    <p>
                                        Registro
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('registro/registro') }}"
                                            class="nav-link {{ 'registro' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Alquiler / Reserva</p>
                                        </a>
                                    </li>
                                </ul>
                                {{-- <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('registro/listado') }}"
                                        class="nav-link {{ 'listado' == request()->segment(2) ? 'bg-teal' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado</p>
                                    </a>
                                </li>
                            </ul> --}}
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('registro/cliente') }}"
                                            class="nav-link {{ 'cliente' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Clientes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'compras' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'compras' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>
                                        Compras
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('compras/compra') }}"
                                            class="nav-link {{ 'compra' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Compra</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('compras/proveedor') }}"
                                            class="nav-link {{ 'proveedor' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Proveedor</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'ventas' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'ventas' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-money-bill-alt"></i>
                                    <p>
                                        Ventas
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('ventas/venta') }}"
                                            class="nav-link {{ 'venta' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Venta</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'caja' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'caja' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cash-register"></i>
                                    <p>
                                        Caja
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('caja/apertura_cierre') }}"
                                            class="nav-link {{ 'apertura_cierre' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Apertura y Cierre</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('caja/ingreso') }}"
                                            class="nav-link {{ 'ingreso' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ingresos Extra</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('caja/egreso') }}"
                                            class="nav-link {{ 'egreso' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Egresos/Gastos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'reporte' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'reporte' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Reportes
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/rango') }}"
                                            class="nav-link {{ 'rango' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Alquiler / Reserva</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/rango1') }}"
                                            class="nav-link {{ 'rango1' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ventas</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/mensual') }}"
                                            class="nav-link {{ 'mensual' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Rango Mensual</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'almacen' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'almacen' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-box-open"></i>
                                    <p>
                                        Almacén
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('almacen/producto') }}"
                                            class="nav-link {{ 'producto' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Productos</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('almacen/categoria') }}"
                                            class="nav-link {{ 'categoria' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Categorías</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'configuracion' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'configuracion' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>
                                        Configuración
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/mi_perfil') }}"
                                            class="nav-link {{ 'mi_perfil' == request()->segment(2) ? 'bg-teal' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Mi perfíl</p>
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('encabezado')
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('contenido')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            {{-- <strong>Copyright &copy; 2020-2021 <a href="https://adminlte.io">WIJGSOFT</a>.</strong> --}}
            <strong>Copyright &copy; 2023 <a href="#">CWILSOFT</a>.</strong>
            Todos los derechos Reservados
            <div class="float-right d-none d-sm-inline-block">
                <b>Sistema Control de Campos Deportivos </b>Versión - 2.5
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}

    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-select.min.js') }}"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- Data tables --}}
    <script src="{{ asset('dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/js/chart.min.js') }}"></script>

    @stack('scripts')
    <script src="{{ asset('dist/sweetalert2/eliminar.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/eliminar3.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/actualizar.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/actualizar2.js') }}"></script>
    <script src="{{ asset('dist/js/pages/formulario.js') }}"></script>


    {{-- }}}}}}}}}}}}}}}}} --}}
    <!-- Moments -->
    <script src="{{ asset('fullcalendar/moment/moment.main.js') }}"></script>
    <script src="{{ asset('fullcalendar/moment/moment-timezone.js') }}"></script>

    <script src="{{ asset('fullcalendar/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/locales-all.js') }}"></script>

</body>

</html>
