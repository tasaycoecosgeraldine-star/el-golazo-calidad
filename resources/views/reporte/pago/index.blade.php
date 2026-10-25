<?php use App\Http\Controllers\ReporteRangoController as RC;?>
@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Reporte Pagos</span>
                </div>
                <div class="col-sm-6">
                    
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('reporte.pago.search')
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
                                <th>M. Pago</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($cont = 1)
                            @php($total = 0)
                            @foreach ($registro as $c)
                                <tr>
                                    <td># {{ $c->idPago }}</td>
                                    <td>{{ date('d/m/Y', strtotime($c->fechRegistro)) }}</td>
                                    <td>* {{ $c->horainicio }} <br> * {{ $c->horafinal }}</td>
                                    <td>{{ $c->nomLocalidad }}</td>
                                    <td>{{ $c->nomCliente }}</td>
                                    <td>{{ $c->metodoPago }}</td>
                                    <td align="right">{{ $c->importePago }}</td>
                                </tr>
                                @php($total += $c->importePago)
                            @endforeach
                            <tr>
                                <td colspan="5"></td>
                                <td style="text-align: right;">TOTAL</td>
                                <td style="text-align: right;">{{number_format($total, 2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $registro->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3, 'searchText4' => $searchText4]) }}
        </div>

    </div>

@endsection
