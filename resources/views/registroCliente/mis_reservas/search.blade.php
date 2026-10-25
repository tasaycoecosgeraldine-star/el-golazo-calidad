{!! Form::open(['url' => 'registroCliente/mis_reservas', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}

<div class="card-header">
    <div class="row">

        <div class="col-12 col-sm-6 col-md-3">
            <label for="" class="text-secondary">Fecha Inicial</label>
            <input type="date" name="searchText" class="form-control float-right" value="{{$searchText}}">
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <label for="" class="text-secondary">Fecha Final</label>
            <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}">
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <label for="" class="text-secondary">Busqueda</label>
            @php($searchText3 = $searchText3 == 'TODO' ? '' : $searchText3)
            <input type="text" class="form-control" name="searchText3" value="{{$searchText3}}">
        </div>
        <div class="col-12 col-sm-6 col-md-2">
            <button type="submit" class="btn btn-default bg-teal" style="margin: 25px auto auto auto">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>
{{ Form::close() }}
