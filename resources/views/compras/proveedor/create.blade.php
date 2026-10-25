<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'compras/proveedor', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    {!! Form::token() !!}
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-teal">
                <span class="title_header_formulario">Nuevo Proveedor</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="nomPro">Nombre</label>
                    <input type="text" name="nomPro" class="form-control" value="{{ old('nomPro') }}"
                        placeholder="Ingrese el nombre del proveedor" required>
                </div>
                <div class="form-group">
                    <label for="phone">N° Teléfono</label>
                    <input type="text" name="phone" class="form-control numero"
                        placeholder="Ingrese el número de teléfono" value="{{ old('phone') }}">
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
