@extends('layouts.client')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Mis Reservas</span>
                </div>
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                        <a href="{{route('list-register.pdf',[$searchText, $searchText2, $searchText3])}}" target="_blank" title="Reporte en PDF del Listado de Reservas"
                            class="btn btn-default btn-sm" >
                        <i class="fas fa-file-pdf" style="color: #df4747"></i>
                        </a>
                    </ol> --}}

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('registroCliente.mis_reservas.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th title="N° de Reserva">N° R.</th>
                                <th>Fecha</th>
                                <th>H. Inicio - H. Final</th>
                                <th>Localidad</th>
                                <th>Nota</th>
                                <th style="text-align: center">Estado</th>
                                <th style="text-align: center">Pago</th>
                                <th colspan="2" style="text-align: center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($cont = 1)
                            @foreach ($registro as $r)
                                <tr>
                                    <td># {{ $r->codRegistro }}</td>
                                    <td>{{ date('d/m/Y', strtotime($r->fechRegistro)) }}</td>
                                    <td>{{ $r->horainicio }} - {{ $r->horafinal }}</td>
                                    <td>{{ $r->nomLocalidad}}</td>
                                    <td>{{$r->comentario}}</td>
                                    <td align="center">
                                        @if ($r->estado == 'SIN CONFIRMAR')
                                            <span class="btn badge bg-danger apertura" title="Editar {{ $r->fechRegistro }}" data-target="#modal-add-{{$r->codRegistro}}" data-toggle="modal">
                                                {{ $r->estado}}
                                            </span>
                                        @elseif ($r->estado == 'CONFIRMADO')
                                            <span class=" badge bg-teal">{{ $r->estado}}</span>
                                        @endif
                                    </td>
                                    <td align="right">{{ $r->pago}}</td>
                                    <td>
                                        @if (!empty($r->imgComprobante))
                                            <a href="{{ asset('imgComprobante/' . $r->imgComprobante) }}" target="_black" title="Comprobante">
                                                <img src="{{ asset('imgComprobante/' . $r->imgComprobante) }}" width="50" height="50" class="img-thumbnail">
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($r->estado == 'CONFIRMADO')
                                            <a href="{{route('one_registerc.pdf',[$r->codRegistro])}}" target="_blank" title="Reporte en PDF"
                                            class="btn btn-default btn-sm" >
                                            <i class="far fa-file-pdf" style="color: #df4747"></i>
                                            </a>
                                        @else
                                            <form action="{{route('mis_reservas.destroy', $r->codRegistro) }}" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default btn-sm borrar text-danger" title="Eliminar {{ $r->codRegistro }}"
                                                    data-nombre="Reserva {{ $r->nomLocalidad }} - {{ $r->nomCliente }}"><i class="fa fa-trash"aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                                @include('registroCliente.mis_reservas.finalizar')
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            {{$registro->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3])}}
        </div>
    </div>

@endsection
