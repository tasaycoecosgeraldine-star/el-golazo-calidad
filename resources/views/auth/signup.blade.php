@extends('layouts.app')

@section('content')
<main class="cotainer mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h4 class="text-center">SISTEMA CONTROL DE CANCHAS SINTÉTICAS</h4>
                <div class="card">
                    <h3 class="card-header text-center bg-teal">Crear nueva cuenta</h3>
                    <div class="card-body">
                        <form action="{{ route('user.registration') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" name="numDocumento" placeholder="Ingrese el número de su documento de identificación"
                                 id="numDocumento" class="form-control" value="{{old('numDocumento')}}">
                                @if ($errors->has('numDocumento'))
                                <span class="text-danger">{{ $errors->first('numDocumento') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" name="nombres" placeholder="Ingrese sus nombres." id="nombres" class="form-control"  value="{{old('nombres')}}">
                                @if ($errors->has('nombres'))
                                <span class="text-danger">{{ $errors->first('nombres') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" name="telefono" placeholder="Ingrese su número de celular." id="telefono" class="form-control"  value="{{old('telefono')}}">
                                @if ($errors->has('telefono'))
                                <span class="text-danger">{{ $errors->first('telefono') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" name="email" placeholder="Ingrese su correo electrónico." id="email_address" class="form-control"  value="{{old('email')}}">
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <input type="password" name="password" placeholder="Password" id="password" class="form-control" >
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="remember">Remember</label>
                                </div>
                            </div>

                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-primary btn-block bg-teal">Register</button>
                                <a href="{{asset('/')}}" class="btn btn-defaul btn-block">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</main>
@endsection
