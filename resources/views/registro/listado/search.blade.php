{!! Form::open(['url' => 'registro/listado', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="row mt-3 mb-3">
    @if (auth()->user()->tipo == 'ADMINISTRADOR')
        <div class="col-md-4 col-12">
            <div class="input-group" style="margin-bottom: 10px">
                <select name="searchText3" id="" class="form-control form-control-sm selectpicker" data-live-search="true">
                    <option value="TODO"> Todas las localidades </option>
                    @foreach ($localidad as $l)
                        <option value="{{ $l->nomLocalidad }}" {{$searchText3 == $l->nomLocalidad ? 'selected' : ''}} style="font-size: 0.75em">
                            {{ $l->nomLocalidad }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <div class="col-md-3 col-12">
        <input type="date" name="searchText" class="form-control form-control-sm float-right" value="{{ $searchText }}">
            @if ($searchText2 == 'TODO')
                @php($searchText2 = '')
            @endif
    </div>
    <div class="col-md-4 col-12">
        <input type="text" class="form-control form-control-sm" name="searchText2" placeholder="Buscar..." value="{{ $searchText2 }}">
    </div>
    <div class="col-md-1 col-12">
        <button type="submit" class="btn btn-default btn-sm bg-teal">
            <i class="fas fa-search"></i>
        </button>
    </div>
</div>

{{ Form::close() }}
