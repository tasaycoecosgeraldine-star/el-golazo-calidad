@extends('layouts.client')
@section('contenido')
<link href='../lib/main.css' rel='stylesheet' />
<script src='../lib/main.js'></script>


@if (empty($searchText))
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">Campos Deportivos disponibles</span>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Simple Tables</li> --}}
                </ol>
            </div>
        </div>
    </div>
</section>
@if(session()->has('success'))
    <div class="alert alert-success " role="alert">
        {{ session()->get('success') }}
    </div>
@endif
<div class="row">
    <div class="col-md-4 col-md-offset-4" style="margin-left:auto; margin-right:auto;">
        <div class="container">
            <div class="card">
                <div class="card-header" style="text-align: center">
                    Listado de campos deportivos
                </div>
                <div class="card-body">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th colspan="2">LOCALIDAD</th>

                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($registro as $item)
                            @php($item = explode('_', $item))
                            <tr>
                                <td>
                                    <a href="{{asset('registroCliente/registro?searchText=' . $item[0])}}">{{$item[1]}} </a>
                                </td>
                                <td>
                                    <a href="{{asset('registroCliente/registro?searchText=' . $item[0])}}"><span style="color: #000"><i class="fas fa-phone-volume"></i> {{$item[3]}}</span></a>
                                </td>
                                <td>
                                    @php($estado_caja = $item[2] == 'CERRADO' ? 'badge badge-danger' : 'badge badge-success')
                                    <a href="{{asset('registroCliente/registro?searchText=' . $item[0])}}">
                                         <span class="{{$estado_caja}}">{{$item[2]}}</span>
                                    </a>
                                </td>
                            </a>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<script>
    var calendar = null;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
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
                var estadoLocalidad = document.getElementById('estadoLocalidad').value
                if (estadoLocalidad === 'ABIERTO'){
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
                }else{
                    Swal.fire({
                        icon: 'warning',
                        title: 'Advertencia!',
                        html: 'El campo deportivo se encuentra cerrado, no puede continuar con el registro. <br> ',
                    })
                }

            },
            eventClick: function(info) {
                if(parseInt(info.event.extendedProps.codCliente) === parseInt(document.getElementById('myId').value)){
                    $("#txtFecha_e").val(moment(info.event.start).format('YYYY-MM-DD'));
                    $("#txtHoraInicial_e").val(moment(info.event.start).format('HH:mm:ss'));
                    $("#id_e").val(info.event.id);
                    $("#txtComentario_e").val(info.event.extendedProps.comentario);
                    $("#txtTiempo_e").val(info.event.extendedProps.duracion);
                    $("#txtEstado_e").val(info.event.extendedProps.estado);
                    console.log(info.event.extendedProps.estado);
                    // $("#txtPago_e").val(info.event.extendedProps.pago);
                    $("#txtnomLocalidad_e").val(info.event.extendedProps.nomLocalidad);
                    $("#ddlLocalidad_e").val(info.event.extendedProps.codLocalidad);
                    // $("#txtComentario_e").val(info.event.extendedProps.comentario);
                    $("#ddlClientes_e").val(info.event.extendedProps.codCliente);
                    $("#agenda_modal_edit").modal();
                }
            },
            editable: true,
            eventDrop: function(info) {
                if (info.event.extendedProps.estado === 'SIN CONFIRMAR') {
                    var fd = new FormData(document.getElementById("formulario_agenda_edit"));
                    fd.append("id", info.event.id);
                    fd.append("txtFecha", moment(info.event.start.toISOString()).format("YYYY-MM-DD"));
                    fd.append("txtHoraInicial", moment(info.event.start.toISOString()).format(
                        "HH:mm:ss"));
                    fd.append("txtHoraFinal", moment(info.event.end.toISOString()).format("HH:mm:ss"));
                    fd.append("ddlLocalidad_r", info.event.extendedProps.codLocalidad);
                    console.log(info.event.extendedProps.estado)
                    edit(fd);
                }else{
                    Swal.fire('No puede modificar una reserva CONFIRMADA', '', 'info')
                    calendar.refetchEvents();

                }

            },
            events: '/registroCliente/listar/' + '{{$searchText}}',
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
            url: "/registroCliente/guardar",
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
                    html: 'Desea confirmar la Reserva?',
                    confirmButtonText: 'Sí',
                    denyButtonText: `Aún no`,

                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        location.href = "{{ asset('registroCliente/mis_reservas') }}";
                    } else {
                        Swal.fire('Puede confirmar la reserva en la pestaña "Mis reservas"', '', 'info')
                    }
                })
                limpiar();
                calendar.refetchEvents()
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al intentar realizar el registro!',
                    html: 'El registro interfiere con otra reserva o la fecha seleccionada es menor a la fecha actual',
                    footer: 'Seleccione otra fecha y/o hora por favor!'
                })
            }
        });
    }

    function edit(fd) {
        console.log(fd);
        $.ajax({
            url: "/registroCliente/editar",
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
                url: "/registroCliente/editar2",
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
        // $("#ddlUsuarios").val("");
    }
</script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @php($estado = $localidad[1] == 'ABIERTO' ? 'text-success' : 'text-danger')
                <span class="title_header">Campo Deportivo "{{$localidad[0]}}" <span style="color: #3f3f3f">- </span><span class="{{$estado}}">{{$localidad[1]}}</span> </span>
                <input type="hidden" id="estadoLocalidad" value="{{$localidad[1]}}">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Simple Tables</li> --}}
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <input type="hidden" id="myId" value="{{auth()->guard('client')->user()->codCliente}}">
    <div class="col-12">
        <div id='calendar'></div>

    </div>
