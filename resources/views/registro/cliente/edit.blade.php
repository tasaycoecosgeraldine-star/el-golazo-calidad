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
        'url' => route('cliente.update', $cliente->codCliente),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title title_header" id="exampleModalLongTitle">
                        Editar Cliente
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Nombre" class="text-secondary">Ingrese el Nombre del Cliente</label>
                                        <input type="hidden" name="codCliente" id=""
                                            value="{{ $cliente->codCliente }}">
                                        @php($val_nombres = empty(old('nombres')) ? $cliente->nombres : old('nombres'))
                                        <input type="text" class="form-control fi" name="nombres"placeholder="Nombres"
                                            value="{{ $val_nombres }}">
                                    </div>
                                    @if ($errors->has('nombres'))
                                        <div>
                                            <span class="text-danger">{{ $errors->first('nombres') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nombre" class="text-secondary">Ingrese el número de Documento</label>
                                        @php($val_numDocumento = empty(old('numDocumento')) ? $cliente->numDocumento : old('numDocumento'))
                                        <input type="text" class="form-control fi" name="numDocumento"
                                            placeholder="Número de Documento" value="{{ $val_numDocumento }}">
                                    </div>
                                    @if ($errors->has('nombres'))
                                        <div>
                                            <span class="text-danger">{{ $errors->first('nombres') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nombre" class="text-secondary">Ingrese el número de Teléfono</label>
                                        <input type="text"
                                            onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10"
                                            class="form-control fi" name="telefono" placeholder="Teléfono" @if (empty(old('telefono')))
                                        value="{{ $cliente->telefono }}"
                                    @else
                                        value="{{ old('telefono') }}"
                                        @endif>
                                    </div>
                                    @if ($errors->has('nombres'))
                                        <div>
                                            <span class="text-danger">{{ $errors->first('nombres') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Nombre" class="text-secondary">Ingrese la Dirección</label>
                                        <input type="text" class="form-control fi" name="direccion"
                                            placeholder="Dirección Ejm:Jr.Los Claveles 121 "
                                            @if (empty(old('direccion'))) value="{{ $cliente->direccion }}"
        @else
                                                                                                    value="{{ old('direccion') }}" @endif>
                                    </div>
                                    @if ($errors->has('nombres'))
                                        <div>
                                            <span class="text-danger">{{ $errors->first('nombres') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nombre" class="text-secondary">Ingrese el Correo Electrónico</label>
                                        @php($val_numDocumento = empty(old('numDocumento')) ? $cliente->numDocumento : old('numDocumento'))
                                        <input type="text" class="form-control fi" name="email"
                                            placeholder="Correo Electrónico"
                                            @if (empty(old('email'))) value="{{ $cliente->email }}"
    @else
                                                                                                value="{{ old('email') }}" @endif>
                                    </div>
                                    @if ($errors->has('nombres'))
                                        <div>
                                            <span class="text-danger">{{ $errors->first('nombres') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nombre" class="text-secondary">Ingrese Fecha de Nacimiento</label>
                                        @php($val_numDocumento = empty(old('numDocumento')) ? $cliente->numDocumento : old('numDocumento'))
                                        <input type="date" class="form-control fi" id="fechaNac" name="fechaNac"
                                            @if (empty(old('fechaNac'))) value="{{ $cliente->fechNac }}"
                                                @else
                                                                                                        value="{{ old('fechaNac') }}" @endif>
                                    </div>
                                    @if ($errors->has('nombres'))
                                        <div>
                                            <span class="text-danger">{{ $errors->first('nombres') }}</span>
                                        </div>
                                    @endif
                                </div>








                                {{-- ----------------------------------------------------------------------------------------------------------------- --}}
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tie fa-2x-x"></i><span
                                                        class="tooltiptext">Seleccione Género</span></span>
                                            </div>
                                            <select name="Genero" class="form-control">
                                                @if ($paciente->genero == 'M')
                                                    <option value="M" selected>MASCULINO</option>
                                                    <option value="F">FEMENINO</option>
                                                @else
                                                    <option value="M">MASCULINO</option>
                                                    <option value="F" selected>FEMENINO</option>
                                                @endif
                                            </select>
                                        </div>
                                        @if ($errors->has('Genero'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('Genero') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Nombre" class="text-secondary">Ingrese su
                                            Fotografia</label>
                                        <input type="hidden" name="codCliente" id=""
                                            value="{{ $cliente->codCliente }}">
                                        @php($val_nombres = empty(old('nombres')) ? $cliente->nombres : old('nombres'))
                                        <input type="file" class="form-control " id="Imagen" name="foto"
                                            onchange="mostrar()">
                                    </div>
                                    <div class="imagen">
                                        <img src="{{ asset('Imagenes/Fotos/' . $cliente->foto) }}" id="img"
                                            width="100" height="100">
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <div style="margin: 0px auto 0px auto">
                        <div style="margin: 0px auto 0px auto">
                            <a href="{{ route('cliente.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
    <script type="text/javascript">
        function mostrar() {
            var archivo = document.getElementById("Imagen").files[0];
            var reader = new FileReader();
            if (archivo) {
                reader.readAsDataURL(archivo);
                reader.onloadend = function() {
                    document.getElementById("img").src = reader.result;
                    // document.getElementById("nombre_imagen").value = archivo.name;
                }
            } else {
                document.getElementById("img").src = "";
                // document.getElementById("nombre_imagen").value = "";
            }
        }
    </script>
@endsection
