@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Reporte Mensual</span>
                </div>
                <div class="col-sm-6">
                    <span class="breadcrumb float-sm-right">
                    @php($searchText4 = empty($searchText4) ? 'TODO' : $searchText4)
                        <a href="{{route('mensual.pdf',[$searchText, $searchText2, $searchText4])}}" target="_blank" title="Reporte en PDF"
                            class="btn btn-default btn-sm" >
                            <i class="fas fa-file-pdf" style="color: #df4747"></i>
                        </a>
                        <a href="{{route('mensual_excel.excel',[$searchText, $searchText2, $searchText4])}}" target="_blank" title="Reporte en Documento de Excel"
                            class="btn btn-default btn-sm">
                            <i class="fas fa-file-excel" style="color: #0da358"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('reporte.mensual.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-striped table-condensed table-hover">
                        <thead class="bg-teal">
                            {{-- <th>Id</th> --}}
                            <th>N°</th>
                            <th>Fecha</th>
                            <th style="text-align: right">Reservas</th>
                            <th style="text-align: right">Ventas</th>
                            <th style="text-align: right">Ingresos</th>
                            <th style="text-align: right">Egresos</th>
                            <th style="text-align: right">Total</th>
                        </thead>
                    @php($total_reserva = 0)
                    @php($total_ventas = 0)
                    @php($total_ingreso= 0)
                    @php($total_egreso = 0)
                    @php($contador = 0)
                    @foreach ($array_fechas as $item)
                    @php($contador += 1)
                    @php($valor_item = explode('_', $item))
                        <tr>
                            <td>{{$contador}}</td>
                            <td>{{date('d/m/Y', strtotime($valor_item[0]))}}</td>
                        @if ($valor_item[0] <= $fecha)
                            <td style="text-align: right">+ $ {{$valor_item[1]}}</td>
                            <td style="text-align: right">+ $ {{$valor_item[2]}}</td>
                            <td style="text-align: right">+ $ {{$valor_item[3]}}</td>
                            <td style="text-align: right">- $ {{$valor_item[4]}}</td>
                            <td style="text-align: right">$ {{number_format(floatval($valor_item[1]) + floatval($valor_item[2]) + floatval($valor_item[3]) - floatval($valor_item[4]), 2)}}</td>
                        @else
                            <td></td><td></td><td></td><td></td><td></td>
                        @endif

                        </tr>
                        @php($total_reserva += floatval($valor_item[1]))
                        @php($total_ventas += floatval($valor_item[2]))
                        @php($total_ingreso += floatval($valor_item[3]))
                        @php($total_egreso += floatval($valor_item[4]))
                    @endforeach
                        <tr style="font-weight: bold">
                            <td colspan="2">TOTAL </td>
                            <td style="text-align: right">$ {{number_format($total_reserva,2)}}</td>
                            <td style="text-align: right">$ {{number_format($total_ventas,2)}}</td>
                            <td style="text-align: right">$ {{number_format($total_ingreso,2)}}</td>
                            <td style="text-align: right">$ {{number_format($total_egreso,2)}}</td>
                            <td style="text-align: right">$ {{number_format($total_reserva + $total_ventas + $total_ingreso - $total_egreso,2)}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>


    @endsection

