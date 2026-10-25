@extends ('layouts.admin')
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4 style="font-weight: bold">Clientes
                @php($searchText=empty($searchText)?'TODO':$searchText)
                <a href="{{route('list-cliente.pdf',[$searchText])}}" target="_blank" title="Reporte en PDF del Listado de Reservas"
                    class="btn btn-default btn-sm" style="float: right">
                <i class="fas fa-file-pdf" style="color: #df4747"></i>
                </a>
            </h4>
            <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                Nuevo <i class="fas fa-user-plus" style="color: #cef5e1; margin-left: 10px"></i>
            </a>
        </div>
        <div class="card-body">
            @include('registro.cliente.search')
        </div>
    </div>

    @include('registro.cliente.create')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th>#</th>
                                <th class="footable-first-visible">N° Documento</th>
                                <th>Cliente</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                {{-- <th>Foto</th> --}}
                                <th>Dirección</th>
                                <th colspan="2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                            @php($cont = ($page - 1) * $paginate + 1)
                            @foreach ($cliente as $p)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td>{{ $p->numDocumento}}</td>
                                    <td>{{ $p->nombres }}</td>

                                    {{-- <td>{{ $p->fechaNac }}</td> --}}
                                    <td>{{ $p->email }}</td>
                                    <td>{{ $p->telefono }}</td>
                                    <td>{{ $p->direccion}}</td>
                                    {{-- <td style="text-align: center">
                                        @if ($p->estado == 'ACTIVO')
                                            <button class="btn btn-sm apertura" title="Cambiar de estado a {{ $p->nombres }}"
                                                data-nombre="{{ $p->codCliente }}">
                                                <span class="badge badge-success">{{ $p->estado }}</span>
                                            @else
                                                <button class="btn btn-sm apertura" title="Cambiar de estado a {{ $p->nombres }}"
                                                data-nombre="{{ $p->codCliente   }}">
                                                <span class="badge badge-danger">{{ $p->estado }}</span>
                                        @endif
                                    </td> --}}


                                    <td align="center">
                                        <a href="{{route('cliente.edit',$p->codCliente)}}" class="btn btn-default btn-sm text-info"
                                            title="EDITAR DATOS DEL Cliente {{ $p->nombres }}">
                                            <i class="far fa-edit text-info" ></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('cliente.destroy', $p->codCliente) }}"
                                            method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-default btn-sm text-danger borrar" title="ELIMINAR {{ $p->nombres }}"
                                                data-nombre="{{ $p->nombres }}"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{$cliente->appends(['searchText' => $searchText])}}
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
                icon: 'error',
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
                        var d = '{{route('cliente.show', 0) }}' + data_nombre
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
                $(document).ready(function() {
                    <?php if (old('codPaciente') == '') {?>
                    $('#modal-add').modal('show');
                    $("#modal-add").on('hidden.bs.modal', function() {
                        location.reload();
                    });
                    <?php } else { ?>
                    $('#modal-add-<?php echo old('codPaciente'); ?>').modal('show');
                    $("#modal-add-<?php echo old('codPaciente'); ?>").on('hidden.bs.modal', function() {
                        location.reload();
                    });
                    <?php }?>
                });
            </script>

        @endif
    @endpush
@endsection
