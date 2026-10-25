<?php use App\Http\Controllers\ReporteRangoController as RC;?>
@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Pagos</span><br>
                    Reserva N° {{ $registro->codRegistro }}<br>
                    {{ $registro->numDocumento }} | {{ $registro->nombres }}<br>
                    {{ $registro->nomLocalidad }}<br>
                    {{ $registro->tarifa }} ({{ $registro->costoTarifa }})<br>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- @include('configuracion.localidad.search') --}}

                <div class="card-header">
                    @if (isset($caja))
                        @if ($caja->codUsuario == auth()->user()->codUsuario)
                            <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                                Nuevo <i class="fas fa-plus-circle" style="color: #cef5e1; margin-left: 10px"></i>
                            </a>
                        @else
                            <p>Otro usuario aperturó la caja.</p>
                        @endif
                    @else
                        <p>La caja no está aperturada.</p>
                    @endif
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th>Nro.</th>
                                <th>Fecha</th>
                                <th>Método Pago</th>
                                <th style="text-align: center">Importe</th>
                                <th style="text-align: center">Opciones</th>
                            </tr>
                        <tbody>
                            @php($cont = 1)
                            @php($total = 0)
                            @foreach ($pagos as $p)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td>{{ date('d/m/Y h:i:s A', strtotime($p->fechaPago)) }}</td>
                                    <td>{{ $p->metodoPago }}</td>
                                    <td style="text-align: right">{{ $p->importePago }}</td>
                                    <td style="text-align: center">
                                        @if (RC::valElimPago($p->idPago))
                                            <form action="{{ route('eliminarPago', $p->idPago) }}"
                                                style="margin-bottom: 0px" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default btn-sm borrar3"
                                                    title="Eliminar Pago N° {{ $p->idPago }}"
                                                    data-nombre="Eliminar Pago N° {{ $p->idPago }}"><i
                                                        class="fas fa-trash text-danger" aria-hidden="true"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @php($total += $p->importePago)
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td align="right">TOTAL</td>
                                <td align="right">{{ number_format($total, 2) }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td align="right">TARIFA</td>
                                <td align="right">{{ $registro->costoTarifa }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td align="right">ADEUDA</td>
                                @php($restante = $registro->costoTarifa - $total)
                                <td align="right">{{ number_format($restante, 2) }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ asset('reporte/rango') }}" class="btn btn-danger btn-sm">Volver</a>
                </div>
            </div>
        </div>
    </div>
    @include('reporte.rango.pago_create')
    @push('scripts')
        <script>
            document.querySelector('#form1').addEventListener('submit', function(e) {
                var form = this;

                e.preventDefault(); // <--- prevent form from submitting
                let myButton = document.getElementById('enviar');
                myButton.disabled = true;
                myButton.style.opacity = 0.7;
                myButton.textContent = 'Procesando ...';
                form.submit();
            });
        </script>
        @if (Session::has('success'))
            <script type="text/javascript">
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
        {{-- ----------------------------------------------- --}}
        @if (Session::has('error'))
            <script type="text/javascript">
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
    @endpush


@endsection
