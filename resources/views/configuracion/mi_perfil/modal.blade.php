<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-add-{{ $usuario->codUsuario }}">

    {!! Form::model($usuario, [
        'method' => 'PATCH',
        'route' => ['mi_perfil.update', $usuario->codUsuario],
        'files' => 'true',
    ]) !!}
    {{ Form::token() }}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }
    </style>

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <span class="title_header_formulario">
                    Mi perfíl</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="Nombre" class="text-secondary">Nombre</label>
                            @php($val_nombres = old('nombres') != '' ? old('nombres') : $usuario->nombres)
                            <input type="hidden" name="codUsuario" id="" value="{{ $usuario->codUsuario }}">
                            <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror"
                                value="{{ $val_nombres }}" placeholder="Ingrese los nombres" required>
                            {!! $errors->first('nombres', '<span class="help-block text-danger">:message </span>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="Nombre" class="text-secondary">Numero de Documento</label>
                        @php($val_documento = old('numDocumento') != '' ? old('numDocumento') : $usuario->numDocumento)
                        <input type="text" name="numDocumento"
                            class="form-control @error('numDocumento') is-invalid @enderror numero"
                            value="{{ $val_documento }}" placeholder="Ingrese el numero de documento">
                        {!! $errors->first('numDocumento', '<span class="help-block text-danger">:message </span>') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Nombre" class="text-secondary">Número de Teléfono</label>
                            @php($val_telefono = old('telefono') != '' ? old('telefono') : $usuario->telefono)
                            <input type="text" name="telefono"
                                class="form-control @error('telefono') is-invalid @enderror numero"
                                value="{{ $val_telefono }}" placeholder="Ingrese el numero de teléfono" required>

                            {!! $errors->first('telefono', '<span class="help-block text-danger">:message </span>') !!}
                        </div>
                    </div>
                </div>

                {{-- <div class="input-group a mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i><span
                            class="tooltiptext">Ingrese su Localidad</span></span>
                    </div>
                    <input type="text" class="form-control" name="nomLocalidad" placeholder="Localidad" value="{{$usuario->nomLocalidad}}">
            </div> --}}
                <!-- <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Contraseña">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password2" placeholder="Repita su Contraseña">
                </div> -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="Nombre" class="text-secondary">Dirección</label>
                            @php($val_direccion = old('direccion') != '' ? old('direccion') : $usuario->direccion)
                            <input type="text" name="direccion"
                                class="form-control @error('direccion') is-invalid @enderror"
                                value="{{ $val_direccion }}" placeholder="Ingrese la dirección" required>

                            {!! $errors->first('direccion', '<span class="help-block text-danger">:message </span>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="Nombre" class="text-secondary">Correo Electrónico</label>
                            @php($val_email = old('email') != '' ? old('email') : $usuario->email)
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ $val_email }}"
                                placeholder="Ingrese el numero de teléfono" required>

                            {!! $errors->first('email', '<span class="help-block text-danger">:message </span>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Nombre" class="text-secondary">Nueva Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Ingrese su nueva contraseña">
                            @error('password')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Nombre" class="text-secondary">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Confirme su nueva contraseña">
                            @error('password_confirmation')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="Nombre" class="text-secondary">Fotografia</label>
                            <input type="file" name="foto" id="Imagen"
                                accept="image/png, .jpeg, .jpg, image/gif" class="form-control" onchange="mostrar()">



                            {{-- @if ($usuario->foto != '') --}}
                            <img src="{{ asset('Imagen/' . $usuario->foto) }}" id="img" / width="100"
                                height="100">
                            {{-- @endif --}}
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    {{-- @if (count($errors) > 0)
                        <div style="margin: 0px auto 0px auto">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif --}}
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-info bg-teal">Confirmar</button>
                    </div>
                </div>
            </div>

        </div>
        {{ Form::Close() }}

    </div>
