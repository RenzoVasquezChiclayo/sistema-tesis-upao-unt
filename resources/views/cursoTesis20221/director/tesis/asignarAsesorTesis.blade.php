@extends('plantilla.dashboard')
@section('titulo')
    Asignacion Asesor Tesis
@endsection
@section('contenido')
<div class="card-header">
    Asignar asesor para tesis
</div>
<div class="card-body">
    <div class="row justify-content-around align-items-center">
        <div class="col-12">
            <div class="row"
                style="display:flex; align-items:right; justify-content:right; margin-bottom:10px; margin-top:10px;">
                <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                    <form id="listEstudiante" name="listEstudiante" method="get">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="buscar_estudiante"
                                    placeholder="Codigo de matricula o Apellidos" value="{{ $buscar_estudiante }}"
                                    aria-describedby="btn-search">
                                <button class="btn btn-outline-primary" type="submit" id="btn-search">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <form action="{{ route('director.saveAsignarAsesorTesis') }}" method="post">
                @csrf
                <div class="row mb-3" style="text-align:left; justify-content:flex-start">
                    <div class="flex-container my-2">
                        <a href="{{ route('director.editAsignacionAsesorTesis') }}" class="btn btn-modificaciones">Editar
                            Asignación</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-proyecto" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>Número de matrícula</td>
                                <td>Apellidos y nombres</td>
                                <td>Asesor</td>
                                <td>Docente</td>
                                <td>Acción</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cont = 0;
                            @endphp
                            @foreach ($estudiantes as $est)
                                <tr>
                                    <td>{{ $est->cod_matricula }}</td>
                                    <td>{{ $est->nombres . ' ' . $est->apellidos }}.</td>
                                    <td>
                                        <select name="cboAsesor_{{ $cont }}" id="cboAsesor_{{ $cont }}"
                                            class="form-control" onchange="validarSeleccion({{ $cont }});"
                                            @if ($est->cod_asesor != null) disabled @endif>
                                            <option value="0">-</option>
                                            @foreach ($asesores as $ase)
                                                <option value="{{ $ase->cod_docente }}"
                                                    @if ($est->cod_asesor == $ase->cod_docente) selected @endif>{{ $ase->nombres }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="cboDocente_{{ $cont }}" id="cboDocente_{{ $cont }}"
                                            class="form-control" onchange="validarSeleccionDocente({{ $cont }});"
                                            @if ($est->cod_docente != null) disabled @endif>
                                            <option value="0">-</option>
                                            @foreach ($asesores as $ase)
                                                <option value="{{ $ase->cod_docente }}"
                                                    @if ($est->cod_docente == $ase->cod_docente) selected @endif>{{ $ase->nombres }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 col-lg-6 py-1 py-lg-0">
                                                <input class="btn btn-success w-100" id="btnAsesor_{{ $cont }}"
                                                    type="button" value="+"
                                                    onclick="guardarAsesor({{ $cont }});" hidden>
                                            </div>
                                            <div class="col-12 col-lg-6 py-1 py-lg-0">
                                                <input type="button" class="btn btn-danger w-100" value="-"
                                                    id="btnDeleteAsignar_{{ $cont }}"
                                                    onclick="deleteAsignacion({{ $cont }});" hidden>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <input type="hidden" id="codEst_{{ $cont }}" value="{{ $est->cod_matricula }}">

                                @php
                                    $cont++;
                                @endphp
                            @endforeach
                            <input type="hidden" name="saveAsesor" id="saveAsesor">
                            <input type="hidden" id="cantidadEstudiantes" value="{{ count($estudiantes) }}">
                        </tbody>
                    </table>
                    {{ $estudiantes->links() }}
                </div>
                {{-- <div>
                {{$estudiantes->links()}}
            </div> --}}
                <div class="row" style="margin: 10px;">
                    <div class="col-12" style="text-align: right;">
                        <input class="btn btn-success" type="submit" value="Guardar registro" id="saveAsignacion" hidden>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function validarSeleccion(cont) {
            const selector = document.getElementById('cboAsesor_' + cont);
            index = document.getElementById('cboAsesor_' + cont).selectedIndex;
            if (index != 0) {
                document.getElementById("btnAsesor_" + cont).hidden = false;
                selector.style.backgroundColor = 'lightyellow';
            } else {
                document.getElementById("btnAsesor_" + cont).hidden = true;

            }
        }

        function validarSeleccionDocente(cont){
            const selector = document.getElementById('cboDocente_' + cont);
            index = document.getElementById('cboDocente_' + cont).selectedIndex;
            if (index != 0) {
                document.getElementById("btnAsesor_" + cont).hidden = false;
                selector.style.backgroundColor = 'lightyellow';
            } else {
                document.getElementById("btnDocente_" + cont).hidden = true;
            }
        }

        var arregloAsesor = []

        function guardarAsesor(cont) {
            if(document.getElementById('cboAsesor_' + cont).selectedIndex ==0 || document.getElementById('cboDocente_' + cont).selectedIndex == 0){
                alert("Debe seleccionar un asesor y un docente!");
                return;
            }
            const selector = document.getElementById('cboAsesor_' + cont);
            asesor = document.getElementById('cboAsesor_' + cont).value;

            const selectorDocente = document.getElementById('cboDocente_' + cont);
            docente = document.getElementById('cboDocente_' + cont).value;

            codEstudiante = document.getElementById('codEst_' + cont).value;

            arregloAsesor[cont] = codEstudiante + '_' + asesor + '_' + docente;

            document.getElementById('saveAsesor').value = arregloAsesor;

            document.getElementById("saveAsignacion").hidden = false;
            selector.style.backgroundColor = 'lightgreen';
            selectorDocente.style.backgroundColor = 'lightgreen';
            document.getElementById('btnDeleteAsignar_' + cont).hidden = false;
        }

        //Cambio
        function deleteAsignacion(cont) {
            const selector = document.getElementById('cboAsesor_' + cont);
            const selectorDocente = document.getElementById('cboDocente_' + cont);

            document.getElementById('cboAsesor_' + cont).selectedIndex = 0;
            document.getElementById('cboDocente_' + cont).selectedIndex = 0;

            arregloAsesor[cont] = "";
            document.getElementById("btnAsesor_" + cont).hidden = true;
            document.getElementById('btnDeleteAsignar_' + cont).hidden = true;
            selector.style.backgroundColor = 'white';
            selectorDocente.style.backgroundColor = 'white';
        }
    </script>

    @if (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Guardado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al guardar',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
@endsection
