<?php use App\Http\Controllers\RegistroController as RC; ?>
@extends('layouts.admin')
@section('contenido')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'></script>

    @if (!empty($searchText))
        <script>
            var calendar = null;
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    locale: 'es',
                    slotMinTime: '06:00:00',
                    slotMaxTime: '24:00:00',
                    allDaySlot: false,
                    initialView: 'timeGridDay',
                    editable: true,
                    navLinks: true,
                    selectable: true,
                    selectMirror: true,
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    },
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    },
                    select: function(arg) {

                        let f = moment(arg.start).format("YYYY-MM-DD");
                        let hi = moment(arg.start).format("HH:mm:ss");

                        var fechaActual = moment(new Date()).format('YYYY-MM-DD HH:mm:ss');
                        var fechaSeleccionada = moment(arg.start).format('YYYY-MM-DD HH:mm:ss');
                        if (fechaSeleccionada >= fechaActual) {
                            $("#txtFecha").val(f);
                            $("#txtHoraInicial").val(hi);
                            $("#txtTiempo").val("60");
                            $("#agenda_modal").modal();
                            calendar.unselect()
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Disculpe!',
                                html: 'Seleccione una fecha y/o hora posterior a la fecha actual! <br> ' +
                                    moment(new Date()).format('HH:mm:ss DD/MM/YYYY'),
                            })

                        }

                    },
                    eventClick: function(info) {

                        $("#txtFecha_e").val(moment(info.event.start).format('YYYY-MM-DD'));
                        $("#txtHoraInicial_e").val(moment(info.event.start).format('HH:mm:ss'));
                        $("#id_e").val(info.event.id);
                        $("#txtComentario_e").val(info.event.extendedProps.comentario);
                        $("#txtTiempo_e").val(info.event.extendedProps.duracion);
                        $("#txtEstado_e").val(info.event.extendedProps.estado);
                        $("#txtnomLocalidad_e").html(info.event.extendedProps.nomLocalidad);
                        $("#txtTarifa_e").val(info.event.extendedProps.tarifa);
                        $("#ddlLocalidad_e").val(info.event.extendedProps.codLocalidad);
                        // $("#txtComentario_e").val(info.event.extendedProps.comentario);
                        $("#ddlClientes_e").selectpicker('val', info.event.extendedProps.codCliente)
                        $("#agenda_modal_edit").modal();
                    },
                    editable: true,
                    eventDrop: function(info) {
                        var fd = new FormData(document.getElementById("formulario_agenda_edit"));
                        fd.append("id", info.event.id);
                        fd.append("txtFecha", moment(info.event.start.toISOString()).format("YYYY-MM-DD"));
                        fd.append("txtHoraInicial", moment(info.event.start.toISOString()).format(
                            "HH:mm:ss"));
                        fd.append("txtHoraFinal", moment(info.event.end.toISOString()).format("HH:mm:ss"));
                        fd.append("ddlLocalidad_r", info.event.extendedProps.codLocalidad);
                        console.log(info.event.extendedProps.estado)
                        edit(fd);
                        // info.revert();
                    },
                    events: '/registro/listar/' + '{{ explode('_', $searchText)[0] }}',
                });
                calendar.render();
                // console.log('{{ explode('_', $searchText)[0] }}');
            });


            function guardar() {
                var fd = new FormData(document.getElementById("formulario_agenda"));
                let fecha = $("#txtFecha").val();
                let hora = $("#txtHoraInicial").val();
                let tiempo = $("#txtTiempo").val();
                let hora_inicial = moment(fecha + " " + hora).format("HH:mm:ss");
                let hora_final = moment(fecha + " " + hora).add(tiempo, 'm').format("HH:mm:ss");

                fd.append("txtHoraInicial", hora_inicial);
                fd.append("txtHoraFinal", hora_final);

                $.ajax({
                    url: "/registro/guardar",
                    type: "POST",
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false // tell jQuery not to set contentType

                }).done(function(r) {
                    // console.log(r);

                    if (r && r.ok) {
                        calendar.refetchEvents();
                        Swal.fire({
                            title: 'Registro Completado!',
                            icon: 'success',
                            showDenyButton: true,
                            html: 'Desea registrar el pago a la reserva?',
                            confirmButtonText: 'Sí',
                            denyButtonText: `Aún no`,

                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                let ruta = "{{ route('rango.show', ':id') }}";
                                ruta = ruta.replace(':id', r.mensaje);
                                location.href = ruta;
                            } else {
                                Swal.fire(
                                    'Puede confirmar la reserva en la pestaña "Reportes >> Alquiler / Reserva"',
                                    '', 'info')
                            }
                        })
                        limpiar();
                        calendar.refetchEvents()
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: r.mensaje,
                            // html: ,
                            // footer: 'Seleccione otra fecha y/o hora por favor!'
                        })
                    }
                });
            }

            function edit(fd) {
                console.log(fd);
                $.ajax({
                    url: "/registro/editar",
                    type: "POST",
                    data: fd,
                    processData: false, // tell jQuery not to process the data
                    contentType: false // tell jQuery not to set contentType

                }).done(function(r) {
                    if (r && r.ok) {
                        // calendar.refetchEvents();
                        Swal.fire({
                            icon: 'success',
                            title: 'Registro modificado!',
                            html: 'Se modificó la reserva correctamente!'
                        })
                        // limpiar();
                        calendar.refetchEvents();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al intentar modificar el registro!',
                            html: 'El registro interfiere con otra reserva o la fecha seleccionada es menor a la fecha actual',
                            footer: 'Seleccione otra fecha y/o hora por favor!'
                        })
                        calendar.refetchEvents();
                    }
                });
            }
            // Editar completo
            function editar() {
                if ($("#txtEstado_e").val() === 'CONFIRMADO') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Registro CONFIRMADO!',
                        html: 'Este registro se encuentra "CONFIRMADO" y no es posible hacer ninguna modificación.'
                    })
                    calendar.refetchEvents();
                } else {
                    var fd = new FormData(document.getElementById("formulario_agenda_edit2"));
                    let fecha = $("#txtFecha_e").val();
                    let hora = $("#txtHoraInicial_e").val();
                    let tiempo = $("#txtTiempo_e").val();
                    let hora_final = moment(fecha + " " + hora).add(tiempo, 'm').format("HH:mm:ss");

                    fd.append("txtHoraFinal_e", hora_final);

                    $.ajax({
                        url: "/registro/editar2",
                        type: "POST",
                        data: fd,
                        processData: false, // tell jQuery not to process the data
                        contentType: false // tell jQuery not to set contentType

                    }).done(function(r) {
                        if (r && r.ok) {
                            // calendar.refetchEvents();
                            Swal.fire({
                                icon: 'success',
                                title: 'Registro modificado!',
                                html: 'Se modificó la reserva correctamente!'
                            })
                            // limpiar();
                            $("#agenda_modal_edit").modal('hide');

                            calendar.refetchEvents();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al intentar modificar el registro!',
                                html: 'El registro interfiere con otra reserva o la fecha seleccionada es menor a la fecha actual',
                                footer: 'Seleccione otra fecha y/o hora por favor!'
                            })
                            calendar.refetchEvents();
                        }
                    });
                }
            }

            function limpiar() {
                $("#agenda_modal").modal('hide');
                $("#txtFecha").val("");
                $("#txtHoraInicial").val("");
                $("#txtTiempo").val("");
                $("#txtIndicaciones").val("");
                $("#txtTarifa").val("");
                $("#ddlClientes").val("");
                $('#ddlClientes').selectpicker('refresh');
                // $("#ddlUsuarios").val("");
            }
        </script>
    @endif
    @include('registro.registro.create')

    <section class="content-header" style="padding: 0px">
        <div class="container-fluid">
            {!! Form::open(['url' => 'registro/registro', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">RESERVA </span><br>
                    <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                        Nuevo Cliente<i class="fas fa-user-plus" style="color: #cef5e1; margin-left: 10px"></i>
                    </a>
                </div>
                <div class="col-sm-6">
                    <select name="searchText" class="form-control selectpicker searchText" data-live-search="true">
                        <option value="" hidden selected> Seleccionar Localidad</option>
                        @foreach ($localidad as $item)
                            <option value="{{ $item->codLocalidad }}"
                                {{ $item->codLocalidad == $searchText ? 'selected' : '' }}>{{ $item->nomLocalidad }}
                            </option>
                        @endforeach
                    </select>
                    <span class="input-group-btn" style="display: none">
                        <button type="submit" id="buscar" class="btn btn-primary"> </button>
                    </span>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </section>

    @if (!empty($searchText))
        <div class="row">
            <div class="col-12">
                <div id='calendar'></div>

            </div>
        </div>
    @endif

    <div>
        <form action="" id="formulario_agenda_edit">
            @csrf
        </form>
    </div>

    <div class="modal fade" id="agenda_modal" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-teal">
                    <h5 class="modal-title" style="text-align: center; font-weight: bold">Reservar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formulario_agenda">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <input type="date" class="form-control form-control-sm" id="txtFecha"
                                        name="txtFecha">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Hora Inicial</label>
                                    <input type="time" class="form-control form-control-sm" id="txtHoraInicial">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Tiempo (minutos)</label>
                                    <input type="number" class="form-control form-control-sm" id="txtTiempo"
                                        name="txtTiempo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    @if (!empty($searchText))
                                        <div class="col-md-7 col-12">
                                            <div class="form-group">
                                                <label for="">Localidad </label><br>
                                                <input type="hidden" name="ddlLocalidad" id="ddlLocalidad"
                                                    value="{{ $searchText }}">
                                                <span>{{ RC::nombreLocalidad($searchText)->nomLocalidad }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-12">
                                            <div class="form-group">
                                                <label for="">Tarifa </label>
                                                @php($precio = ['día' => 'Día (' . RC::nombreLocalidad($searchText)->precioDia . ')', 'noche' => 'Noche (' . RC::nombreLocalidad($searchText)->precioNoche . ')'])
                                                <select name="txtTarifa" id="txtTarifa"
                                                    class="form-control form-control-sm">
                                                    <option value="">Seleccionar</option>
                                                    @foreach ($precio as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Cliente</label>
                                            <select name="ddlClientes" id="ddlClientes"
                                                class="form-control form-control-sm selectpicker" data-live-search="true">
                                                <option value="">Seleccionar</option>
                                                @foreach ($cliente as $item)
                                                    <option value="{{ $item->codCliente }}">{{ $item->numDocumento }} |
                                                        {{ $item->nombres }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Detalles</label>
                                    <textarea class="form-control" name="txtComentario" id="txtComentario" cols="30" rows="5"
                                        placeholder="Ingrese algún detalle de la reserva (OPCIONAL)."></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button onclick="guardar()" type="button" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- -----------------------------------MODAL EDIT-------------------------------------------------- --}}
    <div class="modal fade" id="agenda_modal_edit" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-teal">
                    <h5 class="modal-title" style="text-align: center; font-weight: bold">Reservar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formulario_agenda_edit2">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <input type="hidden" id="id_e" name="id_e">
                                    <input type="hidden" id="txtEstado_e" name="txtEstado_e">
                                    <input type="date" class="form-control" id="txtFecha_e" name="txtFecha_e">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Hora Inicial</label>
                                    <input type="time" class="form-control" id="txtHoraInicial_e"
                                        name="txtHoraInicial_e">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Tiempo (minutos)</label>
                                    <input type="number" class="form-control" id="txtTiempo_e" name="txtTiempo_e">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-md-7 col-12">
                                        <div class="form-group">
                                            <label for="">Localidad</label><br>
                                            <input type="hidden" name="ddlLocalidad_e" id="ddlLocalidad_e" readonly>
                                            <span id="txtnomLocalidad_e"></span>
                                        </div>
                                    </div>
                                    @if (!empty($searchText))
                                        <div class="col-md-5 col-12">
                                            <div class="form-group">
                                                <label for="">Tarifa </label>
                                                @php($precio = ['día' => 'Día (' . RC::nombreLocalidad($searchText)->precioDia . ')', 'noche' => 'Noche (' . RC::nombreLocalidad($searchText)->precioNoche . ')'])
                                                <select name="txtTarifa_e" id="txtTarifa_e"
                                                    class="form-control form-control-sm">
                                                    @foreach ($precio as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Cliente</label>
                                            <select id="ddlClientes_e" class="form-control form-control-sm selectpicker"
                                                name="ddlClientes_e" data-live-search="true">
                                                @foreach ($cliente as $item)
                                                    <option value="{{ $item->codCliente }}">{{ $item->numDocumento }} |
                                                        {{ $item->nombres }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Detalles</label>
                                    <textarea class="form-control" name="txtComentario_e" id="txtComentario_e" cols="30" rows="5"
                                        placeholder="Ingrese algún detalle de la reserva (OPCIONAL)."></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button onclick="editar()" type="button" class="btn btn-success">Editar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const selectElement = document.querySelector('.searchText');
        selectElement.addEventListener('change', (event) => {
            $("#buscar").click();
        });
    </script>
    @push('scripts')
        @if (auth()->user()->tipo == 'PERSONAL' && !isset($caja))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Advertencia!',
                        icon: 'warning',
                        // showDenyButton: true,
                        confirmButtonColor: '#36BE80',
                        html: 'Para poder realizar esta operación es necesario Aperturar Caja <br><br> <span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                        confirmButtonText: 'Sí, Adelante',
                        // footer: '¿Está Usted de Acuerdo?',
                        // denyButtonText: `Aún no`,
                        // closeOnClickOutside: false
                        allowOutsideClick: false

                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            location.href = "{{ asset('caja/apertura_cierre_p') }}";
                        }
                    })
                });
            </script>
        @endif
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
        {{-- <script>
        function recargarLista(id){
            $("#ddlClientes_e option[value=" + id +"]").attr("selected",true);

        }
    </script> --}}

        @if (count($errors) > 0)
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#modal-add').modal('show');
                });
            </script>
        @endif
    @endpush
@endsection
