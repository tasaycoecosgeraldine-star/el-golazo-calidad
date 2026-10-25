@extends('layouts.admin')
@section('contenido')
    <style>
        .imagen img {
            background: #f8eded;
            width: 100px;
            height: auto;
        }
    </style>
    {!! Form::open([
        'url' => route('usuario.update', $usuario->codUsuario),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title title_header" id="exampleModalLongTitle">
                        {{-- @if (auth()->user()->tipo == 'SECRETARIA')
                            Editar Doctor
                        @else --}}
                        Editar Usuario
                        {{-- @endif --}}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Nombres</label>
                                        <div class="input-group a mb-3">
                                            {{-- Código de Usuario para que función el unique de los campos --}}
                                            <input type="hidden" name="codUsuario" id=""
                                                value="{{ $usuario->codUsuario }}">
                                            <input type="text"
                                                class="form-control {{ $errors->has('nombres') ? 'is-invalid' : '' }}"
                                                name="nombres" placeholder=""
                                                @if (empty(old('nombres'))) value="{{ $usuario->nombres }}"
                                             @else
                                                                             value="{{ old('nombres') }}" @endif>
                                        </div>
                                        @if ($errors->has('nombres'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('nombres') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">N° Documento</label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control {{ $errors->has('numDocumento') ? 'is-invalid' : '' }}"
                                                name="numDocumento" placeholder=""
                                                @if (empty(old('numDocumento'))) value="{{ $usuario->numDocumento }}"
                                             @else
                                                                             value="{{ old('numDocumento') }}" @endif>
                                        </div>
                                        @if ($errors->has('numDocumento'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('numDocumento') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Dirección</label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}"
                                                name="direccion" placeholder=""
                                                @if (empty(old('direccion'))) value="{{ $usuario->direccion }}"
                                             @else
                                                                             value="{{ old('direccion') }}" @endif>
                                        </div>
                                        @if ($errors->has('direccion'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('direccion') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">N° Teléfono</label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control {{ $errors->has('telefono') ? 'is-invalid' : '' }}"
                                                name="telefono" placeholder=""
                                                @if (empty(old('telefono'))) value="{{ $usuario->telefono }}"
                                             @else
                                             value="{{ old('telefono') }}" @endif>
                                        </div>
                                        @if ($errors->has('telefono'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('telefono') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Correo</label>
                                        <div class="input-group a mb-3">
                                            <input type="email"
                                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                name="email" placeholder=""
                                                @if (empty(old('email'))) value="{{ $usuario->email }}"
                                             @else
                                                                             value="{{ old('email') }}" @endif>
                                        </div>
                                        @if ($errors->has('email'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Tipo</label>
                                        <div class="input-group a mb-3">
                                            @if ($usuario->codUsuario == 1)
                                                <input type="text" value="{{ $usuario->tipo }}" name="tipo"
                                                    id="tipo" class="form-control" readonly>
                                            @else
                                                <select class="form-control tipo" name="tipo" id="tipo">
                                                    @foreach ($tipos as $item)
                                                        @if ($item == $usuario->tipo)
                                                            <option value="{{ $item }}" selected>
                                                                {{ $item }}</option>
                                                        @else
                                                            <option value="{{ $item }}">{{ $item }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif

                                        </div>
                                        @if ($errors->has('tipo'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('tipo') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group " id="grupo__password">
                                        <label for="password">Contraseña</label>
                                        <input type="password" name="password" id="password"
                                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            placeholder="Ingrese la Clave de Acceso.">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="password2">Repetir Contraseña</label>
                                        <input type="password" name="password_confirmation" id="password2"
                                            class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }} "
                                            placeholder="Vuelva a ingresar la Clave de Acceso.">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-image fa-2x-x"></i><span
                                                        class="tooltiptext">Seleccione Fotografia</span></span>
                                            </div>
                                            <input type="file" class="form-control " id="Imagen" name="foto">
                                        </div>
                                        @if ($errors->has('foto'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('foto') }}</span>
                                            </div>
                                        @endif
                                        <div id="img2" class="imagen ">
                                            <img src="{{ asset('Imagen/' . $usuario->foto) }}" width="100"
                                                height="100">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <div style="margin: 0px auto 0px auto">
                        <div style="margin: 0px auto 0px auto">
                            <a href="{{ route('usuario.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

    <script>
        document.getElementById("Imagen").onchange = function(e) {
            // Creamos el objeto de la clase FileReader
            let reader = new FileReader();

            // Leemos el archivo subido y se lo pasamos a nuestro fileReader
            reader.readAsDataURL(e.target.files[0]);

            // Le decimos que cuando este listo ejecute el código interno
            reader.onload = function() {
                let preview = document.getElementById('img2'),
                    image = document.createElement('img');
                console.log("mostrado")
                image.src = reader.result;

                preview.innerHTML = '';
                preview.append(image);
            };
        }
    </script>


@endsection
