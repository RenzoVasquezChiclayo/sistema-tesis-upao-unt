@extends('plantilla.dashboard')
@section('titulo')
    Agregar Silabo
@endsection
@section('contenido')
<style type="text/css">
    .border-box{
            margin-bottom:8px;
            margin-left:5px;
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-radius:20px;
            padding-top:5px;
            padding-bottom:10px;
    }
    textarea {
        resize:none;
    }
    table {
        table-layout: fixed;
    }
    /* .th-personalizado
        width: 130px;
        overflow: auto;
    */
    .td-personalizado {
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .p-custom {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>
<body>
    <div class="row">
        <div class="col" style="text-align: center; padding : 10px;">
            <h4>SILABO DE EXPERIENCIA CURRICULAR</h4>
        </div>
    </div>
    <div class="row" style="margin-block: 20px">
        <div class="col-8" style="margin-left: 50px">
            <h5>Asignatura</h5>
            <input class="form-control" type="text" placeholder="Ingrese la asignatura" name="txtAsignatura" id="txtAsignatura">
        </div>
    </div>
    <div class="row" style="margin: 5px;">
        <h5>I. DATOS DE IDENTIFICACION</h5>
        <div class="col-4">
            <p>1.1. Area:</p>
            <select class="form-control" name="cboArea" id="cboArea">
                <option value=""></option>
            </select>
        </div>
        <div class="col-4">
            <p>1.2. Facultad:</p>
            <select class="form-control" name="cboFacultad" id="cboFacultad">
                <option value=""></option>
            </select>
        </div>
        <div class="col-4">
            <p>1.3. Departamento Academico:</p>
            <select class="form-control" name="cboDepAcademico" id="cboDepAcademico">
                <option value=""></option>
            </select>
        </div>
    </div>
    <div class="row" style="margin: 5px;">
        <div class="col-3">
            <p>1.4. Programa de Estudios:</p>
            <select class="form-control" name="cboArea" id="cboProgramaEstudios">
                <option value=""></option>
            </select>
        </div>
        <div class="col-2">
            <p>1.5. Sede:</p>
            <select class="form-control" name="cboFacultad" id="cboSede">
                <option value=""></option>
            </select>
        </div>
        <div class="col-2">
            <p>1.6. Año Academico:</p>
            <select class="form-control" name="cboDepAcademico" id="cboYearAcademico">
                <option value=""></option>
            </select>
        </div>
        <div class="col-1">
            <p>1.7. Ciclo:</p>
            <select class="form-control" name="cboDepAcademico" id="cboCiclo">
                <option value=""></option>
            </select>
        </div>
        <div class="col-2">
            <p>1.8. Codigo de la experiencia curricular:</p>
            <select class="form-control" name="cboDepAcademico" id="cboCodAsignatura">
                <option value=""></option>
            </select>
        </div>
        <div class="col-2">
            <p>1.9. Seccion(es):</p>
            <select class="form-control" name="cboArea" id="cboSeccion">
                <option value=""></option>
            </select>
        </div>
    </div>
    <div class="row" style="margin: 5px;">
        <div class="col-2">
            <p>1.10. Creditos:</p>
            <select class="form-control" name="cboFacultad" id="cboCreditos">
                <option value=""></option>
            </select>
        </div>
        <div class="col-2">
            <p>1.11. Requisito:</p>
            <select class="form-control" name="cboDepAcademico" id="cboRequisitos">
                <option value=""></option>
            </select>
        </div>
        <div class="col-3">
            <p>1.12. Inicio:</p>
            <input type="date" class="form-control" name="cboFechaInicio" id="cboFechaInicio">
        </div>
        <div class="col-3">
            <p>1.13. Termino:</p>
            <input type="date" class="form-control" name="cboFechaTermino" id="cboFechaTermino">
        </div>
        <div class="col-2">
            <p>1.14. Organizacion semestral del tiempo(semanas):</p>
            <input type="text" class="form-control" name="txtTiempoAsignatura" id="txtTiempoAsignatura">
        </div>
    </div>
    <div class="row" style="margin: 5px;">
        <table id="table-organizacion" class="table table-bordered">
            <thead>
                <tr>
                    <td>Actividades</td>
                    <td>Total de horas</td>
                    <td>I Unidad</td>
                    <td>II Unidad</td>
                    <td>III Unidad</td>
                </tr>
            </thead>
            <tbody>

                    <tr>
                        <td>Teorias</td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>Practicas</td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>Retroalimentacion</td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>Total Horas</td>
                        <td><input class="form-control" type="text" name="" id=""></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
            </tbody>
        </table>
    </div>
    <div class="row" style="margin: 5px;">
        <p>1.14. Docente/equipo docente(s):</p>
        <div class="col-10">
            <table id="table-organizacion" class="table table-bordered">
                <thead>
                    <tr>
                        <td>CONDICION</td>
                        <td>APELLIDOS Y NOMBRES</td>
                        <td>PROFESION</td>
                        <td>EMAIL INSTITUCIONAL</td>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="margin: 5px;">
        <h5>II. SUMILLA</h5>
        <textarea class="form-control" name="" id="" cols="30" rows="6"></textarea>
    </div>
    <div class="row" style="margin: 5px;">
        <h5>III. COMPETENCIAS</h5>
        <div class="row" style="margin: 10px;">
            <div class="col-4">
                <p>UNIDAD DE COMPETENCIA 1:</p>
            </div>
            <div class="col-7">
                <input class="form-control" type="text" name="" id="">
            </div>

        </div>
        <div class="row" style="margin: 10px;">
            <textarea class="form-control" name="" id="" cols="30" rows="6"></textarea>
        </div>
        <div class="row" style="margin: 10px;">
            <div class="col-4">
                <p>UNIDAD DE COMPETENCIA 2:</p>
            </div>
            <div class="col-7">
                <input class="form-control" type="text" name="" id="">
            </div>

        </div>
        <div class="row" style="margin: 10px;">
            <textarea class="form-control" name="" id="" cols="30" rows="6"></textarea>
        </div>
        <div class="row" style="margin: 10px;">
            <div class="col-4">
                <p>UNIDAD DE COMPETENCIA 3:</p>
            </div>
            <div class="col-7">
                <input class="form-control" type="text" name="" id="">
            </div>

        </div>
        <div class="row" style="margin: 10px;">
            <textarea class="form-control" name="" id="" cols="30" rows="6"></textarea>
        </div>
    </div>
    <div class="row" style="margin: 5px;">
        <h5>IV. PROGRAMACION ACADEMICA:</h5>
        <div class="row" style="margin-left: 10px;">
            <p>UNIDAD I:</p>
            <div class="row" style="margin: 10px;">
                <div class="col-3">
                    <p>Titulo de la Unidad</p>
                </div>
                <div class="col-9">
                    <input class="form-control" type="text" name="" id="">
                </div>
            </div>

            <div class="row" style="margin-left: 10px; margin-bottom:15px;">
                <div class="col-12">
                    <p>RESULTADOS DE APRENDIZAJES</p>
                </div>
                <div class="col-12">
                    <textarea class="form-control" name="" id="" cols="30" rows="3"></textarea>
                </div>
            </div>

            <div class="row" style="margin-left: 10px;">
                <div class="col-6">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#mAgregaSesion">
                        Agregar Sesion
                    </button>
                </div>
            </div>
            <div class="row" style="margin-left: 10px; margin-top:15px;">
                <div class="col-12">
                    <table class="table table-bordered" id="sesionTable">
                        <thead>
                            <tr style="text-align: center;">
                                <td style="width:180px;">Numero de Sesion</td>
                                <td>Titulo de la Sesion</td>
                                <td style="width:180px;">Inicio</td>
                                <td style="width:180px;">Termino</td>
                                <td style="width:180px;">Acciones</td>
                            </tr>
                            <tbody id="sesionTD">

                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
    {{-- Modales --}}
        {{-- Modal para Agregar Sesion --}}
        <div class="modal" id="mAgregaSesion">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Sesion de Clase</h4>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row" style="padding-left: 10px; padding-right:10px;">
                            <div class="col-5 col-md-3">
                                <p>Numero de Sesion</p>
                            </div>
                            <div class="col-3 col-md-2">
                                <select class="form-select" name="numSesion" id="numSesion">
                                    @for ($i=1;$i<=10;$i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row" style="padding-left: 10px; padding-right:10px; margin-top:5px;">

                            <div class="col-4 col-md-2">
                                <p>Titulo de Sesion</p>
                            </div>
                            <div class="col-8 col-md-10">
                                <textarea class="form-control" name="taTituloSesion" id="taTituloSesion" style="height: 50px; resize:none"></textarea>
                            </div>
                            <div class="col-12" style="margin-top: 5px;">
                                <hr style="border: 0.2px black solid;">
                            </div>
                        </div>
                        <div class="row" style="padding-left: 10px; padding-right:10px;">
                            <div class="col-12">
                                <p>Estrategias Didacticas</p>
                            </div>
                            <div class="col-12" style="margin-bottom:10px;">
                                <div class="row">
                                    <div class="col-9">
                                        <textarea class="form-control" name="taEstrategiasDidacticas" id="taEstrategiasDidacticas" style="height: 50px; resize:none"></textarea>
                                    </div>
                                    <div class="col-3">
                                        <button id="btnAddEstrategiasDidacticas" class="btn btn-success" onclick="addEstrategiaD();">Agregar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <table class="table table-bordered" id="estrategiaDTable">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th class="th-personalizado">Estrategia Didactica</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="estrategiaTD">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <hr style="border: 0.2px black solid;">
                            </div>
                        </div>
                        <div class="row" style="padding-left: 10px; padding-right:10px;">
                            <div class="col-12">
                                <p>Evidencias de desempeño</p>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" name="taEvidenciaDesempeño" id="taEvidenciaDesempeño" style="height: 100px; resize:none"></textarea>
                            </div>
                            <div class="col-12" style="margin-top: 5px;">
                                <hr style="border: 0.2px black solid;">
                            </div>
                        </div>
                        <div class="row" style="padding-left: 10px; padding-right:10px;">
                            <div class="col-12">
                                <p>Instrumentos de Evaluacion</p>
                            </div>
                            <div class="col-12" style="margin-bottom:10px;">
                                <div class="row">
                                    <div class="col-9">
                                        <textarea class="form-control" name="taInstrumentoEval" id="taInstrumentoEval" style="height: 50px; resize:none"></textarea>
                                    </div>
                                    <div class="col-3">
                                        <button id="btnAddInstrumentoEval" class="btn btn-success" onclick="addInstrumentoEval();">Agregar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <table id="instrumentoETable" class="table table-bordered">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>Instrumento de Evaluacion</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="instrumentoTD">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <hr style="border: 0.2px black solid;">
                            </div>
                        </div>
                        <div class="row" style="padding-left: 10px; padding-right:10px;">
                            <div class="col-6">
                                <p>Inicio</p>
                                <input class="form-control" type="date" name="fechaInicio" id="fechaInicio">
                            </div>
                            <div class="col-6">
                                <p>Termino</p>
                                <input class="form-control" type="date" name="fechaTermino" id="fechaTermino">
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="clearSesion();">Close</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-warning" onclick="addSesion();">Agregar</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</body>
@endsection
@section('js')
    <script type="text/javascript">

        var iSesion =0;
        var indiceInstrumentoE = 0;
        var indiceEstrategiaD = 0;

        var lstSesion = [];
        var numSesion = [];

        var lstEstrategiaD =[];
        var estrategiaD =[];

        var lstInstrumentoE = [];
        var instrumentoE =[];

        function addSesion(){
            let tituloSesion = document.getElementById("taTituloSesion").value;
            const fechaInicio = document.getElementById("fechaInicio").value;
            const fechaTermino = document.getElementById("fechaTermino").value;
            const numeroS = document.getElementById('numSesion').value;

            deleteEspacios(estrategiaD);
            deleteEspacios(instrumentoE);

            if(numSesion.includes(numeroS)==true){
                alert('Ya existe el numero de sesion');
            }else if(tituloSesion == "" || fechaInicio == "" || fechaTermino =="" || estrategiaD.length<=0 || instrumentoE.length<=0){
                alert('Falta rellenar datos');
            }else if(fechaInicio>=fechaTermino){
                alert('La fecha de termino debe ser luego de la fecha de inicio.');
            }else{


                fila = '<tr id="filaSesion'+iSesion+'"><td class="td-personalizado"><input type="hidden" name="numSesiones[]" value="'+numeroS+'">'+numeroS+'</td><td><input type="hidden" name="sesiones[]" value="'+tituloSesion+'"><p class="p-custom">'+tituloSesion+'</p></td><td><input type="hidden" name="fechaInicio[]" value="'+fechaInicio+'">'+fechaInicio+'</td><td><input type="hidden" name="fechaTermino[]" value="'+fechaTermino+'">'+fechaTermino+'</td><td><a href="#" class="btn btn-warning" onclick="quitSesion('+iSesion+')">X</a></td></tr>';
                $('#sesionTD').append(fila);

                numSesion.push(numeroS);
                lstSesion.push(tituloSesion);
                lstEstrategiaD.push(estrategiaD);
                lstInstrumentoE.push(instrumentoE);

                iSesion++;
                clearSesion();
                $("#mAgregaSesion").modal("hide");
                //alert(lstEstrategiaD[0][1]);
            }

        }
        function quitSesion(item)
        {
            numSesion[item]="";
            //deleteEspacios(numSesion);
            lstSesion[item]="";
            lstEstrategiaD[item]="";
            lstInstrumentoE[item]="";

            $('#filaSesion'+item).remove();

        }
        function clearSesion(){
            document.getElementById('taTituloSesion').value="";
            document.getElementById('taEvidenciaDesempeño').value="";
            document.getElementById("fechaInicio").value ="";
            document.getElementById("fechaTermino").value="";

            document.getElementById('estrategiaTD').innerHTML="";
            document.getElementById('instrumentoTD').innerHTML="";

        }

        function closeModal(){
            estrategiaD=[];
            instrumentoE=[];
            indiceEstrategiaD=0;
            indiceInstrumentoE=0;
        }

        function deleteEspacios(lista){
            let lastIndice = -1;
            if(lista.length>0){
                for(let i=0; i<lista.length; i++){
                    if(lista[i]==""){
                        if(lastIndice == -1){
                            lastIndice = i;
                        }
                    }else{
                        if(lastIndice>=0){
                            lista[lastIndice] = lista[i];
                            lista[i]="";
                            lastIndice=i;
                        }
                    }
                }
                if(lastIndice!=-1 && lastIndice<lista.length){
                    for(let y = lastIndice; y<lista.length;y++){
                        lista.pop();
                    }
                }else if(lastIndice==lista.length){
                    lista.pop();
                }
            }
        }

        function addInstrumentoEval(){
            let instrumento = document.getElementById("taInstrumentoEval").value;

            fila = '<tr id="filaIE'+indiceInstrumentoE+'"><td><input type="hidden" name="instrumentosE[]" value="'+instrumento+'"><p class="p-custom">'+instrumento+'</p></td><td><a href="#" class="btn btn-warning" onclick="quitInstrumentoE('+indiceInstrumentoE+')">X</a></td></tr>';
            $('#instrumentoTD').append(fila);
            instrumentoE[indiceInstrumentoE]=instrumento;
            indiceInstrumentoE++;
            document.getElementById('taInstrumentoEval').value="";
        }
        function quitInstrumentoE(item)
        {
            $('#filaIE'+item).remove();
            instrumentoE[item]="";

        }


        function addEstrategiaD(){
            let estrategia = document.getElementById("taEstrategiasDidacticas").value;
            fila = '<tr id="filaED'+indiceEstrategiaD+'"><td><input type="hidden" name="estrategiaD[]" value="'+estrategia+'"><p class="p-custom">'+estrategia+'</p></td><td><a href="#" class="btn btn-warning" onclick="quitEstrategiaD('+indiceEstrategiaD+')">X</a></td></tr>';
            $('#estrategiaTD').append(fila);
            estrategiaD[indiceEstrategiaD]=estrategia;
            indiceEstrategiaD++;
            document.getElementById('taEstrategiasDidacticas').value="";
        }
        function quitEstrategiaD(item)
        {
            $('#filaED'+item).remove();
            estrategiaD[item]="";
        }
    </script>
@endsection
