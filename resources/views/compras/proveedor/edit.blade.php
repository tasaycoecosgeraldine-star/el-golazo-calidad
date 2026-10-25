@extends ('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Editar Proveedor</span>
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
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::open([
                'url' => route('proveedor.update', $proveedor->idPro),
                'method' => 'PUT',
                'autocomplete' => 'off',
            ]) !!}

            <input type="hidden" name="idpro" value="{{ $proveedor->idPro }}">

            <div class="form-group">
                <label for="nomPro">Nombre</label>
                <input type="text" name="nomPro" class="form-control" value="{{ $proveedor->nomPro }}" required>
            </div>
            <div class="form-group">
                <label for="phone">N° Teléfono</label>
                <input type="text" name="phone" class="form-control numero" value="{{ $proveedor->telPro }}">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{ asset('compras/proveedor') }}" class="btn btn-danger">Cancelar</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
    @push('scripts')
        <script>
            $('.numero').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
        </script>
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
    @endpush
@endsection
