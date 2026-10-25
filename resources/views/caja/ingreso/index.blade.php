@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Ingresos Extra</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if (isset($caja))
                            @if ($caja->codUsuario == auth()->user()->codUsuario)
                                <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                                    Nuevo <i class="fas fa-plus-circle"></i>
                                </a>
                            @else
                                <p>Otro usuario aperturó la caja.</p>
                            @endif
                        @else
                            <p>La caja no está aperturada.</p>
                        @endif
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('caja.ingreso.create')

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('caja.ingreso.search')
                <div class="card-body table-responsive p-0" id="table_refresh">
                    <table class="table table-sm table-sm table-hover text-nowrap">
                        <thead class="bg-teal">
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Recibido de</th>
                                <th>Motivo</th>
                                <th style="text-align: center">Importe</th>
                                <th style="text-align: center">Estado</th>
                                <th>Opciones</th>
                            </tr>
                        <tbody>

                            @foreach ($ingreso as $i)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($i->fechaIngreso)) }}</td>
                                    <td>{{ $i->horaIngreso }}</td>
                                    <td>{{ $i->recibidoDe }}</td>
                                    <td>{{ $i->motivo }}</td>
                                    <td align="right">{{ $i->importe }}</td>
                                    @php($estado_css = $i->estado == 'APROBADO' ? 'badge badge-success' : 'badge badge-danger')
                                    <td style="text-align: center"> <span
                                            class="{{ $estado_css }}">{{ $i->estado }}</span></td>
                                    <td>
                                        @if ($i->estado == 'APROBADO')
                                            <form action="{{ route('ingreso.destroy', $i->codIngreso) }}" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default btn-sm actualizar_ajax text-danger"
                                                    title="Anular Registro"
                                                    data-nombre="{{ $i->importe }}_{{ $i->recibidoDe }}_{{ $i->motivo }}"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $ingreso->appends(['searchText' => $searchText, 'searchText2' => $searchText2]) }}
        </div>
    </div>
    @push('scripts')
        <script>
            $('.importe').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
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
                    <?php } else { ?>
                    $('#modal-add-<?php echo old('codCategoria'); ?>').modal('show');
                    $("#modal-add-<?php echo old('codCategoria'); ?>").on('hidden.bs.modal', function() {
                        location.reload();
                    });
                    <?php }?>
                });
            </script>
        @endif
    @endpush



@endsection
