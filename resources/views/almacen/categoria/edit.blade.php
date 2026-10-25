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
        'url' => route('categoria.update', $categoria->codCategoria),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title title_header" id="exampleModalLongTitle">
                        Editar Categoría
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="nombre" class="text-secondary" style="color: black;">Nombre</label>
                                        @php($val_nombre = old('nombre') != '' ? old('nombre') : $categoria->nombre)
                                        <input type="hidden" name="codCategoria" id=""
                                            value="{{ $categoria->codCategoria }}">
                                        <input type="text" name="nombre"
                                            class="form-control @error('nombre') is-invalid @enderror"
                                            value="{{ $val_nombre }}" placeholder="Ingrese el nombre de la categoría"
                                            required>
                                        {!! $errors->first('nombre', '<span class="help-block text-danger">:message </span>') !!}
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="descripcion" class="text-secondary"
                                            style="color: black;">Descripción</label>
                                        <input type="hidden" name="codCategoria" id=""
                                            value="{{ $categoria->codCategoria }}">
                                        <div class="input-group a mb-3">
                                            <textarea name="descripcion" id="" cols="50" rows="5"
                                                class="form-control fi @error('descripcion') is-invalid @enderror"
                                                placeholder="Ingrese la descripción de la categoría">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                                            {!! $errors->first('descripcion', '<span class="help-block text-danger">:message </span>') !!}
                                        </div>
                                    </div>
                                </div> --}}




                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-center">
                    <div style="margin: 0px auto 0px auto">
                        <div style="margin: 0px auto 0px auto">
                            <a href="{{ route('categoria.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
@endsection
