@extends('layouts.app')

@section('content')

{{-- <script type="text/javascript">
    const Toast = Swal.mixin ({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        });
        Toast.fire ({
            icon: 'error',
            title: '{{ Session::get('error') }}',
            customClass: 'swal-pop',
        })
</script> --}}

<div class="container" style="margin-top: 20px">
    <h4 class="text-center text-secondary" style="font-weight: bold;">SISTEMA CONTROL DE CANCHAS SINTÉTICAS</h4>
@if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        <i class="fas fa-check" style="margin-right: 20px"></i> {{ Session::get('success') }} <a href="{{asset('/')}}">Inicia sesión</a>
    </div>
@endif
@if (Session::has('error'))
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-times" style="margin-right: 20px"></i> {{ Session::get('error') }}
    </div>
@endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-teal text-center">CREAR NUEVA CUENTA</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right text-secondary" style="font-weight: bold">N° de Documento</label>
                            <div class="col-md-6">
                                <input id="numDocumento" type="text" class="form-control @error('numDocumento') is-invalid @enderror" name="numDocumento" value="{{ old('numDocumento') }}" required  autocomplete="numDocumento" autofocus>

                                @error('numDocumento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right text-secondary" style="font-weight: bold">Nombres</label>
                            <div class="col-md-6">
                                <input id="nombres" type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres" value="{{ old('nombres') }}" required  autocomplete="nombres" autofocus>
                                @error('nombres')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right text-secondary" style="font-weight: bold">N° Celular</label>
                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required  autocomplete="telefono" autofocus>
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right text-secondary" style="font-weight: bold">Correo</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right text-secondary" style="font-weight: bold">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right text-secondary" style="font-weight: bold">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6" style="margin: 0px auto 0px auto;">
                                <button type="submit" class="btn btn-primary btn-block bg-teal">
                                    Registrar
                                </button>
                                <a href="{{asset('/')}}" class="btn btn-secondary btn-block">Cancelar</a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
