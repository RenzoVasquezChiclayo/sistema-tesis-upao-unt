@extends('plantilla.dashboard')
@section('titulo')
    Asignar Asesor
@endsection
@section('contenido')
<div class="card-header">
    Asignar asesor por grupos para tesis
</div>
<div class="card-body">
    <div class="row" style="display:flex; align-items:center;">
        <div class="col-12">
            <div class="row" style="display:flex; align-items:right; justify-content:right; margin-bottom:10px; margin-top:10px;">
                <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                    <form id="listAlumno" name="listAlumno" method="get">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="buscarAlumno" placeholder="Código de matricula o Apellidos" value="{{$buscarAlumno}}" aria-describedby="btn-search">
                                <button class="btn btn-outline-primary" type="submit" id="btn-search">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <form action="{{ route('director.saveAsesorAsignadoGruposTesis') }}" method="post">
                @csrf
                <div class="row mb-3" style="text-align:left; justify-content:flex-start">
                    <div class="flex-container" style="display:flex;">
                        <div style="margin:5px;">
                            <a href="{{route('director.veragregar')}}" class="btn btn-success"><i class='bx bx-sm bx-message-square-add'></i>Nuevo Alumno</a>
                        </div>
                        <div style="margin:5px;">
                            <a href="{{route('director.editAsignacionAsesorTesis')}}" class="btn btn-modificaciones">Editar Asignacion</a>
                        </div>

                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                    </div>
                    {{--  --}}
                    <div class="col-6 col-md-4 col-lg-2">
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-proyecto" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>Numero de grupo</td>
                                <td>Estudiante</td>
                                <td>Asignar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cont = 0;
                                $lastGroup = 0;
                            @endphp
                            @foreach ($studentforGroups as $grupo)
                                <tr>
                                    <td>{{$grupo[0]->num_grupo}}</td>
                                    <td>@if(count($grupo)>1){{$grupo[0]->apellidos.' '.$grupo[0]->nombres.' & '.$grupo[1]->apellidos.' '.$grupo[1]->nombres}}@else{{$grupo[0]->apellidos.' '.$grupo[0]->nombres}}@endif</td>

                                    <td>
                                        <select name="cboAsesor_{{$cont}}" id="cboAsesor_{{$cont}}" class="form-control" onchange="validarSeleccion({{$cont}});"
                                        @if ($grupo[0]->cod_docente_tesis != null)
                                            disabled
                                        @endif
                                        >
                                            <option value="0">-</option>
                                            @foreach ($asesores as $ase)
                                                <option value="{{$ase->cod_docente}}"
                                                @if ($grupo[0]->cod_docente_tesis == $ase->cod_docente)
                                                    selected
                                                @endif
                                                >{{$ase->nombres." ".$ase->apellidos}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input  class="btn btn-success" id="btnAsesor_{{$cont}}" type="button" value="+" onclick="guardarAsesor({{$cont}});" hidden>
                                        <input type="button" class="btn" style="color:white; background-color: rgb(219, 98, 98)" value="-" id="btnDeleteAsignar_{{$cont}}" onclick="deleteAsignacion({{$cont}});" hidden>
                                    </td>
                                </tr>
                                <input type="hidden" id="codEst_{{$cont}}_grupo" value="{{$grupo[0]->id_grupo}}">
                                @php
                                    $cont++;
                                @endphp
                            @endforeach
                            <input type="hidden" name="saveAsesor" id="saveAsesor">

                        </tbody>
                    </table>
                    {{$studentforGroups->links()}}
                </div>
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
        var arregloAsesor = [];
            function validarSeleccion(cont){
                const selector = document.getElementById('cboAsesor_'+cont);
                index = document.getElementById('cboAsesor_'+cont).selectedIndex;
                if (index!=0) {
                    document.getElementById("btnAsesor_"+cont).hidden=false;
                    selector.style.backgroundColor='lightyellow';
                }else {
                    document.getElementById("btnAsesor_"+cont).hidden=true;

                }
            }
            //CAMBIAR

            function guardarAsesor(cont){
                const selector = document.getElementById('cboAsesor_'+cont);
                asesor = document.getElementById('cboAsesor_'+cont).value;

                groupStudent = document.getElementById('codEst_'+cont+'_grupo').value;

                arregloAsesor[cont] = groupStudent+'_'+asesor;

                document.getElementById('saveAsesor').value = arregloAsesor;

                document.getElementById("saveAsignacion").hidden=false;
                selector.style.backgroundColor='lightgreen';
                document.getElementById('btnDeleteAsignar_'+cont).hidden=false;

            }

            //Cambio
            function deleteAsignacion(cont){
                const selector = document.getElementById('cboAsesor_'+cont);
                document.getElementById('cboAsesor_'+cont).selectedIndex = 0;
                arregloAsesor[cont] = "";
                document.getElementById("btnAsesor_"+cont).hidden=true;
                document.getElementById('btnDeleteAsignar_'+cont).hidden=true;
                selector.style.backgroundColor='white';
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
