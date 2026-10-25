@extends('layouts.admin')
@section ('contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">AJUSTES</span>
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
                    <td colspan="2" style="color: #b41717">
                        *Esta información es importante para la emisión de reportes y para el funcionamiento del Sistema.
                    </td>
                </tr>
                <tr>
                    <td><b>Logo:</b></td>
                    <td> <img src="{{asset('Logo/'.$empresa->logo)}}" alt=""
                         width="100" height="100"></td>
                </tr>
				<tr>
					<td><b>Nombre de la Empresa:</b></td>
                    <td>{{$empresa->nombre}}</td>
				</tr>
                <tr>
					<td><b>Dirección:</b></td>
                    <td>{{$empresa->direccion}}</td>
				</tr>
                <tr>
					<td><b>Teléfono:</b></td>
                    <td>{{$empresa->telefono}}</td>
				</tr>

                <tr>
                    <td colspan="2" style="text-align: center;">
                        <a class="btn btn-primary bg-teal" style="width: 150px"
                        href="" data-target="#modal-add" data-toggle="modal">
                        Editar <i class="far fa-edit" style="margin-left: 20px"></i>
                        </a>
                    </td>
                </tr>

			</table>
		</div>

	</div>
</div>
</div>
@include('configuracion.ajustes.modal')
<script type="text/javascript">
	function mostrar(){
    var archivo = document.getElementById("Logo").files[0];
    var reader = new FileReader();
    if (archivo) {
        reader.readAsDataURL(archivo );
        reader.onloadend = function () {
        document.getElementById("img").src = reader.result;
        document.getElementById("nombre_imagen").value = archivo.name;
        }
    }else{
        document.getElementById("img").src = "";
        document.getElementById("nombre_imagen").value = "";
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
            $('#modal-add').modal('show');
        });
        $("#modal-add").on('hidden.bs.modal', function () {
        location.reload();
        });
    </script>
@endif
{{-- <script type="text/javascript">
    $("input[type=checkbox]:checked").each(function(){
    valoresCheck.push(this.value);
    });
</script> --}}
@endpush
@endsection
