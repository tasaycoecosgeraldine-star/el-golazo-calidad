@extends ('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Compra</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{route('list_compra.pdf', [$searchText, $searchText2])}}" class="btn btn-default"  target="_blank">
                            <i class="fas fa-file-pdf text-danger" title="Reporte de Compras - PDF"></i>
                        </a>
                        <a href="{{route('list_compra.excel', [$searchText, $searchText2])}}" class="btn btn-default"  target="_blank">
                            <i class="fas fa-file-excel text-success" title="Reporte de Compras - EXCEL"></i>
                        </a>
                        <a href="{{route('list_compraDetalladoE.excel', [$searchText, $searchText2])}}" class="btn btn-default"  target="_blank">
                            {{-- <i class="fas fa-file-excel text-success"></i> --}}
                            <i class="far fa-file-excel text-success" title="Reporte de Compras Detallado"></i>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <a href="compra/create" class="btn btn-success"> Nuevo </a>
            </div>
        </div>
    </div>
        @include('compras.compra.search')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-condensed table-hover">
                    <thead class="bg-teal">
                        <tr>
                            <th>#</th>
                            <th>FECHA</th>
                            <th>HORA</th>
                            <th>PROVEEDOR</th>
                            <th align="right">TOTAL</th>
                            <th align="center">OPCIONES</th>
                        </tr>
                    </thead>
                    @php($cont = 1)
                    @foreach ($ingresos as $ing)
                        <tr>
                            <td>{{ $cont++ }}</td>
                            <td>{{ date('d/m/Y', strtotime($ing->fecCom)) }} </td>
                            <td>{{ date('H:i:s', strtotime($ing->fecCom)) }}</td>
                            <td>{{ $ing->nomPro }}</td>
                            {{-- <td>{{ $ing ->tipo_comprobante. ': '. $ing ->serie_comprobante. '-'. $ing ->num_comprobante}}</td> --}}

                            <td align="right">{{ $ing->total }}</td>
                            {{-- <td>{{ $ing ->estado}}</td> --}}

                            <td align="center">
                                <a href="{{ route('compra.show', $ing->idCom) }}"> <button
                                        class="btn btn-primary btn-sm">Detalles</button> </a>
                                {{-- <a href="#" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal"> <button class="btn btn-danger">Anular</button> </a> --}}
                            </td>
                        </tr>
                        {{-- @include('compras.compra.modal') --}}
                    @endforeach
                </table>
            </div>
            {{ $ingresos->appends(['searchText' => $searchText, 'searchText2' => $searchText2]) }}
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
    @endpush
@endsection
