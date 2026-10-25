@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Campos Deportivos</span>
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
    @include('configuracion.localidad.create')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('configuracion.localidad.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th>Nro.</th>
                                <th>Nombre</th>
                                <th>Precio Día</th>
                                <th>Precio Noche</th>
                                {{-- <th>Dirección</th>
                                <th>Teléfono</th> --}}
                                <th>Logo</th>
                                <th colspan="2" style="text-align: center">Opciones</th>
                            </tr>
                        <tbody>
                            @php($cont = 1)
                            @foreach ($localidad as $p)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td>{{ $p->nomLocalidad }}</td>
                                    <td>{{ $p->precioDia }}</td>
                                    <td>{{ $p->precioNoche }}</td>
                                    {{-- <td>{{ $p->direccion }}</td>
                                    <td>{{ $p->telefono }}</td> --}}
                                   <td><img src="{{asset('Logo/'.$p->logo)}}" alt="{{ $p->nomLocalidad}}" height="50px" width="50px" class="img-thumbnail"></td>
                                    <td align="center">
                                        <a class="btn btn-default text-info btn-sm" href="{{route('localidad.edit',$p->codLocalidad)}}">
                                            <i class="far fa-edit text-info"  title="EDITAR LOCALIDAD {{ $p->nomLocalidad }} "></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <form
                                            action="{{route('localidad.destroy', $p->codLocalidad) }}"
                                            method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-default borrar text-danger btn-sm"
                                                title="ELIMINAR LOCALIDAD {{ $p->nomLocalidad }}"
                                                data-nombre="{{ $p->nomLocalidad }}"><i class="fa fa-trash"
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
                <?php if (old('codLocalidad') == '') {?>
                $('#modal-add').modal('show');
                $("#modal-add").on('hidden.bs.modal', function() {
                    location.reload();
                });
                <?php } else { ?>
                $('#modal-add-<?php echo old('codLocalidad'); ?>').modal('show');
                $("#modal-add-<?php echo old('codLocalidad'); ?>").on('hidden.bs.modal', function() {
                    location.reload();
                });
                <?php }?>
            });
        </script>

    @endif


@endpush


@endsection
