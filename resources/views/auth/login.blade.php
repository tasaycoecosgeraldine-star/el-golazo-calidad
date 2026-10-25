@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-5 col-md-offset-4" style="margin-left:auto; margin-right:auto; margin-left: auto; margin-top:60px">
        <div class="card">
            <div class="card-header p-3 mb-2  text-secondary" >
                <p align="center" style="font-weight: bold; font-size: 1.90em"> SISTEMA CONTROL DE CANCHAS SINTÉTICAS</p>
                <p align="center">
                {{-- <img src="{{asset('Logo/' . $empresa_ini->logo)}}" width="90" style="margin-bottom: -20px;"  alt=""> --}}
                </p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('login')}}">
                    {{-- {{ csrf_field() }} --}}
                    @csrf
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }} ">
                        <label for="" class="text-secondary" style="font-weight: bold;">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Ingrese su correo electrónico." value="{{old ('email')}}" required>
                        {!! $errors->first('email', '<span class="help-block text-danger">:message </span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="" class="text-secondary" style="font-weight: bold;">Contraseña</label>
                        <input class="form-control @error('email') is-invalid @enderror"  type="password" name="password" placeholder="Ingrese su Contraseña" required>
                        {!! $errors->first('password', '<span class="help-block text-danger">:message </span>') !!}
                        {{-- <a href="{{asset('password/reset')}}" style="text-decoration: none; float:right; margin-bottom: 10px;">
                        <b>¿Olvidé mi contraseña?</b></a> --}}
                        {{-- <a href="{{route('password.request')}}" style="text-decoration: none; float:right; margin-bottom: 10px;">
                        <b>¿Olvidé mi contraseña?</b></a><br> --}}

                    </div>
                    <button class="btn btn-info btn-block bg-teal" >INICIAR SESIÓN</button>
                    {{-- <a href="{{asset('register')}}" style="text-decoration: none; float:right; margin-bottom: 10px;">
                        <b>Crear nueva cuenta</b></a> --}}
                </form>
            </div>
            <div class="card-footer" style="text-align: center;">
                <span class="text-teal" ><b >
                     {{-- <a style="text-decoration: none;"
                     href="#" > --}}
                    Desarrollado por &copy CWILSOFT - 2023</b>
                    {{-- </a> --}}
                </span>
            </div>
        </div>
    </div>
</div>

@endsection