</div>
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
                                <input type="date" class="form-control" id="txtFecha" name="txtFecha">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Hora Inicial</label>
                                <input type="time" class="form-control" id="txtHoraInicial">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Tiempo (minutos)</label>
                                <input type="number" class="form-control" id="txtTiempo" name="txtTiempo">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Localidad</label>
                                <input type="hidden" name="ddlLocalidad" id="ddlLocalidad" value="{{$searchText}}">
                                <input type="text" value="{{$localidad[0]}}" disabled class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Cliente</label>
                                <input type="hidden" value="{{auth()->guard('client')->user()->codCliente}}" name="ddlClientes" id="ddlClientes">
                                <input type="text" value="{{auth()->guard('client')->user()->nombres}}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Nota</label>
                                <textarea class="form-control" name="txtComentario" id="txtComentario" cols="30"
                                    rows="5" placeholder="(OPCIONAL)"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="margin: 0px auto 0px auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button onclick="guardar()" type="button" class="btn btn-success bg-teal">Reservar</button>
            </div>
        </div>
    </div>
</div>
 {{-- -----------------------------------MODAL EDIT-------------------------------------------------- --}}
 <div class="modal fade" id="agenda_modal_edit" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <h5 class="modal-title" style="text-align: center; font-weight: bold">Modificar Reserva</h5>
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
                                <input type="time" class="form-control" id="txtHoraInicial_e" name="txtHoraInicial_e">
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
                            <div class="form-group">
                                <label for="">Localidad</label>
                                <input type="hidden" name="ddlLocalidad_e" id="ddlLocalidad_e" readonly
                                    class="form-control">
                                <input type="text" disabled value="" id="txtnomLocalidad_e" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Cliente</label>
                                <input type="hidden" id="ddlClientes_e" class="form-control" name="ddlClientes_e">
                                <input type="text" class="form-control" value="{{auth()->guard('client')->user()->nombres}}" disabled>
                            </div>
                            {{-- <div class="form-group">
                                <label for="">Pago</label>
                                <select name="txtEstado_e" id="txtEstado_e" class="form-control" disabled>
                                    <option value="SIN CONFIRMAR">SIN CONFIRMAR</option>
                                    <option value="CONFIRMADO">CONFIRMADO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Pago</label>
                                <input type="text" class="form-control" name="txtPago_e" id="txtPago_e" placeholder="Adelanto / Pago" value="0">
                            </div> --}}



                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Detalles</label>
                                <textarea class="form-control" name="txtComentario_e" id="txtComentario_e" cols="30"
                                    rows="5" placeholder="Ingrese algún detalle de la reserva (OPCIONAL)."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button onclick="editar()" type="button" class="btn btn-success">Editar</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
