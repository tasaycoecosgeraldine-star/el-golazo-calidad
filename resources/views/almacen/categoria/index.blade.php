<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.admin')
@section('contenido')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Listado de Categorías</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Simple Tables</li> --}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('almacen.categoria.create')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('almacen.categoria.search')
                <div class="card-body table-responsive p-0" id="table_refresh">
                    <table id="datatable" class="table table-sm table-hover">
                        <thead class="bg-teal">
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                {{-- <th>Descripción</th> --}}
                                <th style="text-align: center" >Opciones</th>
                                <th></th>
                            </tr>
                        <tbody>
                            @php($i = 0)
                            @foreach ($categoria as $c)
                                <tr>
                                    <td>{{ $i = $i + 1 }}</td>
                                    <td>{{ $c->nombre }}</td>
                                    {{-- <td>{{ $c->descripcion }}</td> --}}
                                    <td align="center">
                                        <a class="btn btn-default btn-sm text-info"
                                            href="{{ route('categoria.edit', $c->codCategoria) }}">
                                            <i class="far fa-edit text-info"
                                                title="Editar Categoría {{ $c->nombre }} "></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('categoria.destroy', $c->codCategoria) }}" method="POST"
                                            style="margin-bottom: 0px">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn-default btn-sm btn borrar text-danger"
                                                title="Eliminar {{ $c->nombre }}" data-nombre="{{ $c->nombre }}"><i
                                                    class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $categoria->appends(['searchText' => $searchText]) }}
                </div>

                <!-- /.card-body -->
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('dist/sweetalert2/create.js') }}"></script>

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
        @if (count($errors) > 0)
            <script type="text/javascript">
                $(document).ready(function() {
                    <?php if (old('codCategoria') == '') {?>
                    $('#modal-add').modal('show');
                    $("#modal-add").on('hidden.bs.modal', function() {
                        location.reload();
                    });

                    <?php }?>
                });
            </script>
        @endif
    @endpush



@endsection
