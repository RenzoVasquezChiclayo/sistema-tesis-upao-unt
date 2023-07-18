@extends('plantilla.dashboard')
@section('titulo')
    Crear Grupos de Investigacion
@endsection
@section('contenido')
    <div class="row" style="display: flex; align-items:center; padding-top:15px;">
        <h3>Crear grupos de investigación</h3>
        <div class="col-12">
            <div class="row" style="margin-top: 10px;">
                <div class="col-8" id="fieldsBody">
                    <div class="row">
                        <div class="col-6">
                            <label for="">Estudiante</label>
                            <select class="form-control" name="select_0_student"
                                id="select_0_student">
                                <option value="-">-</option>
                                @foreach ($estudiantes as $est)
                                    <option value="{{ $est->cod_matricula }}">
                                        {{ $est->apellidos }} {{ $est->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-success" id="addStudent" type="button" onclick="addFieldStudent();"><i class='bx bx-plus bx-xs'></i></button>
                            <button class="btn btn-danger" id="deleteStudent" type="button" onclick="deleteFieldStudent(0);" hidden><i class='bx bx-minus bx-xs'></i></button>
                        </div>
                    </div>

                </div>
                <div class="col-4">
                    <input class="btn btn-primary" type="button" value="Crear grupo" onclick="verGrupo()">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="table-proyecto" class="table table-striped table-responsive-md">
                <thead>
                    <tr>
                        <td>Numero de grupo</td>
                        <td>Estudiante(s)</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cont = 0;
                        $lastGroup = 0;
                    @endphp
                    @foreach ($studentforGroups as $grupo)
                        <tr>
                            <td>{{ $grupo[0]->num_grupo }}</td>
                            <td>
                                @if (count($grupo) > 1)
                                    {{ $grupo[0]->apellidos . ' ' . $grupo[0]->nombres . ' & ' . $grupo[1]->apellidos . ' ' . $grupo[1]->nombres }}@else{{ $grupo[0]->apellidos . ' ' . $grupo[0]->nombres }}
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning"><i class='bx bxs-edit bx-xs'></i></button>
                                <button type="button" class="btn btn-danger"><i class='bx bxs-trash bx-xs'></i></button>
                            </td>
                        </tr>
                        @php
                            $cont++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            {{ $studentforGroups->links() }}
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
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        let num_grupo = 1
        let datos = [];
        //Recently added
        let studentNumber = [0];
        let lastStudentSelected = 0;
        function deleteFieldStudent(code){

        }
        function addFieldStudent(){
            studentNumber.push(studentNumber[0]+1);
            const fieldsBody = document.getElementById('fieldsBody');
            const lastItem = studentNumber[studentNumber.length - 1];
            const newRow = document.createElement("div");
            newRow.class = "row";
            newRow.innerHTML = `<div class="row">
                        <div class="col-6">
                            <label for="">Estudiante</label>
                            <select class="form-control" name="select_`+lastItem+`_student" id="select_`+lastItem+`_student" onchange="onSelectStudent(`+lastItem+`);">
                                <option value="-">-</option>
                                @foreach ($estudiantes as $est)
                                    <option value="{{ $est->cod_matricula }}">
                                        {{ $est->apellidos }} {{ $est->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-success" id="addStudent" type="button" hidden><i class="bx bx-plus bx-xs"></i></button>
                            <button class="btn btn-danger" id="deleteStudent" type="button"><i class="bx bx-minus bx-xs"></i></button>
                        </div>
                    </div>`;
            fieldsBody.appendChild(newRow);

        }
        function onSelectStudent(id){

            const student = document.getElementById(`select_${id}_student`).value;
            if(lastStudentSelected==0){
                lastStudentSelected = student;
                datos.push(student);
            }else{
                if(datos.size > 1){
                    datos = datos.filter(e=>{e!=lastStudentSelected});
                }
                datos.push(student);
                lastStudentSelected = student;
            }
            //datos = datos.filter(e=>{e!=code});
        }

        //------
        function verGrupo() {

            ver_grupo = document.getElementById("ver_grupo");
            saveGrupos = document.getElementById("saveGrupos");

            ver_grupo.hidden = false;
            linea = '<div class="row" id="grupo_' + num_grupo + '"><h4>Grupo ' + num_grupo +
                '</h4><div class="col-4"><label for="">Estudiante 1</label><select class="form-control" name="select_grupo_' +
                num_grupo + '_e_1" id="select_grupo_' + num_grupo +
                '_e_1"><option value="-">-</option>@foreach ($estudiantes as $est)<option value="{{ $est->cod_matricula }}">{{ $est->apellidos }} {{ $est->nombres }}</option>@endforeach</select></div><div class="col-1" id="btn_otro_estudiante_grupo' +
                num_grupo + '"><input class="btn btn-info" type="button" value="Otro" onclick="otroEstudiante(' +
                num_grupo + ');"></div><div class="col-4" id="otro_estudiante_grupo' + num_grupo +
                '" hidden><label for="">Estudiante 2</label><select class="form-control" name="select_grupo_' + num_grupo +
                '_e_2" id="select_grupo_' + num_grupo +
                '_e_2"><option value="-">-</option>@foreach ($estudiantes as $est)<option value="{{ $est->cod_matricula }}">{{ $est->apellidos }} {{ $est->nombres }}</option>@endforeach</select></div><div class="col-1" id="btn_eliminar_e_' +
                num_grupo + '" hidden><input class="btn btn-danger" type="button" value="-" onclick="eliminarEstudiante(' +
                num_grupo + ');"></div><div class="col-1" id="btn_guardar_' + num_grupo +
                '" hidden><input class="btn btn-success" type="button" value="+" onclick="guardarGrupo(' + num_grupo +
                ');"></div></div>'

            ver_grupo.innerHTML += linea;
            btn_guardar_grupo = document.getElementById("btn_guardar_" + num_grupo);
            btn_guardar_grupo.hidden = false;
            saveGrupos.hidden = false;
            num_grupo++;
        }

        function otroEstudiante(cont) {
            otro_estudiante = document.getElementById("otro_estudiante_grupo" + cont);
            btn_otro_estudiante = document.getElementById("btn_otro_estudiante_grupo" + cont);
            btn_eliminar_e = document.getElementById("btn_eliminar_e_" + cont);

            otro_estudiante.hidden = false;
            btn_otro_estudiante.hidden = true;
            btn_eliminar_e.hidden = false;

        }

        function eliminarEstudiante(count) {
            btn_otro_estudiante = document.getElementById("btn_otro_estudiante_grupo" + count);
            btn_eliminar_e = document.getElementById("btn_eliminar_e_" + count);
            otro_estudiante_grupo = document.getElementById("otro_estudiante_grupo" + count);
            otro_estudiante_grupo.hidden = true;
            btn_otro_estudiante.hidden = false;
            btn_eliminar_e.hidden = true;
        }


        function guardarGrupo(count) {
            estudiante1 = document.getElementById("select_grupo_" + count + "_e_1").value;
            estudiante2 = document.getElementById("select_grupo_" + count + "_e_2").value;
            otro_estudiante_grupo = document.getElementById("otro_estudiante_grupo" + count);

            if (otro_estudiante_grupo.hidden == true) {
                if (datos[count] != null) {
                    datos.splice(count - 1, 1, count + "_" + estudiante1 + "@");
                } else {
                    datos.push(count + "_" + estudiante1 + "@");
                }
            } else {
                if (datos[count] != null) {
                    datos.splice(count - 1, 1, count + "_" + estudiante1 + "@" + estudiante2);
                } else [
                    datos.push(count + "_" + estudiante1 + "@" + estudiante2)
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
