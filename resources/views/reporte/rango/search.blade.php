{!! Form::open(['url' => 'reporte/rango', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">
    <div class="row">
        <div class="col-md-2 col-6">
            <div class="form-group">
                <input type="date" name="searchText" class="form-control" value="{{$searchText}}">
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="form-group">
                <input type="date" name="searchText2" class="form-control" value="{{$searchText2}}">
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="form-group">
                <input type="text" name="searchText3" class="form-control" value="{{$searchText3}}">
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="form-group">
                <select name="searchText4" id="" class="form-control selectpicker" data-live-search="true">
                    <option value=""> Todos los campos deportivos </option>
                    @foreach ($localidades as $l)
                        <option value="{{ $l->codLocalidad }}" {{$searchText4 == $l->codLocalidad ? 'selected' : ''}}>{{$l->nomLocalidad}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-1 col-12">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>
{{ Form::close() }}
