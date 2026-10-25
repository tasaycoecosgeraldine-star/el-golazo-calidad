<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Canchas Sintéticas</title>
    <link rel="shortcut icon" type="image/ico" href="/img/yandrec-logo.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema Control de Campos Deportivos VERSIÓN 1.0. Andahuaylas - Perú">
    <meta name="author" content="CWILSOFT">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <style>
        .bg-teal, .bg-teal>a {
            color: #fff;
        }
        .bg-teal {
            background-color: #20c997!important;
        }
        .bg-teal:hover{
            /* font-size: 2em; */
            background-color: #0dc08a!important;
        }
        .text-teal {
            color: #20c997!important;
        }
    </style>
</head>
<body>
    <div class="container" >
        @if (session()->has('flash'))
            <div class="alert alert-info">{{ session('flash')}}</div>
        @endif
        @if(Session::has('flash_message'))
            <div class="alert alert-success">{{Session::get('flash_message')}}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
