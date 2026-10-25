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
        'url' => route('producto.update', $producto->codProducto),
        'method' => 'PUT',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title title_header" id="exampleModalLongTitle">
                        Editar Producto
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="nomProducto">Nombre de Producto</label>
                                        <div class="input-group a mb-3">

                                            <input type="text" class="form-control fi" name="nomProducto"
                                                id="nomProducto" value="{{ $producto->nomProducto }}" />
                                        </div>
                                        @if ($errors->has('nomProducto'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('nomProducto') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nomProducto">Ingrese Precio de Producto</label>
                                        <div class="input-group a mb-3">

                                            <input type="hidden" name="Precio" id=""
                                                value="{{ $producto->codProducto }}">
                                            <input type="text"
                                                class="form-control fi {{ $errors->has('Precio') ? 'is-invalid' : '' }}"
                                                id="Precio" name="Precio" placeholder="Precio"
                                                @if (empty(old('Precio'))) value="{{ $producto->Precio }}"
                                    @else
                                        value="{{ old('Precio') }}" @endif>
                                        </div>
                                        @if ($errors->has('Precio'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('Precio') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="stock">Ingrese Stock de Producto</label>
                                        <div class="input-group a mb-3">

                                            <input type="hidden" name="stock" id=""
                                                value="{{ $producto->codProducto }}">
                                            <input type="text"
                                                class="form-control fi {{ $errors->has('stock') ? 'is-invalid' : '' }}"
                                                id="stock" name="stock" placeholder="Stock"
                                                @if (empty(old('stock'))) value="{{ $producto->stock }}"
                                    @else
                                        value="{{ old('stock') }}" @endif>
                                        </div>
                                        @if ($errors->has('stock'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('stock') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="stock">Seleccione Categoria</label>
                                        <div class="input-group a mb-3">

                                            <select class="custom-select" name="codCategoria">
                                                @foreach ($categoria as $c)
                                                    @if ($c->codCategoria == old('codCategoria'))
                                                        <option value="{{ $c->codCategoria }}"selected>{{ $c->nombre }}
                                                        </option>
                                                    @elseif ($c->codCategoria == $producto->codCategoria)
                                                        <option value="{{ $c->codCategoria }}"selected>{{ $c->nombre }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $c->codCategoria }}">{{ $c->nombre }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('codCategoria'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('codCategoria') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="nomProducto">Seleccione Imagen</label>
                                        <div class="input-group a mb-3">

                                            <input type="file" class="form-control " id="Imagen" name="imagen">
                                        </div>
                                        @if ($errors->has('imagen'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('imagen') }}</span>
                                            </div>
                                        @endif
                                        <div id="img2" class="imagen ">
                                            <img src="{{ asset('Imagen/' . $producto->imagen) }}" width="100"
                                                height="100">

                                        </div>
                                    </div>
                                </div>


                            </div>




                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer text-center">
                <div style="margin: 0px auto 0px auto">
                    <a href="{{ route('producto.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
