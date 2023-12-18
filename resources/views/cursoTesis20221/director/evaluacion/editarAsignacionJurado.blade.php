@extends('plantilla.dashboard')
@section('titulo')
    Editar Jurado
@endsection
@section('contenido')
<div class="card-header">
    Editar Jurados de Sustentación
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="row" style="display: flex; align-items:center;">
                <div class="col-12">
                    <form action="{{route('director.editAsignacionJurados')}}" method="post">
                        @csrf
                        <table id="table-proyecto" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Nº</td>
                                    <td>Código Matricula</td>
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
                                @foreach ($tesis_asignadas as $ta)
                                    <tr>
                                        <td >{{ $ta->cod_tesis }}</td>
                                        <td >{{ $ta->cod_matricula }}</td>
                                        <td >{{ $ta->nombresEstu . ' ' . $ta->apellidosEstu }}</td>
                                        <td >{{ $ta->titulo }}</td>
                                        <td >{{ $ta->nombresAsesor . ' ' . $ta->apellidosAsesor }}</td>
                                        <td>
                                            <div class="row">
                                                    <p>1er Jurado</p>
                                                    <select name="cbo1Jurado_{{ $cont }}"
                                                        id="cbo1Jurado_{{ $cont }}" class="form-control"
                                                        onchange="validarSeleccion({{ $cont }});" @if ($ta->cod_jurado1 != null) disabled @endif>
                                                        <option value="0">-</option>
                                                        @foreach ($asesores as $ase)
                                                            @if($ase->cod_docente != $ta->cod_asesor)
                                                                <option value="{{ $ase->cod_docente }}"
                                                                @if ($ta->cod_jurado1==$ase->cod_docente) selected @endif>
                                                                {{ $ase->nombres . ' ' . $ase->apellidos }}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>2do Jurado</p>
                                                    <select name="cbo2Jurado_{{ $cont }}"
                                                        id="cbo2Jurado_{{ $cont }}" class="form-control"
                                                        onchange="validarSeleccion({{ $cont }});" @if ($ta->cod_jurado2 != null) disabled @endif>
                                                        <option value="0">-</option>
                                                        @foreach ($asesores as $ase)
                                                            @if($ase->cod_docente != $ta->cod_asesor)
                                                                <option value="{{ $ase->cod_docente }}"
                                                                    @if ($ta->cod_jurado2==$ase->cod_docente) selected @endif>
                                                                    {{ $ase->nombres . ' ' . $ase->apellidos }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>VOCAL</p>
                                                    <select name="cboVocal_{{ $cont }}"
                                                        id="cboVocal_{{ $cont }}" class="form-control"
                                                        onchange="validarSeleccion({{ $cont }});" @if ($ta->cod_vocal != null) disabled @endif>
                                                        <option value="0">-</option>
                                                        @foreach ($asesores as $ase)
                                                            @if($ase->cod_docente != $ta->cod_asesor)
                                                                <option value="{{ $ase->cod_docente }}" @if ($ta->cod_vocal==$ase->cod_docente) selected @endif>{{ $ase->nombres . ' ' . $ase->apellidos }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <input class="btn btn-success" id="btnValidar_{{ $cont }}"
                                                    type="button" value="+" onclick="guardarJurados({{ $cont }});"
                                                    hidden>
                                            <input type="button" class="btn"
                                                    style="color:white; background-color: rgb(219, 98, 98)" value="-"
                                                    id="btnDeleteAsignar_{{ $cont }}"
                                                    onclick="deleteAsignacion({{ $cont }});" hidden>
                                            <a class="btn btn-warning" id="btnOpenEdit_{{$cont}}" onclick="openEdit({{$cont}})"><i class='bx bx-sm bx-edit-alt'></i></a>
                                        </td>
                                    </tr>
                                    <input type="hidden" id="codTesis_{{ $cont }}" value="{{ $ta->cod_tesis }}">
                                    @php
                                        $cont++;
                                    @endphp
                                @endforeach
                                <input type="hidden" name="saveJurados" id="saveJurados">
                            </tbody>
                        </table>

                        <div class="row" >
                            <input class="btn btn-success" type="submit" value="Guardar Edicion" id="saveAsignacion" hidden>

                        </div>
                        <a href="{{route('director.asignar')}}" class="btn btn-danger">Volver</a>
                    </form>
                        <div>
                            {{$tesis_asignadas->links()}}
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
            const selector1 = document.getElementById('cbo1Jurado_' + cont);
            const selector2 = document.getElementById('cbo2Jurado_' + cont);
            const selector3 = document.getElementById('cboVocal_' + cont);
            index1 = document.getElementById('cbo1Jurado_' + cont).selectedIndex;
            index2 = document.getElementById('cbo2Jurado_' + cont).selectedIndex;
            index3 = document.getElementById('cboVocal_' + cont).selectedIndex;
            if (index1 != 0) {
                selector1.style.backgroundColor = 'lightyellow';
            }
            if (index2 != 0) {
                selector2.style.backgroundColor = 'lightyellow';
            }
            if (index3 != 0) {
                selector3.style.backgroundColor = 'lightyellow';
            }
            if (index1 != 0 && index2 != 0 && index3 != 0) {
                document.getElementById('btnValidar_'+cont).hidden = false;
            }
        }


        var arregloJurados = []

        function guardarJurados(cont) {
            if(document.getElementById('cbo1Jurado_' + cont).selectedIndex ==0 || document.getElementById('cbo2Jurado_' + cont).selectedIndex == 0 || document.getElementById('cboVocal_' + cont).selectedIndex == 0){
                alert("Debe seleccionar un jurado!");
                return;
            }
            const selector1 = document.getElementById('cbo1Jurado_' + cont);
            const selector2 = document.getElementById('cbo2Jurado_' + cont);
            const selector3 = document.getElementById('cboVocal_' + cont);
            jurado1 = document.getElementById('cbo1Jurado_' + cont).value;
            jurado2 = document.getElementById('cbo2Jurado_' + cont).value;
            jurado3 = document.getElementById('cboVocal_' + cont).value;

            if(jurado1 == jurado2 || jurado1 == jurado3 || jurado2 == jurado3){
                alert("No se deben repetir los jurados.");
                return;
            }

            codTesis = document.getElementById('codTesis_' + cont).value;

            arregloJurados[cont] = codTesis + '_' + jurado1 + '_' + jurado2 + '_' + jurado3;

            document.getElementById('saveJurados').value = arregloJurados;

            document.getElementById("saveAsignacion").hidden = false;
            selector1.style.backgroundColor = 'lightgreen';
            selector2.style.backgroundColor = 'lightgreen';
            selector3.style.backgroundColor = 'lightgreen';
            document.getElementById('btnDeleteAsignar_' + cont).hidden = false;

        }

    function openEdit(cont){
        document.getElementById('cbo1Jurado_'+cont).disabled=false;
        document.getElementById('cbo2Jurado_' + cont).disabled = false;
        document.getElementById('cboVocal_' + cont).disabled = false;
        document.getElementById('btnOpenEdit_'+cont).hidden=true;
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
