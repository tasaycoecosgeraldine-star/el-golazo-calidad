@extends('layouts.admin')
@section('contenido')
    <style>
        .logo img {
            background: #f8eded;
            width: 100px;
            height: auto;
        }
    </style>
    {!! Form::open([
        'url' => route('localidad.update', $localidad->codLocalidad),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title title_header" id="exampleModalLongTitle">
                        Editar Campo Deportivo
                    </h5>
                    <input type="hidden" name="codLocalidad" value="{{ $localidad->codLocalidad }}">
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Nombre</label>
                                        <div class="input-group a mb-3">
                                            <input type="text"
                                                class="form-control fi {{ $errors->has('nomLocalidad') ? 'is-invalid' : '' }}"
                                                id="nomLocalidad" name="nomLocalidad" placeholder="Nombres"
                                                value="{{ empty(old('nomLocalidad')) ? $localidad->nomLocalidad : old('nomLocalidad') }}">
                                        </div>
                                        @if ($errors->has('nomLocalidad'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('nomLocalidad') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <label for="">Precio Día</label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control fi {{ $errors->has('precioDia') ? 'is-invalid' : '' }}"
                                                    name="precioDia" id="precioDia" placeholder="Precio día"
                                                    value="{{ empty(old('precioDia')) ? $localidad->precioDia : old('precioDia') }}" required>
                                            </div>
                                            @if ($errors->has('precioDia'))
                                                <div>
                                                    <span class="text-danger">{{ $errors->first('precioDia') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <label for="">Precio Noche</label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control fi {{ $errors->has('precioNoche') ? 'is-invalid' : '' }}"
                                                    name="precioNoche" id="precioNoche" placeholder="Precio noche"
                                                    value="{{ empty(old('precioNoche')) ? $localidad->precioNoche : old('precioNoche') }}" required>
                                            </div>
                                            @if ($errors->has('precioNoche'))
                                                <div>
                                                    <span class="text-danger">{{ $errors->first('precioNoche') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group a mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-image fa-2x-x"></i><span
                                                        class="tooltiptext">Seleccione Imagen</span></span>
                                            </div>
                                            <input type="file" class="form-control " id="Imagen" name="logo">
                                        </div>
                                        @if ($errors->has('logo'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('logo') }}</span>
                                            </div>
                                        @endif
                                        <div id="img2" class="logo ">
                                            <img src="{{ asset('Logo/' . $localidad->logo) }}" width="100"
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
                        <a href="{{ route('localidad.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
    <script>
        document.getElementById("Imagen").onchange = function(e) {
            console.log("das");
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
