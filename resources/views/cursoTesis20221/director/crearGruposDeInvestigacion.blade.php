@extends('plantilla.dashboard')
@section('titulo')
    Crear Grupos de Investigacion
@endsection
@section('contenido')
    <div class="row" style="display: flex; align-items:center; padding-top:15px;">
        <h3>Crear grupos de investigación</h3>
        <div class="col-12">
            <div class="row" style="margin-top: 10px;">
                <div class="col-7" id="fieldsBody">
                    <div class="row" id="rowStudent_0">
                        <div class="col-6">
                            <label for="">Estudiante</label>
                            <select class="form-control" name="selectStudent_0"
                                id="selectStudent_0" onchange="onSelectStudent(0);">
                                <option value="-">-</option>
                                @foreach ($estudiantes as $est)
                                    <option value="{{ $est->cod_matricula }}">
                                        {{ $est->apellidos }} {{ $est->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-danger" id="deleteStudent_0" type="button" onclick="deleteFieldStudent(0);" hidden><i class='bx bx-minus bx-xs'></i></button>
                        </div>
                    </div>

                </div>
                <div class="col-2">
                    <button class="btn btn-success" id="addStudent" type="button" onclick="addFieldStudent();"><i class='bx bx-plus bx-xs'></i></button>
                </div>
                <div class="col-3">
                <form name="form1" action="{{ route('director.saveGruposInvestigacion') }}" method="post">
                    @csrf
                    <input type="hidden" name="arreglo_grupos" id="arreglo_grupos">
                    <div class="row" style="margin: 10px;">
                        <div class="col-12" style="text-align: center;">
                            <input class="btn btn-success" type="button" value="Crear grupo" id="saveGrupos" onclick="guardarGrupo();">
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="table-proyecto" class="table table-striped table-responsive-md">
                <thead>
                    <tr>
                        <td>Numero de grupo</td>
                        <td>Estudiante(s)</td>
                        {{-- <td>Acciones</td> --}}
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
                            {{-- <td>
                                <button type="button" class="btn btn-warning"><i class='bx bxs-edit bx-xs'></i></button>
                                <button type="button" class="btn btn-danger"><i class='bx bxs-trash bx-xs'></i></button>
                            </td> --}}
                        </tr>
                        @php
                            $cont++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            {{ $studentforGroups->links() }}
        </div>


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

        function addFieldStudent(){
            studentNumber.push(studentNumber[studentNumber.length - 1]+1);
            const fieldsBody = document.getElementById('fieldsBody');
            const lastItem = studentNumber[studentNumber.length - 1];
            const newRow = document.createElement("div");
            newRow.class = "row";
            newRow.id = `rowStudent_${lastItem}`
            newRow.innerHTML = `<div class="row">
                        <div class="col-6">
                            <label for="">Estudiante</label>
                            <select class="form-control" id="selectStudent_`+lastItem+`" onchange="onSelectStudent(`+lastItem+`);">
                                <option value="-">-</option>
                                @foreach ($estudiantes as $est)
                                    <option value="{{ $est->cod_matricula }}">
                                        {{ $est->apellidos }} {{ $est->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-danger" id="deleteStudent_`+lastItem+`" type="button" onclick="deleteFieldStudent(`+lastItem+`);"><i class="bx bx-minus bx-xs"></i></button>
                        </div>
                    </div>`;
            fieldsBody.appendChild(newRow);
            console.log(studentNumber.length);
            if(studentNumber.length>1){
                document.getElementById(`addStudent`).hidden = true;
                document.getElementById(`deleteStudent_${studentNumber[0]}`).hidden = false;
                console.log(studentNumber);
            }
        }
        function onSelectStudent(id){
            let select = document.getElementById(`selectStudent_${id}`);
            if(select.selectedIndex == 0){
                alert("Seleccione una opcion!");
                return;
            }
            let student = select.value;
            let objStudent = {"select":id,"code":student};
            if(datos.size==0 || !datos.some(e=>e.select==id)){
                datos.push(objStudent);
                return;
            }
            datos.forEach(e => {
                if(e.select == id){
                    e.code = student;
                }
            });
        }

        function deleteFieldStudent(id){
            datos = datos.filter(e=>e.select!=id);
            studentNumber = studentNumber.filter(e=>e!=id);
            document.getElementById(`rowStudent_${id}`).remove();
            document.getElementById(`deleteStudent_${studentNumber[0]}`).hidden = true;
            document.getElementById(`addStudent`).hidden = false;
        }

        function guardarGrupo(count) {
            if(datos.length == 0){
                alert("Debe seleccionar almenos un estudiante.");
                return;
            }
            let select = document.getElementById(`selectStudent_${datos[0].select}`);
            if(select.selectedIndex == 0){
                alert("Seleccione una opcion!");
                return;
            }
            if(datos.length > 1){
                if(datos[0].code == datos[1].code){
                    alert("Debe seleccionar dos estudiantes distintos.")
                    return;
                }
            }
            var chainGroup = (datos.length>1) ? datos[0].code + "_" + datos[1].code : datos[0].code;
            console.log(datos);
            document.getElementById("arreglo_grupos").value = chainGroup;
            document.form1.submit();
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
