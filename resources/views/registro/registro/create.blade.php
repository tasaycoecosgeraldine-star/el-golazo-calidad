<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'registro/cliente', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
    {!! Form::token() !!}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }

        .obligatorio {
            /* font-size: 2em; */
            color: #ca1c1c;
        }
    </style>

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <span class="title_header_formulario">
                    Nuevo Cliente
                </span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="formulario">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group" id="grupo__nombres">
                            <label for="">Nombres <span class="text-danger"
                                    title="Campo Obligatorio">*</span></label>
                            <input type="text" class="form-control" name="nombres"
                                placeholder="Ingrese los nombres del cliente" value="{{ old('nombres') }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group" id="grupo__numDocumento">
                            <label for="">N° Documento<span class="text-danger"
                                    title="Campo Obligatorio">*</span></label>
                            <input type="text" class="form-control" name="numDocumento"
                                placeholder="Número de Documento" value="{{ old('numDocumento') }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="">Teléfono</label>
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
                    <div class="col-lg-7 col-12">
                        <div class="form-group">
                            <label for="">Correo</label>
                            <input type="text" class="form-control" name="email"
                                placeholder="Correo Electrónico" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col-lg-5 col-12">
                        <div class="form-group">
                            <label for="">F. Nacimiento</label>
                            <input type="date" class="form-control" value="{{ old('fechaNac') }}" id="fechaNac"
                                name="fechaNac">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="file" class="form-control " id="Imagen" name="foto">
                        <div id="img" class="imagen"></div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
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
                <div style="margin: 0px auto 0px auto">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary bg-teal">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::Close() }}
