@extends('plantilla.dashboard')
@section('titulo')
    Solicitudes de designacion de jurado
@endsection
@section('css')
    <style type="text/css">

    </style>
@endsection
@section('contenido')
    <div class="card-header">
        Solicitudes de designacion de jurados
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            {{-- <div class="row justify-content-end">
                <div class="row mb-3 justify-content-end align-items-center">
                    <div class="col-md-3">
                        <h5>Filtrar</h5>
                        <form id="filtrarAlumno" name="filtrarAlumno" method="get">
                            <div class="row">
                                <div class="input-group">
                                    <select class="form-select" name="filtrar_semestre"
                                        id="filtrar_semestre" required>
                                        @foreach ($semestre as $sem)
                                            <option value="{{ $sem->cod_configuraciones }}">
                                                {{ $sem->año }}_{{ $sem->curso }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-primary" type="submit"
                                        id="btn-search">Filtrar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="col col-sm-8 col-md-6">
                        <h5>Buscar alumno</h5>
                        <form id="listAlumno" name="listAlumno" method="get">
                            <div class="row">
                                <input name="semestre" id="semestre" type="text" hidden>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="buscarAlumno"
                                        placeholder="Codigo de matricula o Apellidos"
                                        value="" aria-describedby="btn-search">
                                    <button class="btn btn-outline-primary" type="button" onclick="saveStateSemestre(this);"
                                        id="btn-search">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
            <div class="row" style="display: flex; align-items:center;">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="table-proyecto" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Fecha Solicitud</td>
                                    <td>Numero Matricula</td>
                                    <td>Nombres</td>
                                    <td>Asesor</td>
                                    <td>Razon Solicitud</td>
                                    <td>Archivos</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($solicitud as $soli)
                                    <tr>
                                        <td>{{$soli->fecha_solicitud}}</td>
                                        <td>{{$soli->dni}}</td>
                                        <td>{{$soli->nombres.' '.$soli->apellidos}}</td>
                                        <td>{{$soli->nombresAsesor.' '.$soli->apellidosAsesor}}</td>
                                        <td>{{$soli->razon_solicitud}}</td>
                                        <td style="text-align: center;">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#voucherModal">
                                                        <i class='bx bx-dollar-circle'></i>
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal" id="voucherModal" role="dialog" aria-labelledby="voucherModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <img src="cursoTesis-2022/img/alumnos-vouchers/solicitud-jurados/{{$soli->cod_matricula}}/{{$soli->voucher}}" alt="Imagen" class="img-fluid">
                                                                </div>
                                                                <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <form id="verInforme" action="{{route('asesor.pdfInformeFinal')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="cod_tesis" value="{{$soli->cod_tesis}}">
                                                        <a href="#" onclick="this.closest('#verInforme').submit()"><i class='bx bx-notepad'></i></a>
                                                    </form>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Alumno agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar el alumno',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'exists')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ya existe un alumno con el mismo codigo de matricula',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    <script type="text/javascript">

    </script>
@endsection
