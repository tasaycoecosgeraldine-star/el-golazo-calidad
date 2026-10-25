@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Listado de Productos</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @php($searchText = empty($searchText) ? 'TODO' : $searchText)
                        @php($searchText2 = empty($searchText2) ? 'TODO' : $searchText2)
                        <a href="{{ route('list-producto.pdf', [$searchText, $searchText2]) }}" target="_blank"
                            title="Reporte en PDF del Listado de Reservas" class="btn btn-default btn-sm">
                            <i class="fas fa-file-pdf" style="color: #df4747"></i>
                        </a>
                        <a href="{{ route('producto_excel.excel', [$searchText, $searchText2]) }}" target="_blank"
                            title="Reporte en Documento de Excel" class="btn btn-default btn-sm">
                            <i class="fas fa-file-excel" style="color: #0da358"></i>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('almacen.producto.create')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('almacen.producto.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Categoría</th>
                                {{-- <th>Descripción</th> --}}
                                <th>Imagen</th>
                                {{-- @if (auth()->user()->tipo == 'ADMINISTRADOR')
                                <th>Localidad</th>
                            @endif --}}
                                <th>Precio</th>
                                <th colspan="2">Opciones</th>
                            </tr>
                        <tbody>
                            @php($cont = 1)
                            @foreach ($producto as $p)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td>{{ $p->nomProducto }}</td>
                                    <td align="center">{{ $p->stock }}</td>
                                    <td>{{ $p->nomCategoria }}</td>
                                    {{-- <td>{{ $p->descripcion }}</td> --}}
                                    <td><img src="{{ asset('Imagen/' . $p->imagen) }}" alt="{{ $p->nomProducto }}"
                                            height="50px" width="50px" class="img-thumbnail"></td>
                                    {{-- @if (auth()->user()->tipo == 'ADMINISTRADOR')
                                   <td>{{ $p->nomLocalidad}}</td>
                                @endif --}}
                                    <td align="right">{{ number_format($p->Precio, 2) }}</td>
                                    <td align="center">
                                        <a class="btn btn-default text-info btn-sm"
                                            href="{{ route('producto.edit', $p->codProducto) }}">
                                            <i class="far fa-edit text-info"
                                                title="EDITAR PRODUCTO {{ $p->nomProducto }} "></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('producto.destroy', $p->codProducto) }}" method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-default borrar text-danger btn-sm"
                                                title="ELIMINAR PRODUCTO {{ $p->nomProducto }}"
                                                data-nombre="{{ $p->nomProducto }}"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            {{ $producto->appends(['searchText' => $searchText, 'searchText2' => $searchText2]) }}
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
