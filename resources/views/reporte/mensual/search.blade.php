{!! Form::open(['url' => 'reporte/mensual', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">
    <h3 class="card-title" >
        {{-- <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
            Nuevo  <i class="fas fa-user-plus" style="color: #cef5e1; margin-left: 10px" ></i>
        </a> --}}
    </h3>
    <div class="card-tools">
        <div class="input-group input-group-sm" >
           
            <select name="searchText2" id="" class="form-control">
                @if($searchText2 == '')
                    @php($searchText2 = date('Y'))
                @endif
                @foreach ($anios_vista as $item)
                    @if ($searchText2 == $item)
                        <option value="{{$item}}" selected>{{$item}}</option>
                    @else
                        <option value="{{$item}}" >{{$item}}</option>
                    @endif
                @endforeach
            </select>
            <select name="searchText" id="" class="form-control">
                @if($searchText == '')
                    @php($searchText = date('m'))
                @endif
                @php($cont = 1)
                @foreach ($meses as $item)
                    @if ($searchText == $cont)
                        <option value="{{$cont}}" selected>{{$item}}</option>
                    @else
                        <option value="{{$cont}}" >{{$item}}</option>
                    @endif

                    @php($cont += 1)
                @endforeach
            </select>
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
