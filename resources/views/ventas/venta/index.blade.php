@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Listado de Ventas</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @php($searchText=empty($searchText)?'TODO':$searchText)
                        <a href="{{route('list-venta.pdf',[$searchText])}}" target="_blank" title="Reporte en PDF del Listado de Ventas"
                            class="btn btn-default btn-sm" >
                        <i class="fas fa-file-pdf" style="color: #df4747"></i>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('ventas.venta.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th>Nro Venta</th>
                                <th>Cliente</th>
                                <th>Fecha de Venta</th>
                                <th>Hora de Venta</th>
                                {{-- <th>Estado</th> --}}
                                <th>M. Pago</th>
                                <th style="text-align: center">Total</th>
                                <th colspan="2">Opciones</th>
                            </tr>
                        <tbody>
                            @php($cont = 1)
                            @foreach ($venta as $ven)
                                <tr>
                                    <td># {{$ven->codVenta}}</td>
                                    <td>{{ $ven->nombres  }}</td>
                                    <td>{{ date('d/m/Y', strtotime($ven->fechVenta)) }}</td>
                                    <td>{{ $ven->horaVenta }}</td>
                                    {{-- <td>{{ $ven->estado }}</td> --}}
                                    <td>{{ $ven->metodoPago }}</td>
                                    <td align="right">{{ number_format($ven->totalVenta, 2) }}</td>
                                    <td align="center">
                                        <a class="btn btn-default text-teal btn-sm" title="Mostrar más detalles" href="{{route('venta.show',$ven->codVenta)}}">
                                            <i class="fas fa-clipboard-list"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('one-sale.pdf',[$ven->codVenta])}}" target="_blank" title="Reporte en PDF"
                                            class="btn btn-default btn-sm" >
                                            <i class="far fa-file-pdf" style="color: #df4747"></i>
                                        </a>
                                    </td>
                                    {{-- <td>
                                        <form
                                            action="{{route('venta.destroy', $ven->codVenta) }}"
                                            method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-default borrar text-danger btn-sm"
                                                title="ANULAR VENTA"
                                                data-nombre="{{ $ven->nombres }}"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button>
                                        </form>
                                    </td> --}}

                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <script>
        document.getElementById("Imagen").onchange = function(e) {
            // Creamos el objeto de la clase FileReader
            let reader = new FileReader();

            // Leemos el archivo subido y se lo pasamos a nuestro fileReader
            reader.readAsDataURL(e.target.files[0]);

            // Le decimos que cuando este listo ejecute el código interno
            reader.onload = function() {
                let preview = document.getElementById('img'),
                    image = document.createElement('img');

                image.src = reader.result;

                preview.innerHTML = '';
                preview.append(image);
            };
        }
    </script>
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
    @if (count($errors) > 0)
        <script type="text/javascript">
            $(document).ready(function() {
                <?php if (old('codProducto') == '') {?>
                $('#modal-add').modal('show');
                $("#modal-add").on('hidden.bs.modal', function() {
                    location.reload();
                });
                <?php } else { ?>
                $('#modal-add-<?php echo old('codProducto'); ?>').modal('show');
                $("#modal-add-<?php echo old('codProducto'); ?>").on('hidden.bs.modal', function() {
                    location.reload();
                });
                <?php }?>
            });
        </script>

    @endif
@endpush



@endsection
