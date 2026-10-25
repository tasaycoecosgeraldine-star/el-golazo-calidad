@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">
                        Nueva Venta
                    </span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                        {{-- <li class="breadcrumb-item active">Simple Tables</li> --}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-xs-6">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>


    <form action="{{ route('venta.store') }}" method="post" id="form1">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="proveedor">Cliente</label>
                    <select name="codCliente" id="codCliente" class="form-control selectpicker" data-live-search="true"
                        required>
                        <option value="" selected hidden>Seleccionar</option>
                        @foreach ($cliente as $cli)
                            <option value="{{ $cli->codCliente }} ">{{ $cli->numDocumento }} | {{ $cli->nombres }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <label for="">Producto</label>
                    <select class="form-control selectpicker" name="codProducto" id="pidarticulo" data-live-search="true">
                        <option value="" hidden selected>Selecione Producto</option>
                        @foreach ($producto as $p)
                            <option value="{{ $p->codProducto }}_{{ $p->stock }}_{{ $p->Precio }}">
                                {{ $p->nomProducto }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" name="cantidad" id="pcantidad" class="form-control" placeholder="Ejm: 2">
                </div>

            </div>

            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" disabled name="pstock" id="pstock" class="form-control" placeholder="Stock">
                </div>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">

                <div class="form-group">
                    <label for="precio_venta">Precio de Venta</label>
                    <input type="number" disabled name="precioVenta" id="pPrecio" class="form-control"
                        placeholder="Precio de venta">
                </div>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">

                <div class="form-group">
                    <label for="descuento">Descuento</label>
                    <input type="number" name="descuento" id="pdescuento" class="form-control" placeholder="Descuento"
                        value="0" min="0">
                </div>

            </div>

            <div class="col-12 text-center">
                <div class="form-group">
                    <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table id="detalles" class="table table-sm table-striped  table-condensed table-hover">
                            <thead class="bg-teal">
                                <th>Opciones</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Venta</th>
                                <th>Descuento</th>
                                <th>Sub Total</th>
                            </thead>
                            <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <h4 id="total">$ 0.00</h4> <input type="hidden" name="totalVenta" id="total_venta">
                                </th>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row" id="guardar">
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <select name="metodoPago" class="form-control" required>
                        <option value="">Seleccionar Método de Pago</option>
                        @foreach (['EFECTIVO', 'TRANSFERENCIA'] as $m)
                            <option value="{{ $m }}">{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-12 text-center">
                <div class="form-group">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <button class="btn bg-primary" type="submit" id="enviar">
                        Guardar
                    </button>
                    <a href="{{ asset('ventas/venta') }}" class="btn btn-danger">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        @if (!isset($caja))
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
                            location.href = "{{ asset('caja/apertura_cierre') }}";
                        }
                    })
                });
            </script>
        @else
            @if ($caja->codUsuario != auth()->user()->codUsuario)
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Advertencia!',
                            icon: 'warning',
                            // showDenyButton: true,
                            confirmButtonColor: '#36BE80',
                            html: 'Caja aperturada por otro usuario. <br> Espere que el usuario responsable cierre la caja.<br><br> ',
                            confirmButtonText: 'Sí, Adelante',
                            // footer: '¿Está Usted de Acuerdo?',
                            // denyButtonText: `Aún no`,
                            // closeOnClickOutside: false
                            allowOutsideClick: false

                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                location.href = "{{ asset('ventas/venta') }}";
                            }
                        })
                    });
                </script>
            @endif
        @endif
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
        <script>
            $(document).ready(function() {
                $("#bt_add").click(function()

                    {
                        agregar();
                    });
            });
            var cont = 0;
            total = 0;
            subtotal = [];
            $("#guardar").hide();
            $("#pidarticulo").change(mostrarValores);


            function mostrarValores() {
                datosArticulos = document.getElementById('pidarticulo').value.split('_');
                $("#pPrecio").val(datosArticulos[2]);
                $("#pstock").val(datosArticulos[1]);
                console.log('sadasd');
            }

            function agregar() {

                datosArticulos = document.getElementById('pidarticulo').value.split('_');


                idarticulo = datosArticulos[0];
                articulo = $("#pidarticulo option:selected").text();
                cantidad = $("#pcantidad").val();
                stock = $("#pstock").val();
                precio_venta = $("#pPrecio").val();
                descuento = $("#pdescuento").val();

                if (idarticulo != "" && cantidad != "" && cantidad > 0 && descuento != "" && precio_venta != "") {
                    if (parseInt(stock) >= parseInt(cantidad)) {
                        subtotal[cont] = (cantidad * precio_venta - descuento);
                        total = total + subtotal[cont];

                        var fila = '<tr class="selected" id="fila' + cont +
                            '"><td align="center"><button type="button" class="btn btn-default btn-sm" onclick="eliminar(' +
                            cont +
                            ');"><i class="fas fa-trash-alt text-danger"></i></button></td><td><input type="hidden" name="codProducto[]" value="' +
                            idarticulo + '">' +
                            articulo + '</td><td><input type="number" name="cantidad[]" readOnly value="' + cantidad +
                            '"></td><td><input type="number" name="precioVenta[]" readOnly value="' + precio_venta +
                            '"></td><td><input type="number" name="descuento[]" readOnly value="' + descuento + '"></td><td>' +
                            subtotal[
                                cont] + '</td></tr>';
                        cont++;
                        limpiar();
                        $('#total').html("$ " + total);
                        $('#total_venta').val(total);
                        evaluar();
                        $('#detalles').append(fila);
                    } else {
                        alert('La cantidad a vender supera el stock.');
                    }


                } else {
                    alert("Error al ingresar el detalle de la venta, revise los datos del articulo")
                }
            }


            function limpiar() {
                $("#pcantidad").val("");
                $("#pdescuento").val("0");
                $("#pprecio_venta").val("");
            }

            function evaluar() {
                if (total > 0) {
                    $("#guardar").show();
                } else {
                    $("#guardar").hide();
                }
            }

            function eliminar(index) {
                total = total - subtotal[index];
                $("#total").html("S/. " + total);
                $("#total_venta").val(total);
                $("#fila" + index).remove();
                evaluar();
            }

            document.querySelector('#form1').addEventListener('submit', function(e) {
                var form = this;

                e.preventDefault(); // <--- prevent form from submitting
                let myButton = document.getElementById('enviar');
                myButton.disabled = true;
                myButton.style.opacity = 0.7;
                myButton.textContent = 'Procesando ...';
                form.submit();
            });
        </script>
    @endpush
@endsection
