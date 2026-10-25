@extends('layouts.admin')
@section ('contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">MI PERFÍL</span>
            </div>
            {{-- <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Buttons</li>
                </ol>
            </div> --}}
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="row">
	<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive" style="background: white">
			<table class="table ">
                <tr>
                    <td colspan="2" style="color: #d44c4c" >
                        *Esta información es importante para la emisión de reportes.
                    </td>
                </tr>
                <tr>
                    <td class="text-secondary"><b>Foto:</b></td>
                    <td>
                        @if (!empty($usuario->foto))
                            <img src="{{asset('Imagen/'.$usuario->foto)}}" alt=""
                            width="100" height="100">
                        @else
                            Aún no tiene una foto.
                        @endif
                    </td>
                </tr>
                <tr>
					<td class="text-secondary"><b>N° Documento:</b></td>
                    <td>{{$usuario->numDocumento}}</td>
				</tr>
				<tr>
					<td class="text-secondary"><b>Nombres:</b></td>
                    <td>{{$usuario->nombres}}</td>
				</tr>
                <tr>
					<td class="text-secondary"><b>Rol:</b></td>
                    <td>{{$usuario->tipo}}</td>
				</tr>
                <tr>
					<td class="text-secondary"><b>Dirección:</b></td>
                    <td>{{$usuario->direccion}}</td>
				</tr>
                <tr>
					<td class="text-secondary"><b>N° Teléfono:</b></td>
                    <td>{{$usuario->telefono}}</td>
				</tr>
                <tr>
					<td class="text-secondary"><b>Correo:</b></td>
                    <td>{{$usuario->email}}</td>
				</tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <a class="btn btn-primary bg-teal" style="width: 150px"
                        href="" data-target="#modal-add-{{$usuario->codUsuario}}" data-toggle="modal">
                        Editar <i class="far fa-edit" style="margin-left: 20px"></i>
                        </a>
                    </td>
                </tr>

			</table>
		</div>

	</div>
</div>
</div>
@include('configuracion.mi_perfil.modal')
<script type="text/javascript">
	function mostrar(){
    var archivo = document.getElementById("Imagen").files[0];
    var reader = new FileReader();
    if (archivo) {
        reader.readAsDataURL(archivo );
        reader.onloadend = function () {
        document.getElementById("img").src = reader.result;
        // document.getElementById("nombre_imagen").value = archivo.name;
        }
    }else{
        document.getElementById("img").src = "";
        // document.getElementById("nombre_imagen").value = "";
    }
}


</script>

@push ('scripts')
<script>
            $('.numero').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            }); 
        </script>
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
@if (count($errors)>0)
    <script type="text/javascript">
        $(document).ready(function(){
            // $('#modal-add').modal('show');
            $('#modal-add-<?php echo old("codUsuario") ?>').modal('show');
            $("#modal-add-<?php echo old("codUsuario") ?>").on('hidden.bs.modal', function () {
                location.reload();
            });
        });
    </script>
@endif
@endpush
@endsection
