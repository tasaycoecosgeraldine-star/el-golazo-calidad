<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add-{{$r->codRegistro}}">

    {!!Form::model($registro,['method'=>'PATCH','route'=>['listado.update',$r->codRegistro], 'files'=>'true'])!!}
    {{Form::token()}}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }
    </style>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <h4 class="modal-title">Confirmar Reserva</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="estado" value="CONFIRMADO">
                <label for="" class="text-secondary">Pago recibido</label>
                <div class="input-group mb-3">
                    <input type="hidden" name="codRegistro" id="" value="{{$r->codRegistro}}">
                    <input type="hidden" id="fecha" value="{{$r->fechRegistro}}">
                    <input type="hidden" id="h_inicio" value="{{$r->horainicio}}">
                    <input type="hidden" id="h_final" value="{{$r->horafinal}}">
                    <input type="text" class="form-control pago" id="pago" name="pago" placeholder="Ingrese el importe de la reserva."  required>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    </div>
                </div>

                <label for="" class="text-secondary">Nota</label>
                <div class="input-group mb-3">
                    <textarea name="comentario" id="comentario" class="form-control" id="" cols="30" rows="3" placeholder="Ingrese una nota (OPCIONAL)">{{$r->comentario}}</textarea>
                </div>
                <label for="" class="text-secondary">Comprobante</label>
                <div class="input-group mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-image"></i></span>
                        </div>
                        <input type="file" class="form-control" id="Imagen2" name="imgComprobante" >
                    </div>
                    <input type="hidden" value="NO" id="text-comprobante">
                    <div id="img2" class="imagen">
                        {{-- <img src="{{asset('Imagen/'.$r->foto)}}"  width="100" height="100"> --}}
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12" style="text-align: center">
                        @if (count($errors)>0)
                            <div class="alert alert-danger">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-12" style="text-align: center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <a href="#" class="btn btn-primary bg-teal confirmar_o">Confirmar</a>
                        <button type="submit" class="btn btn-primary bg-teal confirmar" style="display: none">Confirmar</button>
                    </div>
                </div>
            </div>

        </div>
        {{ Form::Close() }}
 </div>
 <script>
    document.getElementById("Imagen2").onchange = function(e) {
        // Creamos el objeto de la clase FileReader
        let reader = new FileReader();
        if (typeof(e.target.files[0]) === 'object'){
            // Leemos el archivo subido y se lo pasamos a nuestro fileReader
            reader.readAsDataURL(e.target.files[0]);
            // Le decimos que cuando este listo ejecute el código interno
            reader.onload = function() {
                let preview = document.getElementById('img2'),
                    image = document.createElement('img');
                image.src = reader.result;
                document.getElementById('text-comprobante').value = 'SÍ';
                preview.style.display = 'block';
                preview.innerHTML = '';
                preview.append(image);
            };
        }else{
            document.getElementById('img2').style.display = 'none';
            document.getElementById('text-comprobante').value = 'NO';
        }
    }
</script>
@push('scripts')
    <script>
        $('.pago').on('input', function () {
            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });
    </script>
    <script>
        $('.confirmar_o').unbind().click(function() {
            var pago = document.getElementById('pago').value;
            var fecha = document.getElementById('fecha').value;
            var h_inicio = document.getElementById('h_inicio').value;
            var h_final = document.getElementById('h_final').value;
            var nota = document.getElementById('comentario').value;
            var comprobante = document.getElementById('text-comprobante').value;

            if(pago === ''){
                $(".confirmar").click();
            }else{

                Swal.fire({
                    title: 'Necesitamos de tu Confirmación',
                    showDenyButton: true,
                    confirmButtonColor: '#36BE80',
                    html: 'Se confirmará la reserva con los siguientes datos:' +
                    '<table class="table text-nowrap"><tr><td align="left">Importe:</td><td> S/ ' + pago  + '</td></tr>' +
                    '<tr><td align="left">Fecha:</td><td>' + fecha + '</td></tr>'+
                    '<tr><td align="left">Rango Hora:</td><td>' + h_inicio + ' - ' + h_final + '</td></tr>'+
                    '<tr><td align="left">Nota:</td><td align="left">' + nota + '</td></tr>'+
                    '<tr><td align="left">Comprobante</td><td align="left">' + comprobante + '</td></tr>'+
                    '</table>' +
                    '<span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                    confirmButtonText: `Sí, Adelante!`,
                    denyButtonText: `Cancelar`,
                    icon: 'info',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(".confirmar").click();
                    }
                })
                return false;
                }
        });
    </script>
@endpush
