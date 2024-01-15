@extends('plantilla.dashboard')
@section('titulo')
    Designacion de jurados
@endsection
@section('css')
    <style type="text/css">

    </style>
@endsection
@section('contenido')
    <div class="card-header">
        Designacion de jurados
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
            <div class="row">
                <div style="margin:5px;">
                    <a href="" class="btn btn-modificaciones">Editar Asignacion</a>
                </div>
            </div>
            <form action="{{ route('director.saveAsignacionJurados') }}" method="post">
                @csrf
                <div class="row" style="display: flex; align-items:center;">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="table-proyecto" class="table table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <td>Nº</td>
                                        <td>Nombres</td>
                                        <td>Titulo</td>
                                        <td>Asesor</td>
                                        <td>Designar</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 0;
                                    @endphp
                                    @foreach ($tesisAgrupadas as $ta)
                                        <tr>
                                            <td>{{ $ta[0]['cod_tesis'] }}</td>
                                            <td>
                                                @foreach ($ta[0]['autores'] as $index => $autor)
                                                    {{ $autor['nombresAutor'] . ' ' . $autor['apellidosAutor'] }}
                                                    @if ($index < count($ta[0]['autores']) - 1)
                                                        &amp;
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $ta[0]['titulo'] }}</td>
                                            <td>{{ $ta[0]['nombresAsesor'] . ' ' . $ta[0]['apellidosAsesor'] }}</td>
                                            <td style="text-align: center;">
                                                <div class="row">
                                                    <p>1er Jurado</p>
                                                    <select name="cbo1Jurado_{{ $cont }}"
                                                        id="cbo1Jurado_{{ $cont }}" class="form-control"
                                                        onchange="validarSeleccion({{ $cont }});"
                                                        @if ($ta[0]['cod_jurado1'] != null) disabled @endif>
                                                        <option value="0">-</option>
                                                        @foreach ($ta[1] as $asesores)
                                                            @if ($asesores->cod_docente != $ta[0]['cod_docente'])
                                                                <option value="{{ $asesores->cod_docente }}"
                                                                    @if ($ta[0]['cod_jurado1'] == $asesores->cod_docente) selected @endif>
                                                                    {{ $asesores->nombres . ' ' . $asesores->apellidos }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>2do Jurado</p>
                                                    <select name="cbo2Jurado_{{ $cont }}"
                                                        id="cbo2Jurado_{{ $cont }}" class="form-control"
                                                        onchange="validarSeleccion({{ $cont }});"
                                                        @if ($ta[0]['cod_jurado2'] != null) disabled @endif>
                                                        <option value="0">-</option>
                                                        @foreach ($ta[1] as $asesores)
                                                            @if ($asesores->cod_docente != $ta[0]['cod_docente'])
                                                                <option value="{{ $asesores->cod_docente }}"
                                                                    @if ($ta[0]['cod_jurado2'] == $asesores->cod_docente) selected @endif>
                                                                    {{ $asesores->nombres . ' ' . $asesores->apellidos }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>VOCAL</p>
                                                    <select name="cboVocal_{{ $cont }}"
                                                        id="cboVocal_{{ $cont }}" class="form-control"
                                                        onchange="validarSeleccion({{ $cont }});"
                                                        @if ($ta[0]['cod_jurado3'] != null) disabled @endif>
                                                        <option value="0">-</option>
                                                        @foreach ($ta[1] as $asesores)
                                                            @if ($asesores->cod_docente != $ta[0]['cod_docente'])
                                                                <option value="{{ $asesores->cod_docente }}"
                                                                    @if ($ta[0]['cod_jurado3'] == $asesores->cod_docente) selected @endif>
                                                                    {{ $asesores->nombres . ' ' . $asesores->apellidos }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>VOCAL</p>
                                                    <select name="cbo4Jurado_{{ $cont }}"
                                                        id="cbo4Jurado_{{ $cont }}" class="form-control"
                                                        onchange="validarSeleccion({{ $cont }});"
                                                        @if ($ta[0]['cod_jurado4'] != null) disabled @endif>
                                                        <option value="0">-</option>
                                                        @foreach ($ta[1] as $asesores)
                                                            @if ($asesores->cod_docente != $ta[0]['cod_docente'])
                                                                <option value="{{ $asesores->cod_docente }}"
                                                                    @if ($ta[0]['cod_jurado4'] == $asesores->cod_docente) selected @endif>
                                                                    {{ $asesores->nombres . ' ' . $asesores->apellidos }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input class="btn btn-success" id="btnValidar_{{ $cont }}"
                                                    type="button" value="+" onclick="guardarJurados({{ $cont }});"
                                                    hidden>
                                                <input type="button" class="btn"
                                                    style="color:white; background-color: rgb(219, 98, 98)" value="-"
                                                    id="btnDeleteAsignar_{{ $cont }}"
                                                    onclick="deleteAsignacion({{ $cont }});" hidden>
                                            </td>
                                        </tr>
                                        <input type="hidden" id="codTesis_{{ $cont }}"
                                            value="{{ $ta[0]['cod_tesis'] }}">
                                        @php
                                            $cont++;
                                        @endphp
                                    @endforeach
                                    <input type="hidden" name="saveJurados" id="saveJurados">
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="row" style="margin: 10px;">
                    <div class="col-12" style="text-align: right;">
                        <input class="btn btn-success" type="submit" value="Guardar registro" id="saveAsignacion" hidden>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos') == 'okdesignacion')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Designacion correcta',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknotdesignacion')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error en la designacion',
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
        // const asesoresFromBd = @json($asesores);
        // let asesorForStudent = [];
        function validarSeleccion(cont) {
            const selector1 = document.getElementById('cbo1Jurado_' + cont);
            const selector2 = document.getElementById('cbo2Jurado_' + cont);
            const selector3 = document.getElementById('cboVocal_' + cont);
            const selector4 = document.getElementById('cbo4Jurado_' + cont);
            index1 = document.getElementById('cbo1Jurado_' + cont).selectedIndex;
            index2 = document.getElementById('cbo2Jurado_' + cont).selectedIndex;
            index3 = document.getElementById('cboVocal_' + cont).selectedIndex;
            index4 = document.getElementById('cbo4Jurado_' + cont).selectedIndex;
            if (index1 != 0) {
                selector1.style.backgroundColor = 'lightyellow';
            }
            if (index2 != 0) {
                selector2.style.backgroundColor = 'lightyellow';
            }
            if (index3 != 0) {
                selector3.style.backgroundColor = 'lightyellow';
            }
            if (index4 != 0) {
                selector4.style.backgroundColor = 'lightyellow';
            }
            if (index1 != 0 && index2 != 0 && index3 != 0 && index4 != 0) {
                document.getElementById('btnValidar_'+cont).hidden = false;
            }
        }


        var arregloJurados = []

        function guardarJurados(cont) {
            if(document.getElementById('cbo1Jurado_' + cont).selectedIndex ==0 || document.getElementById('cbo2Jurado_' + cont).selectedIndex == 0 || document.getElementById('cboVocal_' + cont).selectedIndex == 0 || document.getElementById('cbo4Jurado_' + cont).selectedIndex == 0){
                alert("Debe seleccionar un jurado!");
                return;
            }
            const selector1 = document.getElementById('cbo1Jurado_' + cont);
            const selector2 = document.getElementById('cbo2Jurado_' + cont);
            const selector3 = document.getElementById('cboVocal_' + cont);
            const selector4 = document.getElementById('cbo4Jurado_' + cont);
            jurado1 = document.getElementById('cbo1Jurado_' + cont).value;
            jurado2 = document.getElementById('cbo2Jurado_' + cont).value;
            jurado3 = document.getElementById('cboVocal_' + cont).value;
            jurado4 = document.getElementById('cbo4Jurado_' + cont).value;

            if(jurado1 == jurado2 || jurado1 == jurado3 || jurado1 == jurado4 || jurado2 == jurado3 || jurado2 == jurado4 || jurado3 == jurado4){
                alert("No se deben repetir los jurados.");
                return;
            }

            codTesis = document.getElementById('codTesis_' + cont).value;

            arregloJurados[cont] = codTesis + '_' + jurado1 + '_' + jurado2 + '_' + jurado3 + '_' + jurado4;
            document.getElementById('saveJurados').value = arregloJurados;
            document.getElementById("saveAsignacion").hidden = false;
            selector1.style.backgroundColor = 'lightgreen';
            selector2.style.backgroundColor = 'lightgreen';
            selector3.style.backgroundColor = 'lightgreen';
            selector4.style.backgroundColor = 'lightgreen';
            document.getElementById('btnDeleteAsignar_' + cont).hidden = false;

        }

        function deleteAsignacion(cont) {
            const selector1 = document.getElementById('cbo1Jurado_' + cont);
            const selector2 = document.getElementById('cbo2Jurado_' + cont);
            const selector3 = document.getElementById('cboVocal_' + cont);
            const selector4 = document.getElementById('cbo4Jurado_' + cont);

            document.getElementById('cbo1Jurado_' + cont).selectedIndex = 0;
            document.getElementById('cbo2Jurado_' + cont).selectedIndex = 0;
            document.getElementById('cboVocal_' + cont).selectedIndex = 0;
            document.getElementById('cbo4Jurado_' + cont).selectedIndex = 0;
            arregloJurados[cont] = "";
            document.getElementById("btnValidar_" + cont).hidden = true;
            document.getElementById('btnDeleteAsignar_' + cont).hidden = true;
            selector1.style.backgroundColor = 'white';
            selector2.style.backgroundColor = 'white';
            selector3.style.backgroundColor = 'white';
            selector4.style.backgroundColor = 'white';
        }
    </script>
@endsection
