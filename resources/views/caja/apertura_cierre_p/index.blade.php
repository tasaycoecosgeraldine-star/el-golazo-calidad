<?php use App\Http\Controllers\AperturaCierreController; ?>
@extends ('layouts.admin')
@section('contenido')
{{--
 {!!  Form::open(['url' => 'caja/apertura', 'method' => 'POST', 'autocomplete' => 'off']) !!}
        {{ Form::token() }}  --}}

        {{-- <form action="{{ URL::action('d@store') }}" method="POST" id="form"> --}}

    <div class="row">
        <div class="col-lg-7 col-md-12">
            @if (auth()->user()->tipo == 'ADMINISTRADOR')
                <a href="{{ asset('caja/apertura_cierre')}}" class="btn btn-info btn-sm">Volver Atras</a>
            @endif
            {{-- <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">Volver Atras</a> --}}
            <div class="card bg-header">
            @if (isset($registro))
                <div class="row" style="margin-left: 0px; margin-right: 0px;">
                    <!-- Column -->
                    <div class="col-lg-6 b-r">
                        <div class="card-body">
                            <div class="row text-center display-apertura m-t-40 m-b-40" style="display: block;">
                                <div class="col-sm-8 offset-sm-2">
                                    <h2 style="color: #d3d3d3;"><i class="fas fa-unlock"></i>
                                    </h2>
                                    <span class="p-2 bg-success text-white">ABIERTO</span><br><br>
                                    <h6>Ingrese los datos,<br>para abrir una caja</h6>
                                </div>
                            </div>
                            <div class="row text-center m-t-30 m-b-40 display-cierre">
                                <div class="col-sm-8 offset-sm-2">
                                    <h4 style="color: #d3d3d3;"><i class="mdi mdi-lock-open-outline display-3 m-t-40 m-b-10"></i>
                                    </h4>
                                    <span class="label label-success label-open m-b-20">ABIERTO</span><br>
                                    <h6 class="fecha-apertura">Abierto el día {{AperturaCierreController::fechaCastellano($registro->fechaApertura)}} a las {{$registro->horaApertura}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-6 p-0">
                        <div class="p-0">
                            {!!Form::open(array('url'=> route('apertura_cierre.update', $registro->codCaja) ,'method'=>'PUT','autocomplete'=>'off'))!!}
                            <form id="form-apertura" method="post"  novalidate="novalidate">
                                <div class="card-body bg-white" style="border-radius: .25rem;">
                                    <div class="row m-t-30">

                                        <div class="col-lg-12">
                                            <div class="form-group m-b-20 dec">
                                                <label class="font-13 text-inverse">INGRESE MONTO DE CIERRE</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-white text-muted" style="display: grid;">
                                                            <small class="text-left">EFE</small>
                                                            <div class="text-left font-medium">S/</div>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="montoCierre" id="montoCierre" class="form-control form-control-lg montoCierre" style="height: 58px;border-left: 0px; border-right: 0px;" id="monto_aper" value="" autocomplete="off" required data-fv-field="onlyNum">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-white text-muted">Soles</span>
                                                    </div>
                                                </div>
                                            <div class="help-block" data-fv-validator="notEmpty" data-fv-for="onlyNum" data-fv-result="NOT_VALIDATED" style="display: none;">Dato obligatorio</div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-white">
                                    <a  class="btn btn-danger btn-block cerrar_o text-light">CERRAR CAJA</a>
                                    <button type="submit" style="display: none" class="btn btn-danger btn-block btn-aceptar-apertura cerrar">CERRAR CAJA</button>
                                </div>
                            </form>
                            {!!  Form::close() !!}

                        </div>
                    </div>
                </div>
            @else
                <div class="row" style="margin-left: 0px; margin-right: 0px;">
                    <!-- Column -->
                    <div class="col-lg-6 b-r">
                        <div class="card-body">
                            <div class="row text-center display-apertura m-t-40 m-b-40" style="display: block;">
                                <div class="col-sm-8 offset-sm-2">
                                    <h2 style="color: #d3d3d3;"><i class="fas fa-lock"></i>
                                    </h2>
                                    <span class="p-2 bg-danger text-white">CERRADO</span><br><br>
                                    <h6>Ingrese los datos,<br>para abrir una caja</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-6 p-0">
                        <div class="p-0">
                            {!!  Form::open(['url' => 'caja/apertura_cierre', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            {{ Form::token() }}
                            <form id="form-apertura" method="post" class="display-apertura fv-form fv-form-bootstrap" >
                                {{-- {{ csrf_field() }} --}}
                                <div class="card-body bg-white" style="border-radius: .25rem;">
                                    <div class="row m-t-30">

                                        <div class="col-lg-12">
                                            <div class="form-group m-b-20 dec">
                                                <label class="font-13 text-inverse">INGRESE MONTO DE APERTURA</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-white text-muted" style="display: grid;">
                                                            <small class="text-left">EFE</small>
                                                            <div class="text-left font-medium">S/</div>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="montoApertura" class="form-control form-control-lg montoApertura" style="height: 58px;border-left: 0px; border-right: 0px;" id="montoApertura" value="" autocomplete="off" required="" data-fv-field="onlyNum">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-white text-muted">Soles</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="codLocalidad" id="" value="{{auth()->user()->codLocalidad}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-white">
                                    <a href="#" class="btn btn-success btn-block aperturar_o text-light">ABRIR CAJA</a>
                                    <button type="submit" class="btn btn-success btn-block aperturar" style="display: none">ABRIR CAJA</button>
                                </div>
                            </form>
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </div>
    {{-- style="margin-left:auto; margin-right:auto;" --}}
    {{-- <form action="#" method="POST" id="form" >
        {{ csrf_field() }}

    </form> --}}


   {{-- {!!  Form::close() !!}  --}}



@push('scripts')
<script>
    $('.montoApertura').on('input', function () {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });
</script>
<script>
    $('.montoCierre').on('input', function () {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });
</script>
<script>
    $('.cerrar_o').unbind().click(function() {
        // var $button = $(this);
        var importe = document.getElementById('montoCierre').value;
        if(importe === ''){
            $(".cerrar").click();
        }else{
            Swal.fire({
                title: 'Necesitamos de tu Confirmación',
                showDenyButton: true,
                confirmButtonColor: '#36BE80',
                html: 'Se cerrará la caja con los siguientes datos:' +
                '<table class="table text-nowrap"><tr><td>Importe</td><td> S/ ' + importe  + '</td></tr></table>' +
                '<span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                confirmButtonText: `Sí, Adelante!`,
                denyButtonText: `Cancelar`,
                icon: 'info',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(".cerrar").click();
                }
            })
            return false;
            }
    });
</script>
<script>
    $('.aperturar_o').unbind().click(function() {
        // var $button = $(this);
        var importe = document.getElementById('montoApertura').value;
        if(importe === ''){
            $(".aperturar").click();
        }else{
            Swal.fire({
                title: 'Necesitamos de tu Confirmación',
                showDenyButton: true,
                confirmButtonColor: '#36BE80',
                html: 'Se aperturara la caja con los siguientes datos:' +
                '<table class="table text-nowrap"><tr><td>Importe</td><td> S/ ' + importe  + '</td></tr></table>' +
                '<span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                confirmButtonText: `Sí, Adelante!`,
                denyButtonText: `Cancelar`,
                icon: 'info',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(".aperturar").click();
                }
            })
            return false;
            }
    });
</script>
@if (Session::has('success'))
<script type="text/javascript">
    Swal.fire({
        title: 'Proceso Terminado',
        confirmButtonColor: '#36BE80',
        html: 'La caja ha sido cerrada.<br>'+
        'Puede imprimir el arqueo de caja, para obtener el detalle de sus procesos.<br>' +
        '<span><a href="{{route('arqueo_caja.pdf', [Session::get('success')])}}" target="_blank"><i class="fas fa-print"></i><br>Arqueo de Caja</a> </span><br>',
        confirmButtonText: `Aceptar`,
        icon: 'success',
    })

</script>
@endif

@if (Session::has('flash'))
<script type="text/javascript">
    Swal.fire({
        title: 'Aviso',
        confirmButtonColor: '#36BE80',
        html: '<span> {{Session::get('flash')}} </span><br>',
        confirmButtonText: `Aceptar`,
        icon: 'success',
    })
</script>
@endif
@endpush
@endsection
