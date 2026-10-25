{!! Form::open(['url' => 'almacen/categoria', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">
    <h3 class="card-title" >
        {{-- <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
            Nuevo <i class="fas fa-plus-circle" style="color: #cef5e1; margin-left: 10px"></i>
        </a> --}}
        <div class="p-2 flex-shrink-0 bd-highlight">
            <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
            </a>
        </div>
    </h3>
    <div class="card-tools">
        <div class="input-group input-group-sm" >
            <input type="text" name="searchText" class="form-control float-right" value="{{$searchText}}">
            {{-- <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}"> --}}
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
