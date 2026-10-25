<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-add-{{ $c->codRegistro }}">
    {!! Form::model($registro, [
        'method' => 'PATCH',
        'route' => ['listado.update', $c->codRegistro],
        'files' => 'true',
    ]) !!}
    {{ Form::token() }}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }
    </style>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <h4 class="modal-title">
                    Editar Reserva</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="">Estado</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-pen"></i></span>
                            </div>
                            <select name="estado" id="" class="form-control">
                                @if ($c->estado == 'SIN CONFIRMAR')
                                    <option value="SIN CONFIRMAR" selected>SIN CONFIRMAR</option>
                                    <option value="CONFIRMADO">CONFIRMADO</option>
                                @else
                                    <option value="SIN CONFIRMAR">SIN CONFIRMAR</option>
                                    <option value="CONFIRMADO" selected>CONFIRMADO</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="">Pago recibido</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input type="hidden" name="codRegistro" id="" value="{{ $c->codRegistro }}">
                            <input type="text" class="form-control" name="pago" placeholder="Ejm. 25.00"
                                value="{{ $c->pago }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="">Método de Pago</label>
                        <div class="input-group mb-3">
                            <select name="metodoPago" class="form-control">
                                <option value="">Seleccionar</option>
                                @foreach (['EFECTIVO', 'TRANSFERENCIA'] as $m)
                                    <option value="{{ $m }}" {{$c->metodoPago == $m ? 'selected' : ''}}>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="">Comentario</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                            </div>
                            <textarea name="comentario" class="form-control" id="" cols="30" rows="4"
                                placeholder="Ingrese un comentario (OPCIONAL)">{{ $c->comentario }}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="">Adjuntar</label>
                        <div class="input-group mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-image"></i></span>
                                </div>
                                <input type="file" class="form-control" id="Imagen2" name="imgComprobante">
                            </div>
                            <div id="img2" class="imagen">
                                {{-- <img src="{{asset('Imagen/'.$r->foto)}}"  width="100" height="100"> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12" style="text-align: center">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-12" style="text-align: center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary bg-teal">Continuar</button>
                        {{-- @if (isset($caja))
                            @if ($caja->codUsuario == auth()->user()->codUsuario)
                                <button type="submit" class="btn btn-primary bg-teal">Continuar</button>
                            @else
                                <p>Otro usuario aperturó la caja.</p>
                            @endif
                        @else
                            <p>La caja no está aperturada.</p>
                        @endif --}}
                    </div>
                </div>
            </div>

        </div>
        {{ Form::Close() }}
    </div>
    <script>
        document.getElementById("Imagen2").onchange = function(e) {

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
