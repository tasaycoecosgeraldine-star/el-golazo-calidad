<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!!Form::model($empresa,['method'=>'PATCH','route'=>['ajustes.update',$empresa->idEmpresa], 'files'=>'true'])!!}
    {{Form::token()}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <input type="hidden" name="idEmpresa" value="{{$empresa->idEmpresa}}">
                <h4 class="modal-title" style="text-align: center; font-weight: bold">
                    Datos de la Empresa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-header p-3 mb-2  text-dark">
                    <div align="center" id="visual" height="100px" width="100px">
                        <img src="{{asset('Logo/'.$empresa->logo)}}" id="img" / width="100" height="100">
                    </div>
                    <div style="text-align: center;">
                        <span class="btn btn-primary bg-teal btn-xs btn-file">
                            <i class="fa fa-folder-open text-white" aria-hidden="true"></i>
                            <input type="file" name="Logo" id="Logo" accept="image/png, .jpeg, .jpg, image/gif"
                                onchange="mostrar()">
                        </span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="Nombre" class="text-secondary">Nombre de la Empresa</label>
                        @php($val_nombre = old('nombre') != '' ? old('nombre') : $empresa->nombre)
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                            value="{{$val_nombre}}" placeholder="Ingrese el nombre de la Empresa" required>
                        {!! $errors->first('nombre', '<span class="help-block text-danger">:message </span>') !!}
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="Direccion" class="text-secondary">Dirección</label>
                        @php($val_direccion = old('Direccion') != '' ? old('Direccion') : $empresa->direccion)
                        <input type="text" name="Direccion" id="Direccion" value="{{ $val_direccion }}"
                            class="form-control @error('Direccion') is-invalid @enderror"
                            placeholder="Ingrese la dirección de la empresa">
                        {!! $errors->first('Direccion', '<span class="help-block text-danger">:message </span>') !!}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="telefono" class="text-secondary">Teléfóno</label>
                        @php($val_telefono = old('telefono') != '' ? old('telefono') : $empresa->telefono)
                        <input type="text" name="telefono" id="telefono" value="{{ $val_telefono }}"
                            class="form-control @error('telefono') is-invalid @enderror numero"
                            placeholder="Ingrese numero de telefono">
                        {!! $errors->first('telefono', '<span class="help-block text-danger">:message </span>') !!}
                    </div>
                </div>

                <div class="modal-footer">
                    @if (count($errors)>0)
                    <div class="alert alert-danger" style="margin: 0px auto 0px auto">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>

                    </div>
                    @endif
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary bg-teal">Confirmar</button>
                    </div>
                </div>
            </div>

        </div>
        {{ Form::Close() }}

    </div>