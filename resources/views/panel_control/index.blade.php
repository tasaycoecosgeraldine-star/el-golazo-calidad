@php use App\Http\Controllers\CajaController; @endphp
@extends('layouts.admin')
@section('contenido')
    {!! Form::open(['url' => 'panel_control', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>
                        <b> {{ $componentName }}</b>
                    </h4>
                </div>
                <div class="col-md-6">
                    {{-- @if (isset($caja))
                        <span>
                            <i class="fas fa-circle nav-icon text-success"></i>
                            <a href="{{asset('caja/configuracion')}}">Caja Aperturada</a>
                            por {{$caja->nameUsers}}
                        </span>

                    @else
                        <span>
                            <i class="fas fa-circle nav-icon text-danger"></i>
                            <a href="{{asset('caja/configuracion')}}">Caja Cerrada</a>
                        </span>
                    @endif --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <input type="date" class="form-control" name="searchText" value="{{ $searchText }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="searchText2" value="{{ $searchText2 }}">
                </div>
                <div class="col-md-4 float-sm-right">
                    <button class="btn btn-info bg-teal"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}

    {{-- <div class="row">
            <div class="col-lg-12 col-12">
            <div class="card card-primary">

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $data[1] }}</h3>
                                    <p>Citas de Registradas</p>
                                </div>
                                <div class="icon">
                                    <i class="far fa-calendar"></i>
                                </div>
                                <a href="{{ asset('historial/listado-cita') }}" class="small-box-footer">Info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $data[2] }}</h3>
                                    <p>Citas concluidas</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <a href="{{ asset('historial/listado-cita?searchText3=CULMINADO') }}" class="small-box-footer">Info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $data[3] }}</h3>
                                    <p>Citas sin concluir</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-times"></i>
                                </div>
                                <a href="{{ asset('historial/listado-cita?searchText3=PENDIENTE') }}" class="small-box-footer">Info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $data[0] }}</h3>
                                    <p>Especialistas Activos</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="{{ asset('acceso/usuario') }}" class="small-box-footer">Más info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div> --}}
    {{-- </div> --}}
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="card">
                <div class="card-header text-white bg-teal">
                    Gráfica General
                </div>
                <div class="card-body">
                    <canvas id="gLine" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-8 col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        Cantidad de citas por Especialista
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div> --}}
        {{-- <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header text-white bg-teal">
                    Cantidad de ventas por usuario
                </div>
                <div class="card-body">
                    <canvas id="gDona" width="400" height="200"></canvas>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-12 col-12">
            <div class="card card-primary">
                <div class="card-header text-white bg-teal">
                    Cantidad de ventas por producto
                </div>
                <div class="card-body">
                    <canvas id="myChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function getRandomColor() {
                var letters = '0123456789ABCDEF'.split('');
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        </script>
        <script>
            const informe2 = @json($informe2);
            let consultorio2 = [];
            let cantidad2 = [];
            for (x of informe2) {
                consultorio2.push(x.users);
                cantidad2.push(x.cantidad);
            }
            var ctx = document.getElementById('gDona');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: consultorio2,
                    datasets: [{
                        label: 'My First Dataset',
                        data: cantidad2,
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)',
                            '#1DB76E',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            '27F2DD'

                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            ticks: {
                                stepSize: 1,
                                beginAtZero: true,
                            },
                        }
                    }
                }
            });
        </script>
        <script>
            const informe1 = @json($informe1);
            let fecha1 = [];
            let cantidad1 = [];
            let alquiler = [];
            let ingreso = [];
            let egreso = [];
            for (x of informe1) {
                fecha1.push(x.date_sale);
                cantidad1.push(x.cantidad);
                alquiler.push(x.alquiler);
                ingreso.push(x.ingreso);
                egreso.push(x.egreso);
            }

            var ctx = document.getElementById('gLine');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fecha1,
                    datasets: [{
                        label: 'Venta',
                        data: cantidad1,
                        backgroundColor: [
                            '#3BA8F9',
                        ],
                        borderColor: '#3BA8F9',
                        hoverOffset: 4
                    }, {
                        label: 'Alquiler',
                        data: alquiler,
                        backgroundColor: [
                            '#84FFA2',
                        ],
                        borderColor: '#84FFA2',
                        hoverOffset: 4
                    }, {
                        label: 'Ingreso',
                        data: ingreso,
                        backgroundColor: [
                            '#FFD56C',
                        ],
                        borderColor: '#FFD56C',
                        hoverOffset: 4
                    }, {
                        label: 'Egreso',
                        data: egreso,
                        backgroundColor: [
                            '#FF7187',
                        ],
                        borderColor: '#FF7187',
                        hoverOffset: 4
                    }]
                },
                options: {
                    // plugins: {
                    //     title: {
                    //         display: true,
                    //         text: 'Gráfico Mensual'
                    //     }
                    // },
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }

            });
        </script>
        <script>
            const informe3 = @json($informe3);
            let nomProducto = [];
            let cantidad3 = [];
            for (x of informe3) {
                nomProducto.push(x.nomProducto);
                cantidad3.push(x.cantidad);
            }
            console.log(nomProducto)
            // Any of the following formats may be used
            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nomProducto,
                    datasets: [{
                        label: ['Cantidad de Productos'],
                        data: cantidad3,
                        backgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                stepSize: 1,
                            },
                        },
                    },
                    barPercentage: 0.6
                }
            });
        </script>
    @endpush
@endsection
