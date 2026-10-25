<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'configuracion/localidad', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
    {!! Form::token() !!}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }
    </style>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-teal">
                <span class="title_header_formulario">Nuevo Campo Deportivo</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body" id="formulario">
                <div class="modal-body">
                    <div class="form-group row" id="grupo__nomEspecialidad">
                        <div class="input-group  a mb-3">
                            <label for="">Nombre</label>
                            <div class="formulario__grupo-input input-group">
                                <input type="text" class="form-control fi" name="nomLocalidad" id="nomLocalidad"
                                    placeholder="Nombre del campo deportivo" value="{{ old('nomLocalidad') }}" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group mb-3">
                            <label for="">Precio Día</label>
                            <div class="input-group">
                                <input type="text" class="form-control fi" name="precioDia" id="precioDia"
                                    placeholder="Precio día" value="{{ old('precioDia') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group mb-3">
                            <label for="">Precio Noche</label>
                            <div class="input-group">
                                <input type="text" class="form-control fi" name="precioNoche" id="precioNoche"
                                    placeholder="Precio noche" value="{{ old('precioNoche') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="grupo__correoedit">
                        <div class="input-group a mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-image"></i><span
                                        class="tooltiptext">Seleccione Imagen</span></span>
                            </div>
                            <input type="file" class="form-control " id="Imagen" name="logo">
                        </div>
                    </div>
                    <div id="img" class="imagen"></div>
                </div>
                <div class="modal-footer">
                    @if (count($errors) > 0)
                        <div style="margin: 0px auto 0px auto">
                            <div class="alert alert-danger">
                                <ul>
                                    @php($error_create = 0)
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    @endif
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-info bg-teal">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::Close() }}
