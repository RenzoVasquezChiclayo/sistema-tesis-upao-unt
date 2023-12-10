@extends('plantilla.dashboard')
@section('titulo')
    Editar Asignacion
@endsection
@section('contenido')
<div class="card-header">
    Editar asignacion de asesor de tesis
</div>
<div class="card-body">
    <div class="row justify-content-around align-items-center">
        <div class="col-12">
            <div class="row" style="display: flex; align-items:center;">
                <div class="col-12">
                    <form action="{{ route('director.saveEditarAsignacion') }}" method="post">
                        @csrf
                        <table id="table-proyecto" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Número de matrícula</td>
                                    <td>Apellidos y nombres</td>
                                    <td>Asesor</td>
                                    <td>Docente</td>
                                    <td>Editar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cont = 0;
                                @endphp
                                @foreach ($estudiantes as $est)
                                    <tr>
                                        <td>{{ $est->cod_matricula }}</td>
                                        <td>{{ $est->apellidos . ' ' . $est->nombres }}.</td>
                                        <td>
                                            <select name="cboAsesor_{{ $cont }}" id="cboAsesor_{{ $cont }}"
                                                class="form-control" onchange="validarSeleccion({{ $cont }});"
                                                @if ($est->cod_docente != null) disabled @endif>
                                                <option value="0">-</option>
                                                @foreach ($asesores as $ase)
                                                    <option value="{{ $ase->cod_docente }}"
                                                        @if ($est->cod_asesor == $ase->cod_docente) selected @endif>
                                                        {{ $ase->nombres." ".$ase->apellidos }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="cboDocente_{{ $cont }}"
                                                id="cboDocente_{{ $cont }}" class="form-control"
                                                onchange="validarSeleccionDocente({{ $cont }});"
                                                @if ($est->cod_docente != null) disabled @endif>
                                                <option value="0">-</option>
                                                @foreach ($asesores as $ase)
                                                    <option value="{{ $ase->cod_docente }}"
                                                        @if ($est->cod_docente == $ase->cod_docente) selected @endif>
                                                        {{ $ase->nombres." ".$ase->apellidos }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="btn btn-success" id="btnAsesor_{{ $cont }}"
                                                type="button" value="+" onclick="guardarAsesor({{ $cont }});"
                                                hidden>
                                            <a class="btn btn-warning" id="btnOpenEdit_{{ $cont }}"
                                                onclick="openEdit({{ $cont }})">
                                                <i class='bx bx-sm bx-edit-alt'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <input type="hidden" id="codEst_{{ $cont }}"
                                        value="{{ $est->cod_matricula }}">

                                    @php
                                        $cont++;
                                    @endphp
                                @endforeach
                                <input type="hidden" name="saveAsesor" id="saveAsesor">
                                <input type="hidden" id="cantidadEstudiantes" value="{{ count($estudiantes) }}">
                            </tbody>
                        </table>

                        <div class="row">
                            <input class="btn btn-success" type="submit" value="Guardar Edicion" id="saveAsignacion"
                                hidden>

                        </div>
                        <a href="{{ route('director.asignarAsesorTesis') }}" class="btn btn-danger">Volver</a>
                    </form>
                    <div>
                        {{ $estudiantes->links() }}
                    </div>
                </div>
            </div>

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

        function validarSeleccionDocente(cont) {
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

            asesor = document.getElementById('cboAsesor_' + cont).value;
            docente = document.getElementById('cboDocente_' + cont).value;

            codEstudiante = document.getElementById('codEst_' + cont).value;

            arregloAsesor[cont] = codEstudiante + '_' + asesor + '_' + docente;

            document.getElementById('saveAsesor').value = arregloAsesor;
            document.getElementById("saveAsignacion").hidden = false;
            document.getElementById("btnAsesor_" + cont).hidden = true;

        }

        function openEdit(cont) {
            document.getElementById('cboAsesor_' + cont).disabled = false;
            document.getElementById('cboDocente_' + cont).disabled = false;
            document.getElementById('btnOpenEdit_' + cont).hidden = true;
        }
    </script>

    @if (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
@endsection
