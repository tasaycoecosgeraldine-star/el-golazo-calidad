<?php use App\Http\Controllers\ReporteRangoController as RC;?>
@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Reporte Alquiler/Reserva</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('rango.pdf', [$searchText, $searchText2, empty($searchText3) ? -1 : $searchText3, empty($searchText4) ? -1 : $searchText4]) }}"
                            target="_blank" title="Reporte en PDF" class="btn btn-default btn-sm">
                            <i class="fas fa-file-pdf" style="color: #df4747"></i>
                        </a>
                        <a href="{{ route('rango_excel.excel', [$searchText, $searchText2, empty($searchText3) ? -1 : $searchText3, empty($searchText4) ? -1 : $searchText4]) }}"
                            target="_blank" title="Reporte en Documento de Excel" class="btn btn-default btn-sm">
                            <i class="fas fa-file-excel" style="color: #0da358"></i>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('reporte.rango.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th title="N° de Reserva">N° R.</th>
                                <th>Fecha</th>
                                <th title="Hora de Registro">H. Inicio <br> H. Final</th>
                                <th>C. Deportivo</th>
                                <th>Cliente</th>
                                {{-- <th>Usuario</th> --}}
                                <th style="text-align: center">Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($cont = 1)
                            @foreach ($registro as $c)
                                <tr>
                                    <td># {{ $c->codRegistro }}</td>
                                    <td>{{ date('d/m/Y', strtotime($c->fechRegistro)) }}</td>
                                    <td>* {{ $c->horainicio }} <br> * {{ $c->horafinal }}</td>
                                    <td>{{ $c->nomLocalidad }}</td>
                                    <td>{{ $c->nomCliente }}</td>

                                    <td align="center">
                                        @if (RC::estadoPago($c->codRegistro))
                                            <a class="btn badge bg-teal " href="{{route('rango.show', $c->codRegistro)}}">
                                                {{ 'PAGADO' }}
                                            </a>
                                        @else
                                            <a class="btn badge bg-danger" href="{{route('rango.show', $c->codRegistro)}}">
                                                {{ 'ADEUDA' }}
                                            </a>
                                        @endif
                                    </td>
                                   <!--  <td style="text-align: center">
                                        <a href="{{ route('one-register.pdf', [$c->codRegistro]) }}" target="_blank"
                                            title="Reporte en PDF" class="btn btn-default btn-sm">
                                            <i class="far fa-file-pdf" style="color: #df4747"></i>
                                        </a>
                                    </td> -->
                                    <td>
                                        @if (!RC::estadoPago($c->codRegistro))
                                            <form action="{{ route('listado.destroy', $c->codRegistro) }}" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default btn-sm borrar text-danger"
                                                    title="Eliminar {{ $c->codRegistro }}"
                                                    data-nombre="Reserva {{ $c->nomLocalidad }} - {{ $c->nomCliente }}"><i
                                                        class="fa fa-trash"aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            {{ $registro->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3, 'searchText4' => $searchText4]) }}
        </div>

    </div>


    @push('scripts')
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
                    icon: 'success',
                    title: '{{ Session::get('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
    @endpush

@endsection
