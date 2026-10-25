<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'almacen/producto', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
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
                <span class="title_header_formulario">Nuevo Producto</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body" id="formulario">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nomProducto">Nombre de Producto</label>
                                <input type="text" class="form-control" name="nomProducto" id="nomProducto"
                                    aria-label="Nombre de Producto" placeholder="Nombre de Producto"
                                    value="{{ old('nomProducto') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nomProducto">Ingrese Precio del Producto</label>
                                <input type="text" class="form-control" name="Precio" id="Precio"
                                    placeholder="Precio del Producto" value="{{ old('Precio') }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nomProducto">Ingrese Stock</label>
                                <input type="text" class="form-control" name="stock" id="stock"
                                    placeholder="Stock del Producto" value="{{ old('stock') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nomProducto">Seleccione Categoría</label>
                                <select class="custom-select fi" name="codCategoria">
                                    @foreach ($categoria as $c)
                                        <option value="{{ $c->codCategoria }}" {{old('codCategoria') == $c->codCategoria ? 'selected' : ''}}> {{ $c->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">

                                <label for="nomProducto">Seleccione Imagen</label>
                                <input type="file" class="form-control " id="Imagen" name="imagen">
                            </div>
                        </div>
                    </div>
                    <div id="img" class="imagen"></div>
                </div>
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
                    <button type="submit" class="btn btn-primary bg-teal">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{ Form::Close() }}
