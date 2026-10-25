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
    <link rel="stylesheet" href="{{asset('dist/css/bootstrap-select.min.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
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
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-sort-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                         <span class="dropdown-header">{{ auth()->guard('client')->user()->nombres }}<br>
                            <font style="font-weight: bold">{{ auth()->guard('client')->user()->tipo }}</font>
                        </span>
                        <div class="dropdown-divider"></div>
                         <form method="POST" action="{{route('login')}}">
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
        <aside class="main-sidebar sidebar-dark-light elevation-4">
            <!-- Brand Logo -->
             <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">
                    <font style="font-weight: bold; color: #20c997; font-size: 0.8em;">CANCHAS SINTÉTICAS</font>
                </span>
             </a>
            <!-- Sidebar -->
            <div class="sidebar ">
                <!-- Sidebar user panel (optional) -->
                 <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (auth()->guard('client')->user()->foto != '')
                            <img src="{{ asset('Imagenes/Fotos/' . auth()->guard('client')->user()->foto) }}" class="img-circle elevation-2"
                                alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            @php($nombre = explode(' ', auth()->guard('client')->user()->nombres))
                            @if (count($nombre) > 1)
                                {{ $nombre[0] }} {{ $nombre[1] }}
                            @else
                                {{auth()->guard('client')->user()->nombres}}
                            @endif
                        </a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link {{ 'registro' == request()->segment(1) ? '' : '' }}">
                                <i class="nav-icon far fa-futbol"></i>
                                <p>
                                    Registro
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('registroCliente/registro') }}"
                                        class="nav-link {{ 'registro' == request()->segment(2) ? 'bg-teal' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reserva</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('registroCliente/mis_reservas') }}"
                                        class="nav-link {{ 'mis_reservas' == request()->segment(2) ? 'bg-teal' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mis reservas</p>
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link {{ 'configuracion' == request()->segment(1) ? '' : '' }}">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Configuración
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('configuracion/mi_perfil_c') }}"
                                        class="nav-link {{ 'mi_perfil_c' == request()->segment(2) ? 'bg-teal' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mi perfíl</p>
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
            <strong>Copyright &copy; 2021 <a href="#">CWILSOFT</a>.</strong>
            Todos los derechos Reservados
            <div class="float-right d-none d-sm-inline-block">
                <b>Sistema Control de Canchas Sintèticas </b>Versión - 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('dist/js/bootstrap-select.min.js')}}"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/sweetalert2.all.min.js') }}"></script>

    @stack('scripts')
    <script src="{{ asset('dist/sweetalert2/eliminar.js') }}"></script>

    {{-- }}}}}}}}}}}}}}}}} --}}
    <!-- Moments -->
    <script src="{{ asset('fullcalendar/moment/moment.main.js') }}"></script>
    <script src="{{ asset('fullcalendar/moment/moment-timezone.js') }}"></script>

    <script src="{{ asset('fullcalendar/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/locales-all.js') }}"></script>

</body>

</html>
