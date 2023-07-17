@extends('plantilla.dashboard')
@section('titulo')
    Crear Grupos de Investigacion
@endsection
@section('contenido')
    <div class="row" style="display: flex; align-items:center; padding-top:15px;">
        <h3>Agregar Grupo de de Investigacion</h3>
        <div class="col-12">
            @if (sizeof($grupo) > 0 && sizeof($detalle_grupo) > 0)
                    @foreach ($grupo as $g)
                        <div class="row" id="grupo_'+num_grupo+'">
                            <h4>{{$g->num_grupo}}</h4>
                            @foreach ($detalle_grupo as $d_g)
                                @if ($d_g->id_grupo_inves == $g->id_grupo)
                                    <div class="col-4">
                                        <label for="">Estudiante</label>
                                        <select class="form-control" name="select_grupo_{{$g->id_grupo}}_e_1" id="select_grupo_{{$g->id_grupo}}_e_1">
                                            <option value="-">-</option>
                                            @foreach ($estudiantes as $est)
                                                <option value="{{$est->cod_matricula}}"
                                                    @if ($d_g->cod_matricula == $est->cod_matricula)
                                                        selected
                                                    @endif>{{$est->apellidos}} {{$est->nombres}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                            <div class="col-1" id="btn_eliminar_e_{{$d_g->id_grupo_inves}}">
                                <input class="btn btn-danger" type="button" value="-" onclick="eliminarEstudiante({{$d_g->id_grupo_inves}});">
                            </div>
                            <div class="col-1" id="btn_guardar_{{$d_g->id_grupo_inves}}">
                                <input class="btn btn-success" type="button" value="+" onclick="guardarGrupo({{$d_g->id_grupo_inves}});">
                            </div>
                            {{-- <div class="col-4" id="otro_estudiante_grupo{{$d_g->id_grupo_inves}}">
                                <label for="">Estudiante 2</label>
                                <select class="form-control" name="select_grupo_{{$d_g->id_grupo_inves}}_e_2" id="select_grupo_{{$d_g->id_grupo_inves}}_e_2">
                                    <option value="-">-</option>
                                    @foreach ($estudiantes as $est)
                                        <option value="{{$est->cod_matricula}}">{{$est->apellidos}} {{$est->nombres}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                        </div>
                    @endforeach
                @endif
            <div id="ver_grupo" hidden>

            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-5">
                    <input class="btn btn-primary" type="button" value="Nuevo grupo" onclick="verGrupo()">
                </div>
            </div>

        </div>
        <form action="{{ route('director.saveGruposInvestigacion') }}" method="post">
            @csrf
            <input type="hidden" name="arreglo_grupos" id="arreglo_grupos">
            <div class="row" style="margin: 10px;">
                <div class="col-12" style="text-align: center;">
                    <input class="btn btn-success" type="submit" value="Guardar grupos" id="saveGrupos" hidden>
                </div>
            </div>
        </form>

    </div>

@endsection
@section("js")
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        let num_grupo = 1
        function verGrupo(){

            ver_grupo = document.getElementById("ver_grupo");
            saveGrupos = document.getElementById("saveGrupos");

            ver_grupo.hidden = false;
            linea = '<div class="row" id="grupo_'+num_grupo+'"><h4>Grupo '+num_grupo+'</h4><div class="col-4"><label for="">Estudiante 1</label><select class="form-control" name="select_grupo_'+num_grupo+'_e_1" id="select_grupo_'+num_grupo+'_e_1"><option value="-">-</option>@foreach ($estudiantes as $est)<option value="{{$est->cod_matricula}}">{{$est->apellidos}} {{$est->nombres}}</option>@endforeach</select></div><div class="col-1" id="btn_otro_estudiante_grupo'+num_grupo+'"><input class="btn btn-info" type="button" value="Otro" onclick="otroEstudiante('+num_grupo+');"></div><div class="col-4" id="otro_estudiante_grupo'+num_grupo+'" hidden><label for="">Estudiante 2</label><select class="form-control" name="select_grupo_'+num_grupo+'_e_2" id="select_grupo_'+num_grupo+'_e_2"><option value="-">-</option>@foreach ($estudiantes as $est)<option value="{{$est->cod_matricula}}">{{$est->apellidos}} {{$est->nombres}}</option>@endforeach</select></div><div class="col-1" id="btn_eliminar_e_'+num_grupo+'" hidden><input class="btn btn-danger" type="button" value="-" onclick="eliminarEstudiante('+num_grupo+');"></div><div class="col-1" id="btn_guardar_'+num_grupo+'" hidden><input class="btn btn-success" type="button" value="+" onclick="guardarGrupo('+num_grupo+');"></div></div>'

            ver_grupo.innerHTML += linea;
            btn_guardar_grupo = document.getElementById("btn_guardar_"+num_grupo);
            btn_guardar_grupo.hidden = false;
            saveGrupos.hidden = false;
            num_grupo++;
        }

        function otroEstudiante(cont){
            otro_estudiante = document.getElementById("otro_estudiante_grupo"+cont);
            btn_otro_estudiante = document.getElementById("btn_otro_estudiante_grupo"+cont);
            btn_eliminar_e = document.getElementById("btn_eliminar_e_"+cont);

            otro_estudiante.hidden = false;
            btn_otro_estudiante.hidden = true;
            btn_eliminar_e.hidden = false;

        }

        function eliminarEstudiante(count){
            btn_otro_estudiante = document.getElementById("btn_otro_estudiante_grupo"+count);
            btn_eliminar_e = document.getElementById("btn_eliminar_e_"+count);
            otro_estudiante_grupo = document.getElementById("otro_estudiante_grupo"+count);
            otro_estudiante_grupo.hidden = true;
            btn_otro_estudiante.hidden = false;
            btn_eliminar_e.hidden = true;
        }
        let datos = [];
        function guardarGrupo(count){
            estudiante1 = document.getElementById("select_grupo_"+count+"_e_1").value;
            estudiante2 = document.getElementById("select_grupo_"+count+"_e_2").value;
            otro_estudiante_grupo = document.getElementById("otro_estudiante_grupo"+count);

            if (otro_estudiante_grupo.hidden == true) {
                if (datos[count] != null) {
                    datos.splice(count-1,1,count+"_"+estudiante1+"@");
                }else{
                    datos.push(count+"_"+estudiante1+"@");
                }
            }else{
                if (datos[count] != null) {
                    datos.splice(count-1,1,count+"_"+estudiante1+"@"+estudiante2);
                }else[
                    datos.push(count+"_"+estudiante1+"@"+estudiante2)
                ]

            }
            alert(datos);
            arreglo_datos = document.getElementById("arreglo_grupos").value = datos;

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
            title: 'Error al guardar los grupos',
            showConfirmButton: false,
            timer: 1200
            })
        </script>
    @endif
@endsection
