@extends('plantilla.dashboard')
@section('titulo')
    Editar Asesor Asignado
@endsection
@section('contenido')
<div class="row">
    <div class="col-12">
        <div class="row" style="display: flex; align-items:center;">
            <div class="col-12">

                <h1>EDITAR</h1>
                <form action="{{route('director.saveEdicion')}}" method="post">
                    @csrf
                    <table id="table-proyecto" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>Numero de grupo</td>
                                <td>Estudiante(s)</td>
                                <td>Asignar asesor</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cont = 0;
                            @endphp
                            @foreach ($studentforGroups as $grupo)
                                <tr>
                                    <td>{{$grupo[0]->num_grupo}}</td>
                                    <td>@if(count($grupo)>1){{$grupo[0]->apellidos.' '.$grupo[0]->nombres.' & '.$grupo[1]->apellidos.' '.$grupo[1]->nombres}}@else{{$grupo[0]->apellidos.' '.$grupo[0]->nombres}}@endif</td>

                                    <td>
                                        <select name="cboAsesor_{{$cont}}" id="cboAsesor_{{$cont}}" class="form-control" onchange="validarSeleccion({{$cont}});"
                                        @if ($grupo[0]->cod_docente != null)
                                            disabled
                                        @endif
                                        >
                                            <option value="0">-</option>
                                            @foreach ($asesores as $ase)
                                                <option value="{{$ase->cod_docente}}"
                                                @if ($grupo[0]->cod_docente == $ase->cod_docente)
                                                    selected
                                                @endif
                                                >{{$ase->nombres}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input  class="btn btn-success" id="btnAsesor_{{$cont}}" type="button" value="+" onclick="guardarAsesor({{$cont}});" hidden>
                                    </td>
                                    @if ($grupo[0]->cod_docente != null)
                                            <td><a class="btn btn-warning" id="btnOpenEdit_{{$cont}}" onclick="openEdit({{$cont}})"><i class='bx bx-sm bx-edit-alt'></i></a></td>
                                    @endif
                                </tr>
                                <input type="hidden" id="codEst_{{$cont}}_grupo" value="{{$grupo[0]->id_grupo}}">
                                @php
                                    $cont++;
                                @endphp
                            @endforeach
                            <input type="hidden" name="saveAsesor" id="saveAsesor">
                        </tbody>
                    </table>

                    <div class="row" >
                        <input class="btn btn-success" type="submit" value="Guardar Edicion" id="saveAsignacion" hidden>
                    </div>
                    <a href="{{route('director.asignarAsesorGrupos')}}" class="btn btn-danger">Volver</a>
                </form>
                <div>
                    {{$studentforGroups->links()}}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    var arregloAsesor = [];
    function validarSeleccion(cont){

        index = document.getElementById('cboAsesor_'+cont).selectedIndex;

        if (index!=0) {

            document.getElementById("btnAsesor_"+cont).hidden=false;
        }else {
            document.getElementById("btnAsesor_"+cont).hidden=true;
        }
    }


    function guardarAsesor(cont){

        asesor = document.getElementById('cboAsesor_'+cont).value;

        idGrupo = document.getElementById(`codEst_${cont}_grupo`).value;

        arregloAsesor[cont] = idGrupo+'_'+asesor;

        document.getElementById('saveAsesor').value = arregloAsesor;

        document.getElementById("saveAsignacion").hidden=false;
        document.getElementById("btnAsesor_"+cont).hidden=true;

    }

    function openEdit(cont){
        document.getElementById('cboAsesor_'+cont).disabled=false;
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
