@extends('layouts.admin')
@section ('contenido')
<div class="card">
    <div class="card-header">
        <h4 style="font-weight: bold">Usuarios
        </h4>
        <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
            Nuevo <i class="fas fa-user-plus" style="color: #cef5e1; margin-left: 10px"></i>
        </a>
    </div>
    <div class="card-body">
        @include('acceso.usuario.search')
    </div>
</div>

@include('acceso.usuario.create')
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-sm table-hover text-nowrap">
                    <thead class="bg-teal">
                        <tr>
                            <th>#</th>
                            <th>N° Documento</th>
                            <th>Nombres</th>
                            <th>N° Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center" colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                        @php($cont = ($page - 1) * $paginate + 1)
                        @foreach ($usuario as $u)
                        <tr>
                            <td>{{ $cont++ }}</td>
                            <td>{{ $u->numDocumento}}</td>
                            <td>{{ $u->nombres }}</td>
                            <td>{{ $u->telefono}}</td>
                            <td>{{ $u->email}}</td>
                            <td>{{ $u->tipo}}</td>
                            <td align="center">
                                @if ($u->codUsuario != 1)
                                    @if ($u->estado == "ACTIVO")
                                    <button class="btn apertura" title="Cambiar de estado a {{ $u->nombres }}" data-nombre="{{ $u->codUsuario }}">
                                        <span class="badge badge-success" >{{ $u->estado}}</span>
                                    @else
                                        <button class="btn apertura" title="Cambiar de estado a {{ $u->nombres }}" data-nombre="{{ $u->codUsuario }}">
                                            <span class="badge badge-danger">{{ $u->estado}}</span>
                                    @endif
                                @endif
                            </td>
                            <td align="center">
                                <a class="btn btn-default btn-sm" href="{{route('usuario.edit',$u->codUsuario)}}">

                                    <i class="far fa-edit text-info"  title="EDITAR USUARIO {{ $u->nombres }}"></i>
                                </a>
                            </td>
                            <td>
                                @if ($u->codUsuario != 1)
                                    <form action="{{route('usuario.destroy', $u->codUsuario) }}" method="POST">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-default borrar text-danger btn-sm"  title="Eliminar Usuario {{ $u->nombres }}"
                                            data-nombre="{{ $u->nombres }}"><i class="fa fa-trash"
                                                aria-hidden="true"></i></button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                        {{-- @include('acceso.usuario.edit') --}}
                        @endforeach
                    </tbody>
                </table>
                {{-- <input type="text" value="{{old('IdUsuario')}}"> --}}
            </div>
            <!-- /.card-body -->
        </div>
        {{$usuario->appends(['searchText' => $searchText])}}
        <!-- /.card -->
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

@push ('scripts')
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
            title: '¿Desea cambiar el estado del Usuario?',
            showDenyButton: true,
            confirmButtonText: `Cambiar`,
            denyButtonText: `Cancelar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                var d = '{{route('usuario.show', 0)}}' + data_nombre
                window.location.href = d;
            } else if (result.isDenied) {
                Swal.fire('No se realizó ningún cambio', '', 'info')
            }
        })
        return false;
    });
</script>


@if (count($errors) > 0)
    <script type="text/javascript">
        $(document).ready(function(){
        <?php if (old('codUsuario') == '') {?>
            $('#modal-add').modal('show');
            $("#modal-add").on('hidden.bs.modal', function () {
                location.reload();
            });
        <?php } else { ?>
            $('#modal-add-<?php echo old("codUsuario") ?>').modal('show');
            $("#modal-add-<?php echo old("codUsuario") ?>").on('hidden.bs.modal', function () {
                location.reload();
            });
        <?php }?>
        });
    </script>

@endif

@endpush
@endsection
