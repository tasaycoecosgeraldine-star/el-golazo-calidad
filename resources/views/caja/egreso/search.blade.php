{!! Form::open(['url' => 'caja/egreso', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
@php($total_ingreso = 0)
@php($total_registro = 0)
@foreach ($egreso as $item)
    @php($total_ingreso += $item->importe)
    @php($total_registro += 1)
@endforeach
<div class="card-header">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-2">
            <p style="text-align: center"><span style="font-weight: bold; color: #ffa755; font-size: 1.5em">S/ {{number_format($total_ingreso, 2)}}</span><br>
                <span style="font-weight: bold; color: #09355e">Total</span></p>
        </div>
        <div class="col-12 col-sm-6 col-md-2">
            <p style="text-align: center"><span style="font-weight: bold; color: #ffa755; font-size: 1.5em">{{$total_registro}}</span><br>
                <span style="font-weight: bold; color: #09355e">N° de Registros</span></p>
        </div>
        <div class="col-12 col-sm-6 col-md-2">
            <label for="tipo">Tipo</label>
            <select name="searchText" id="" class="form-control">
                <option value="" selected >Seleccionar</option>
                @foreach ($tipo as $item)
                    @if ($searchText == $item)
                        <option value="{{$item}}" selected>{{$item}}</option>
                    @else
                        <option value="{{$item}}">{{$item}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-2">
            <label for="Estado">Estado</label>
            <select name="searchText2" id="" class="form-control">
                <option value="" selected >Seleccionar</option>
                @foreach ($estado as $item)
                    @if ($searchText2 == $item)
                        <option value="{{$item}}" selected>{{$item}}</option>
                    @else
                        <option value="{{$item}}">{{$item}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <label for="">Busqueda</label>
            <input type="text" name="searchText3" class="form-control" value="{{$searchText3}}">
        </div>
        <div class="col-12 col-sm-6 col-md-1">
            <div class="input-group-append">
                <button type="submit" class="btn btn-success" style="margin: 25px auto auto auto">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

</div>
{{ Form::close() }}
