{!! Form::open(['url' => 'registro/cliente', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="row">
    <div class="col-lg-6 col-12">
        @php($searchText = $searchText == 'TODO' ? '' : $searchText)
        <input type="text" name="searchText" class="form-control float-right" value="{{ $searchText }}" placeholder="Buscar ...">
        {{-- <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}"> --}}

    </div>
    <div class="col-lg-6 col-12">
        <button type="submit" class="btn btn-secondary">
            <i class="fas fa-search"></i>
        </button>
    </div>
</div>

{{ Form::close() }}
