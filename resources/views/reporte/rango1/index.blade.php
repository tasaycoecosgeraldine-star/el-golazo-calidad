@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Reporte por rango de Fecha de Ventas</span>
                </div>
                @if (empty($searchText3))
                    @php($searchText3 = 'TODO')
                @endif
                @php($searchText4 = empty($searchText4) ? 'TODO' : $searchText4)
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if (auth()->user()->tipo == 'ADMINISTRADOR')
                        <a href="{{route('rango1.pdf',[$searchText, $searchText2, $searchText3, $searchText4])}}" target="_blank" title="Reporte en PDF"
                            class="btn btn-default btn-sm" >
                            <i class="fas fa-file-pdf" style="color: #df4747"></i>
                        </a>
                        <a href="{{route('rango_excel1.excel',[$searchText, $searchText2, $searchText3, $searchText4])}}" target="_blank" title="Reporte en Documento de Excel"
                            class="btn btn-default btn-sm">
                            <i class="fas fa-file-excel" style="color: #0da358"></i>
                        </a>
                        @else
                        <a href="{{route('rango1.pdf',[$searchText, $searchText2, $searchText3, 'TODO'])}}" target="_blank" title="Reporte en PDF"
                            class="btn btn-default btn-sm" >
                            <i class="fas fa-file-pdf" style="color: #df4747"></i>
                        </a>
                        <a href="{{route('rango_excel1.excel',[$searchText, $searchText2, $searchText3, 'TODO'])}}" target="_blank" title="Reporte en Documento de Excel"
                            class="btn btn-default btn-sm">
                            <i class="fas fa-file-excel" style="color: #0da358"></i>
                        </a>
                        @endif
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('reporte.rango1.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th>Nro Venta</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th colspan="2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($cont = 1)
                            @foreach ($ventas as $c)
                                <tr>
                                    <td># {{ $c->codVenta }}</td>
                                    <td>{{ date('d/m/Y', strtotime($c->fechVenta)) }}</td>
                                    <td>{{ $c->horaVenta}}</td>
                                    <td>{{ $c->nomCliente }}</td>
                                    <td align="right">{{ number_format($c->totalVenta, 2) }}</td>
                                    <td>
                                        <a href="{{route('one-sale.pdf',[$c->codVenta])}}" target="_blank" title="Reporte en PDF"
                                            class="btn btn-default btn-sm" >
                                            <i class="far fa-file-pdf" style="color: #df4747"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-default text-teal btn-sm" title="Mostrar más detalles" href="{{route('venta.show',$c->codVenta)}}">
                                            <i class="fas fa-clipboard-list"></i>
                                        </a>
                                    </td>
                                    {{-- <td>
                                        <form action="{{route('registro.destroy', $c->codVenta) }}"  method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-default btn-sm borrar text-danger"
                                                title="Eliminar  {{ $c->nomCliente }}"
                                                data-nombre="Cita {{ $c->nomCliente }}"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button>
                                        </form>
                                    </td> --}}
                                </tr>

                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
            {{$ventas->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3, 'searchText4' => $searchText4])}}
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
        <script>
            $('.apertura').unbind().click(function() {
                var $button = $(this);
                var data_nombre = $button.attr('data-nombre');
            Swal.fire({
                title: '¿Culminar cita?',
                text: 'Ingrese el diagnostico o receta de la cita para poder culminar, este registro no será modificado posteriormente.',
                input: 'textarea',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                // showCancelButton: true,
                showDenyButton: true,
                denyButtonText: `Cancelar`,
                confirmButtonText: 'Culminar',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    // console.log(login)
                    if (login === ''){
                        Swal.showValidationMessage(
                        `Ingrese el diagnostico`
                        )
                    }
                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var d = '{{route('rango.show', 0)}}' + data_nombre + '_' + result.value
                        window.location.href = d;

                    }else if (result.isDenied) {
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
                            title: "Cancelado",
                            icon: 'error',
                            title: 'Se canceló la culminación de la cita.',
                            customClass: 'swal-pop',
                        })
                    }
                })
            });
        </script>

    @endpush

@endsection
