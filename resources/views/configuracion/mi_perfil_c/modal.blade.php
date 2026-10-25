<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add-{{$cliente->codCliente}}">
    {!!Form::model($cliente,['method'=>'PATCH','route'=>['mi_perfil_c.update',$cliente->codCliente], 'files'=>'true'])!!}
    {{Form::token()}}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }
    </style>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <span class="title_header_formulario">
                    Mi perfíl</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if (count($errors)>0)
                        <div style="margin: 0px auto 0px auto">
                            <div class="alert alert-danger">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
            <div class="modal-body">
                <div class="input-group a mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-id-card fa-2x-x"></i><span
                            class="tooltiptext">Ingrese su N° de Documento</span></span>
                    </div>
                    <input type="hidden" name="codCliente" id="" value="{{$cliente->codCliente}}">
                    @php($val_numDocumento = empty(old('numDocumento')) ? $cliente->numDocumento : old('numDocumento'))
                    <input type="text" class="form-control @error('numDocumento') is-invalid @enderror" name="numDocumento" placeholder="Número de Documento" value="{{ $val_numDocumento}}">
                </div>
                <div class="input-group a mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-pen fa-2x-x"></i><span
                            class="tooltiptext">Ingrese su Nombre</span></span>
                    </div>
                    @php($val_nombres = empty(old('nombres')) ? $cliente->nombres : old('nombres'))
                    <input type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres" placeholder="Nombres" value="{{ $val_nombres }}">
                </div>
                <div class="input-group a mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt fa-2x-x"></i><span
                            class="tooltiptext">Ingrese su Dirección</span></span>
                    </div>
                    @php($val_direccion = empty(old('direccion')) ? $cliente->direccion : old('direccion'))
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" placeholder="Dirección" value="{{ $val_direccion}}">
                </div>
                <div class="input-group a mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone fa-2x-x"></i><span
                            class="tooltiptext">Ingrese su N° de Celular</span></span>
                    </div>
                    @php($val_telefono = empty(old('telefono')) ? $cliente->telefono : old('telefono'))
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" placeholder="Teléfono" value="{{ $val_telefono }}">
                </div>
                <div class="input-group a mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-at fa-2x-x"></i><span
                            class="tooltiptext">Ingrese su Correo</span></span>
                    </div>
                    @php($val_email = empty(old('email')) ? $cliente->email : old('email'))
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Correo Electrónico" value="{{ $val_email}}" required>

                </div>
                <div class="input-group a mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key fa-2x-x"></i><span
                            class="tooltiptext">Ingrese su Nueva Contraseña</span></span>
                    </div>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    placeholder="Ingrese su nueva contraseña" >
                </div>
                <div class="input-group a mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-image fa-2x-x"></i><span
                                class="tooltiptext">Ingrese su Fotografía</span></span>
                        </div>
                        <input type="file" name="foto" id="Imagen" accept="image/png, .jpeg, .jpg, image/gif" class="form-control" onchange="mostrar()">
                    </div>
                    <div>
                        {{-- @if($usuario->foto != "") --}}
                        <img src="{{asset('Imagenes/Fotos/'.$cliente->foto)}}" id="img" / width="100" height="100">
                        {{-- @endif --}}
                    </div>

                </div>

                <div class="modal-footer">
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info bg-teal">Confirmar</button>
                    </div>
                </div>
            </div>

        </div>
        {{ Form::Close() }}

    </div>
