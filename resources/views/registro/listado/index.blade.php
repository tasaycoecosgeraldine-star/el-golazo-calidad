@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Listado de Reservas</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{route('list-register.pdf',[$searchText, $searchText2, $searchText3])}}" target="_blank" title="Reporte en PDF del Listado de Reservas"
                            class="btn btn-default btn-sm" >
                        <i class="fas fa-file-pdf" style="color: #df4747"></i>
                        </a>
                    </ol>

                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('registro.listado.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th>#</th>
                                <th title="N° de Reserva">COD</th>
                                <th>Fecha</th>
                                <th>H. Inicio - H. Final</th>
                                @if (auth()->user()->tipo == 'ADMINISTRADOR')
                                <th>Localidad</th>
                                @endif
                                <th>Cliente</th>
                                <th>Usuario</th>
                                <th>Nota</th>
                                <th>Estado</th>
                                <th>Pago</th>
                                <th colspan="3">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($cont = 1)
                            @foreach ($registro as $r)
                                @php($explod_nomCliente = count(explode(' ', $r->nomCliente)) > 1 ? explode(' ', $r->nomCliente)[0] . ' ' . explode(' ', $r->nomCliente)[1] : $r->nomCliente)
                                @php($explod_nomUsuario = count(explode(' ', $r->nomUsuario)) > 0 ? explode(' ', $r->nomUsuario)[0] : $r->nomUsuario)
                                @php($explod_nomUsuario = $r->tipo == 'WEB' ? $r->tipo : $explod_nomUsuario)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td> {{ $r->codRegistro }}</td>
                                    <td>{{ date('d/m/Y', strtotime($r->fechRegistro)) }}</td>
                                    <td>{{ $r->horainicio }} - {{ $r->horafinal }}</td>
                                    @if (auth()->user()->tipo == 'ADMINISTRADOR')
                                    <td>{{ $r->nomLocalidad}}</td>
                                    @endif
                                    <td>{{ $explod_nomCliente }}</td>
                                    <td>{{ $explod_nomUsuario }}</td>
                                    <td>{{ $r->comentario }}</td>
                                    <td align="center">
                                        @if ($r->estado == 'SIN CONFIRMAR')
                                            <span class="btn badge bg-danger apertura" title="Editar {{ $r->fechRegistro }}" data-target="#modal-add-{{$r->codRegistro}}" data-toggle="modal">
                                                {{ $r->estado}}
                                            </span>
                                        @elseif ($r->estado == 'CONFIRMADO')
                                            <span class=" badge bg-teal">{{ $r->estado}}</span>
                                        @endif
                                    </td>
                                    <td align="right">{{ number_format($r->pago, 2)}}</td>
                                    <td>
                                        @if (!empty($r->imgComprobante))
                                            <a href="{{ asset('imgComprobante/' . $r->imgComprobante) }}" target="_black" title="Comprobante">
                                                <img src="{{ asset('imgComprobante/' . $r->imgComprobante) }}" width="50" height="50" class="img-thumbnail">
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('one-register.pdf',[$r->codRegistro])}}" target="_blank" title="Reporte en PDF"
                                        class="btn btn-default btn-sm" >
                                        <i class="far fa-file-pdf" style="color: #df4747"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if ($r->estado == 'SIN CONFIRMAR')
                                        <form action="{{route('listado.destroy', $r->codRegistro) }}" method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-default btn-sm borrar text-danger" title="Eliminar {{ $r->codRegistro }}"
                                                data-nombre="Reserva {{ $r->nomLocalidad }} - {{ $r->nomCliente }}"><i class="fa fa-trash"aria-hidden="true"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>

                                </tr>
                                @include('registro.listado.finalizar')
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            {{$registro->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3])}}
        </div>
    </div>


    @push('scripts')
    @if (Session::has('success'))
    <script type="text/javascript">
        const Toast = Swal.mixin ({
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
            Toast.fire ({
                icon: 'success',
                title: '{{ Session::get('success') }}',
                customClass: 'swal-pop',
            })
    </script>
    @endif
    {{-- ----------------------------------------------- --}}
    @if (Session::has('error'))
    <script type="text/javascript">
        const Toast = Swal.mixin ({
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
            Toast.fire ({
                icon: 'success',
                title: '{{ Session::get('error') }}',
                customClass: 'swal-pop',
            })
    </script>
    @endif
    @endpush

@endsection
