<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    <form action="{{ route('store_pago') }}" method="POST" id="form1">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-teal">
                    <span class="title_header_formulario">Agregar Pago</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="codRegistro" value="{{ $registro->codRegistro }}">
                    <div class="form-group row">
                        <div class="input-group mb-3">
                            <label for="">Método de Pago</label>
                            <div class="input-group">
                                <select name="metodoPago" id="" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($metodoPago as $m)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group mb-3">
                            <label for="">Importe</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="importePago" id="importePago"
                                    placeholder="Importe Pagado" value="{{ old('importePago') }}" max="{{$restante}}" required>
                            </div>
                        </div>
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
                        <button type="submit" class="btn btn-info bg-teal" id="enviar">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
