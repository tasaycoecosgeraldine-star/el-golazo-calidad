<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'acceso/usuario', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
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
                <span class="title_header_formulario">
                    Nuevo Usuario
                </span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body" id="formulario">
                @if (count($errors) > 0)
                    <div style="margin: 0px auto 0px auto">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nombres <span class="text-danger"
                                    title="Campo obligatorio">*</span></label>
                            <input type="text" class="form-control" name="nombres"
                                placeholder="Ingrese los nombres del usuario" value="{{ old('nombres') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="">N° Documento <span class="text-danger"
                                    title="Campo obligatorio">*</span></label>
                            <input type="text" class="form-control" name="numDocumento"
                                placeholder="Ingrese número de Documento" value="{{ old('numDocumento') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="">N° Teléfono </label>
                            <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                maxlength="10" class="form-control" name="telefono" placeholder="Teléfono"
                                value="{{ old('telefono') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Dirección</label>
                            <input type="text" class="form-control" name="direccion"
                                placeholder="Dirección Ejm:Jr.Los Claveles 121 " value="{{ old('direccion') }}">
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="form-group">
                            <label for="">Correo</label>
                            <input type="text" class="form-control form-control-sm" name="email" placeholder="Correo Electrónico"
                                value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="form-group">
                            <label for="">Rol</label>
                            <select class="form-control form-control-sm selectpicker tipo" name="tipo" id="tipo" required
                                data-live-search="true">
                                <option value="" hidden selected> Seleccione un Rol </option>
                                @foreach ($tipos as $item)
                                    <option value="{{ $item }}" {{old('tipo') == $item ? 'selected' : ''}} style="font-size: 0.90em">
                                            {{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input type="file" class="form-control " id="Imagen" name="foto">
                        </div>
                        <div id="img" class="imagen"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary bg-teal">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::Close() }}
