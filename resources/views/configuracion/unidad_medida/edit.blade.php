@extends ('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Editar la U. Medida</span>
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

            {!! Form::model($unidad_medida, [
                'method' => 'PATCH',
                'route' => ['unidad_medida.update', $unidad_medida->idUnidadMedida],
            ]) !!}
            {{ Form::token() }}
            <input type="hidden" name="idUnidadMedida" class="form-control" value="{{ $unidad_medida->idUnidadMedida }}">
            <div class="form-group">
                <label for="nombreUM">Nombre</label>
                <input type="text" name="nombreUM" class="form-control" value="{{ $unidad_medida->nombreUM }}"
                    placeholder="Nombre...">
            </div>
            <div class="form-group">
                <label for="valorUM">Valor Unidad</label>
                <input type="text" name="valorUM" class="form-control entero" value="{{ $unidad_medida->valorUM }}"
                    placeholder="">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{ asset('configuracion/unidad_medida') }}" class="btn btn-danger">Cancelar</a>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
    @push('scripts')
        <script>
            $('.entero').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
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
