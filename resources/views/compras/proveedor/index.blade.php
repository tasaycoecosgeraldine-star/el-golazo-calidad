@extends ('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Proveedores</span>
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
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-8 col-xs-12">
            <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                Nuevo <i class="fas fa-plus-circle" style="color: #cef5e1; margin-left: 10px"></i>
            </a>
        </div>
        @include('compras.proveedor.create')
    </div>
    <br>
    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-12">
            @include('compras.proveedor.search')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-condensed table-hover">
                    <thead class="bg-teal">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>N° Teléfono</th>
                        <th colspan="2">Opciones</th>
                    </thead>
                    @php($cont = 1)
                    @foreach ($personas as $per)
                        <tr>
                            <td>{{ $cont++ }}</td>
                            <td>{{ $per->nomPro }}</td>
                            <td>{{ $per->telPro }}</td>
                            <td>
                                <a href="{{ route('proveedor.edit', $per->idPro) }}"> <button class="btn btn-info btn-sm"><i
                                            class="fas fa-edit"></i></button> </a>
                            </td>
                            <td>
                                <form class="edi" action="{{ route('proveedor.destroy', $per->idPro) }}" method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <button class="btn btn-danger  btn-sm borrar" title="Eliminar {{ $per->nomPro }}"
                                        data-nombre="{{ $per->nomPro }}"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $personas->appends(['searchText' => $searchText]) }}
        </div>
    </div>
    @push('scripts')
        <script>
            $('.numero').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });
        </script>
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
        @if (count($errors) > 0)
            <script>
                $(document).ready(function() {
                    // Snackbar.show({
                    //     text: 'Registre de forma correcta los campos.',
                    //     actionText: 'CERRAR',
                    //     pos: 'bottom-right',
                    //     duration: 5000
                    // });
                    $('#modal-add').modal('show');
                });
            </script>
        @endif
    @endpush
@endsection
